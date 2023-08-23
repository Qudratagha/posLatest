<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Symfony\Component\HttpKernel\DataCollector\doDump;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $purchaseReturns = PurchaseReturn::all();
        $accounts = Account::where('type', 'business')->get();

        return view('purchaseReturn.index', compact('purchaseReturns', 'accounts'));
    }

    public function create()
    {
        $products = Product::all();
        $units = Unit::all();
        $purchases = Purchase::all();
        return view('purchaseReturn.create', compact('purchases', 'units', 'products'));
    }

    public function store(Request $request)
    {
        $warehouseID = null;
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'warehouseID_') === 0) {
                $warehouseID = $value;
                break; // Exit the loop once a match is found
            }
        }

        $ref = getRef();
        $date = Carbon::now();
        $purchases = Purchase::where('purchaseID', $request['purchaseID'])->with('purchaseOrders')->first();
        $requestData = $request->all();

        /* $supplierIDs = [];
        foreach ($requestData as $key => $value) {
            if (strpos($key, 'supplierID_') === 0) {
                $supplierID = $value;
                $supplierIDs[] = $supplierID;
            }
        }
        $supplierID = $supplierIDs[0]; */
        $purchaseReturn = PurchaseReturn::create([
           'purchaseID' => $request['purchaseID'],
           'supplierID' => $purchases->supplierID,
           'shippingCost' => $request['shippingCost'],
           'date' => $date,
           'refID' => $ref
        ]);
        $total = 0;
        foreach ($requestData as $key => $value) {
            if (preg_match('/^returnQuantity_(\d+)$/', $key, $matches)) {
                $returnBatchNumber = $matches[1];
                $returnQty = $request['returnQuantity_' . $returnBatchNumber];
                $returnDesc = $request['description_' . $returnBatchNumber];
                $productID = $request['productID_' . $returnBatchNumber];
                $expiryDate = null;
                if (!empty($request['expiryDate_' . $returnBatchNumber])) {
                    $expiryDate = date('Y-m-d H:i:s', strtotime($request['expiryDate_' . $returnBatchNumber]));
                }

                $netUnitCost = PurchaseOrder::where('purchaseID', $request['purchaseID'])->where('productID', $productID)->where('batchNumber', $returnBatchNumber)->pluck('netUnitCost');
                $total += $returnQty * $netUnitCost[0];
                PurchaseReturnDetail::create([
                    'purchaseReturnID' => $purchaseReturn->purchaseReturnID,
                    'productID' => $productID,
                    'batchNumber' => $returnBatchNumber,
                    'returnQuantity' => $returnQty,
                    'expiryDate' => $expiryDate,
                    'subTotal' => $returnQty * $netUnitCost[0],
                    'description' => $returnDesc,
                    'refID' => $ref,
                    'date' => $request->date,
                ]);
                Stock::create([
                    'warehouseID' =>  $warehouseID,
                    'productID' => $productID,
                    'date' => $request->date,
                    'batchNumber' => $returnBatchNumber,
                    'expiryDate' => $expiryDate,
                    'debt' => $returnQty,
                    'refID' => $ref,
                ]);
            }
        }
        $total += $request->shippingCost;
        addTransaction($purchases->supplierID, $request->date, "Purchase Return", 0, $total, $ref, "Purchase Return Pending");
        return redirect()->route('purchaseReturn.index')->with('success', 'Purchase Return Create Successfully!' );
    }

    public function show(PurchaseReturn $purchaseReturn)
    {
        $totalAmount = $purchaseReturn->purchaseReturnDetails->sum('subTotal');
        return view('purchaseReturn.show', compact('purchaseReturn', 'totalAmount'));

    }

    public function edit(PurchaseReturn $purchaseReturn)
    {
        $units = Unit::all();
        $purchases = Purchase::all();
        return view('purchaseReturn.edit', compact('purchaseReturn','purchases', 'units'));
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        //
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        //
    }
}
