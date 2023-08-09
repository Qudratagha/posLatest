<?php

namespace App\Http\Controllers;

use App\Models\SaleDelivered;
use App\Models\Stock;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleDeliveredController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $ref = getRef();
        $requestData = $request->all();
        $productQuantities = [];
        $date = Carbon::now();
        foreach ($requestData as $key => $value) {
            if (strpos($key, 'receiveQty_') === 0) {
                $productId = substr($key, strlen('receiveQty_'));
                $productQuantities[$productId] = $value;
            }
        }
        foreach ($productQuantities as $productId => $receiveQty) {
            $unit = Unit::where('unitID', $request['saleUnit_'.$productId])->first();
            SaleDelivered::create([
                'saleID' => $request['saleID'],
                'productID' => $request['productID_'.$productId],
                'batchNumber' => $request['batchNumber_'.$productId],
                'saleUnit' => $request['saleUnit_'.$productId],
                'receivedQty' => $receiveQty * $unit['value'],
                'date' => $date
            ]);
            Stock::create([
                'warehouseID' =>  $request['warehouseID_'.$productId],
                'productID' => $request['productID_'.$productId],
                'batchNumber' => $request['batchNumber_'.$productId],
                'date' => $date,
                'debt' => $receiveQty * $unit['value'],
                'refID' => $ref,
            ]);
        }

        $request->session()->flash('message', 'Product Delivered Successfully!');
        return to_route('sale.index');
    }

    public function show(SaleDelivered $saleDelivered)
    {
        //
    }

    public function edit(SaleDelivered $saleDelivered)
    {
        //
    }

    public function update(Request $request, SaleDelivered $saleDelivered)
    {
        //
    }

    public function destroy(SaleDelivered $saleDelivered)
    {
        //
    }
}
