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
        $paymentAccounts = Account::where('type', 'business')->get();

        $accounts = Account::where('type', 'customer')->get();
        $purchaseStatuses = PurchaseStatus::all();
        $products = Product::all();
        return view('sale.create', compact('warehouses', 'accounts', 'purchaseStatuses', 'products', 'units', 'paymentAccounts'));
    }

    public function store(Request $request)
    {

        $date = Carbon::now();
        $ref = getRef();
        $warehouseID = $request['warehouseID'];
        $sale = Sale::create([
            'customerID' => $request['customerID'],
            'orderTax' => $request['taxAmount'],
            'saleStatus' => $request['saleStatus'],
            'discountValue' => $request['discount'],
            'shippingCost' => $request['shippingCost'],
            'referenceNo' => $request['referenceNo'],
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
                    'code' => $productCode,
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

                if($request['saleStatus'] === 'completed')
                {
                    SaleDelivered::create([
                        'saleID' => $sale->saleID,
                        'productID' => $productID,
                        'batchNumber' => $productBatchNumber,
                        'expiryDate' => $productExpiryDate,
                        'receivedQty' => $productQuantity,
                    ]);


                    Stock::create([
                        'warehouseID' =>  $warehouseID,
                        'productID' => $productID,
                        'date' => $date,
                        'batchNumber' => $productBatchNumber,
                        'expiryDate' => $productExpiryDate,
                        'debt' => $productQuantity,
                        'refID' => $ref,
                    ]);
                }
            }
        }

        $request->session()->flash('message', 'Sale Created Successfully!');
        return redirect()->route('sale.index');
    }

    public function show(Sale $sale)
    {
        $saleAmount     = $sale->saleOrders->sum('subTotal');
        $saleOrders     = $sale->saleOrders;
        $paidAmount     = $sale->salePayments->sum('amount');
        $dueAmount      = $saleAmount - $paidAmount;
        $salePayments   = $sale->salePayments;

        $saleReceives   = $sale->saleReceive()->where('orderedQty', null)->get();
        return view('sale.show', compact('saleAmount', 'saleOrders', 'paidAmount', 'dueAmount', 'salePayments', 'sale', 'saleReceives'));

    }

    public function edit(Sale $sale , Request $request)
    {
//        dd($sale->salePayments);
        foreach ($sale->saleReceive as $order) {
            $productID = $order['productID'];
            $orderedQty = $order['orderedQty'] ?? 0;
            $receivedQty = $order['receivedQty'] ?? 0;

            if (!isset($summedData[$productID])) {
                $summedData[$productID] = [
                    'productID' => $productID,
                    'orderedQty' => $orderedQty,
                    'receivedQty' => $receivedQty
                ];
            } else {
                $summedData[$productID]['orderedQty'] += $orderedQty;
                $summedData[$productID]['receivedQty'] += $receivedQty;
            }
        }
        if (!Empty($receivedQty)){
            $request->session()->flash('warning', 'You can not update this sale as it has received some products');
            return to_route('sale.index');
        }
        elseif(!$sale->salePayments->isEmpty()){
            $request->session()->flash('warning', 'You can not update this sale as it has some Payments');
            return to_route('sale.index');
        }

        $units = Unit::all();
        $warehouses = Warehouse::all();
        $accounts = Account::all();
        $purchaseStatuses = PurchaseStatus::all();
        $saleOrders = $sale->saleOrders;

        $selectedWarehouseID = $sale->saleOrders->pluck('warehouseID')->first();

        return view('sale.edit', compact('warehouses', 'accounts', 'purchaseStatuses', 'units', 'sale', 'saleOrders', 'selectedWarehouseID'));
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
