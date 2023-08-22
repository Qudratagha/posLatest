<?php

namespace App\Http\Controllers;

use App\Models\SaleReturn;
use App\Models\SaleReturnPayment;
use Illuminate\Http\Request;

class SaleReturnPaymentController extends Controller
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
        $ref = getRef();
        SaleReturnPayment::create([
            'saleReturnID' => $request['saleReturnID'],
            'accountID' => $request['accountID'],
            'amount' => $request['amount'],
            'description' => $request['description'],
            'date' => $request['date'],
            'refID' => $ref,
        ]);
//        $return = SaleReturn::where('purchaseReturnID', $request['purchaseReturnID'])->first();
//        addTransaction($return->supplierID, $request->date, "Purchase Return Payment", $request->amount, 0, $ref, $request['description']);
//        addTransaction($request->accountID, $request->date, "Purchase Return Payment", $request->amount, 0, $ref, $request['description']);
        $request->session()->flash('message', 'Payment Received Successfully!');
        return back();
    }

    public function show(SaleReturnPayment $saleReturnPayment)
    {
        //
    }

    public function edit(SaleReturnPayment $saleReturnPayment)
    {
        //
    }

    public function update(Request $request, SaleReturnPayment $saleReturnPayment)
    {
        //
    }

    public function destroy(SaleReturnPayment $saleReturnPayment)
    {
        //
    }
}
