<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseStatus;
use App\Models\Sale;
use App\Models\SaleDelivered;
use App\Models\SaleOrder;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $accounts = Account::where('type', 'business')->get();
        $warehouses = Warehouse::all();
        $sales = Sale::with('saleOrders')->orderByDesc('saleID')->get();

        return view('sale.index', compact( 'accounts', 'sales', 'warehouses'));
    }

    public function create()
    {
        $units = Unit::all();
        $warehouses = Warehouse::all();
        $accounts = Account::where('type', 'customer')->get();
        $purchaseStatuses = PurchaseStatus::all();
        $products = Product::all();
        return view('sale.create', compact('warehouses', 'accounts', 'purchaseStatuses', 'products', 'units'));
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $ref = getRef();
        $warehouseID = $request['warehouseID'];
        $sale = Sale::create([
            'customerID' => $request['customerID'],
//            'orderTax' => 0,
            'saleStatus' => $request['saleStatus'],
            'discountValue' => $request['discount'],
            'shippingCost' => $request['shippingCost'],
//            'referenceNo' => $request['referenceNo'],
//            'warehouseID' => $request['warehouseID'],
//            'paymentStatus' => $request['paymentStatus'],
            'description' => $request['description'],
            'date' => $request['date'],
            'refID' => $ref,
        ]);

        foreach ($request->all() as $key => $value) {
            if (preg_match('/^quantity_(\d+)$/', $key, $matches)) {
                $pregMatchID = $matches[1];
                $productCode = $request['code_' . $pregMatchID];
                $productQuantity = $request['quantity_' . $pregMatchID];
                $productBatchNumber = $request['batchNumber_' . $pregMatchID];
                $productExpiryDate = $request['expiryDate_' . $pregMatchID];
                $productNetUnitCost = $request['netUnitCost_' . $pregMatchID];
                $productDiscount = $request['discount_' . $pregMatchID];
                $productTax = $request['tax_' . $pregMatchID];
                $productSaleUnit = $request['saleUnit_' . $pregMatchID];
                $productID = $request['productID_' . $pregMatchID];
                $subTotal = ($productNetUnitCost * $productQuantity) - $productDiscount + $productTax;
                SaleOrder::create([
                    'saleID' => $sale->saleID,
                    'productID' => $productID,
                    'warehouseID' => $warehouseID,
                    'quantity' => $productQuantity,
                    'batchNumber' => $productBatchNumber,
                    'expiryDate' => $productExpiryDate,
                    'netUnitCost' => $productNetUnitCost,
                    'discountValue' => $productDiscount,
                    'tax' => $productTax,
                    'subTotal' => $subTotal,
                    'saleUnit' => $productSaleUnit
                ]);
                SaleDelivered::create([
                    'saleID' => $sale->saleID,
                    'productID' => $productID,
                    'batchNumber' => $productBatchNumber,
                    'expiryDate' => $productExpiryDate,
                    'orderedQty' => $productQuantity,
                ]);

                Stock::create([
                    'warehouseID' =>  $warehouseID,
                    'productID' => $productID,
                    'date' => $date,
                    'batchNumber' => $productBatchNumber,
                    'expiryDate' => $productExpiryDate,
                    'credit' => $productQuantity ?? 'NULL',
                    'refID' => $ref,
                ]);
            }
        }

        $request->session()->flash('message', 'Sale Created Successfully!');
        return redirect()->route('sale.index');
    }

    public function show(Sale $sale)
    {
        $saleAmount     = $sale->saleOrders->sum('subTotal');
        $saleOrders     = $sale->saleOrders;
        $paidAmount         = $sale->salePayments->sum('amount');
        $dueAmount          = $saleAmount - $paidAmount;
        $salePayments   = $sale->salePayments;

        $saleReceives   = $sale->saleReceive()->where('orderedQty', null)->get();
        return view('sale.show', compact('saleAmount', 'saleOrders', 'paidAmount', 'dueAmount', 'salePayments', 'sale', 'saleReceives'));

    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }
}
