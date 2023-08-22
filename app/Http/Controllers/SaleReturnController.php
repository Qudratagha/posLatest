<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleDelivered;
use App\Models\SaleOrder;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function index()
    {
        $saleReturns = SaleReturn::all();
        $accounts = Account::where('type', 'business')->get();
        return view('saleReturn.index', compact( 'saleReturns', 'accounts'));
    }

    public function create()
    {
        $units = Unit::all();
        $sales = Sale::all();
        return view('saleReturn.create', compact('sales', 'units'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        $customerIDs = array_filter($requestData, function ($key) {
            return strpos($key, "customerID") !== false;
        }, ARRAY_FILTER_USE_KEY);
        $saleIDs = array_filter($requestData, function ($key) {
            return strpos($key, "saleID") !== false;
        }, ARRAY_FILTER_USE_KEY);

        $customerID = array_values(array_unique($customerIDs));
        $saleID = array_values(array_unique($saleIDs));
        $ref = getRef();
        $date = Carbon::now();
        $saleReturn = SaleReturn::create([
            'saleID' => $saleID[0],
            'customerID' => $customerID[0],
            'shippingCost' => $request['shippingCost'],
            'date' => $date,
            'refID' => $ref
        ]);

        foreach ($requestData as $key => $value) {
            if (preg_match('/^saleUnit_(\d+)$/', $key, $matches)) {
                $batchNumber = $matches[1];
                $returnQty = $request['returnQuantity_' . $batchNumber];
                $returnDesc = $request['description_' . $batchNumber];
                $productID = $request['productID_' . $batchNumber];
                $saleUnit = $request['saleUnit_' . $batchNumber];
                $expiryDate = null;
                if (!empty($request['expiryDate_' . $batchNumber])) {
                    $expiryDate = date('Y-m-d H:i:s', strtotime($request['expiryDate_' . $batchNumber]));
                }
                $netUnitCost = SaleOrder::where('saleID', $saleID)->where('productID', $productID)->where('batchNumber', $batchNumber)->pluck('netUnitCost');
                SaleReturnDetail::create([
                    'saleReturnID' => $saleReturn['saleReturnID'],
                    'productID' => $productID,
                    'batchNumber' => $batchNumber,
                    'returnQuantity' => $returnQty,
                    'expiryDate' => $expiryDate,
                    'subTotal' => $returnQty * $netUnitCost[0],
                    'description' => $returnDesc,
                    'refID' => $ref,
                    'date' => $date
                ]);
            }
        }
        $request->session()->flash('message', 'Sale Return Successfully!');

        return redirect()->route('saleReturn.index')->with('success', 'Sale Return Create Successfully!' );

    }

    public function show(SaleReturn $saleReturn)
    {
        $totalAmount = $saleReturn->saleReturnDetails->sum('subTotal');
        return view('saleReturn.show', compact('saleReturn', 'totalAmount'));
     }

    public function edit(SaleReturn $saleReturn)
    {
        //
    }

    public function update(Request $request, SaleReturn $saleReturn)
    {
        //
    }

    public function destroy(SaleReturn $saleReturn)
    {
        //
    }
}
