<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReceive;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseReceiveController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
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
            PurchaseReceive::create([
               'purchaseID' => $request['purchaseID'],
               'productID' => $productId,
               'receivedQty' => $receiveQty,
               'date' => $date
            ]);
        }

        $request->session()->flash('message', 'Product Received Successfully!');
        return to_route('purchase.index');
    }

    public function show(PurchaseReceive $purchaseReceive)
    {
        //
    }

    public function edit(PurchaseReceive $purchaseReceive)
    {
        //
    }

    public function update(Request $request, PurchaseReceive $purchaseReceive)
    {
        //
    }

    public function destroy(PurchaseReceive $purchaseReceive)
    {
        //
    }
}
