<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return view('saleReturn.index', compact( 'sales'));
    }

    public function create()
    {
        $units = Unit::all();
        $sales = Sale::all();
        return view('saleReturn.create', compact('sales', 'units'));
    }

    public function store(Request $request)
    {
        dd('remaining');
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
            if (preg_match('/^returnQuantity_(\d+)$/', $key, $matches)) {
                $returnBatchNumber = $matches[1];
                $returnQty = $request['returnQuantity_' . $returnBatchNumber];
                $returnDesc = $request['description_' . $returnBatchNumber];
                $productID = $request['productID_' . $returnBatchNumber];
//                $expiryDate = null;
//                if (!empty($request['expiryDate_' . $returnBatchNumber])) {
//                    $expiryDate = date('Y-m-d H:i:s', strtotime($request['expiryDate_' . $returnBatchNumber]));
//                }
//                SaleReturnDetail::create([
//
//
//                ]);
            }
        }


    }

    public function show(SaleReturn $saleReturn)
    {
        //
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
