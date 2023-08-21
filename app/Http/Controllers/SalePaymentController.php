<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Http\Request;

class SalePaymentController extends Controller
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
//        dd($request->all());

        $salePayment =  SalePayment::create([
            'saleID' => $request['saleID'],
            'amount' => $request['amount'],
            'accountID' => $request['accountID'],
            'description' => $request['description'],
            'refID' => $ref,
            'date' => $request['date'],
        ]);

        $sale = Sale::find($request->saleID);
        addTransaction($sale->customerID, $request->date, "Sale Payment", 0, $request->amount, $sale->refID, "Payment of Sale #".$request->saleID);
        addTransaction($request->accountID, $request->date, "Sale Payment", $request->amount, 0, $sale->refID, "Payment of Sale #".$request->saleID);
        $request->session()->flash('message', 'Sale Payment Created Successfully!');
        return redirect()->route('sale.index');
    }

   public function show(SalePayment $salePayment)
    {
        //
    }

    public function edit(SalePayment $salePayment)
    {
        //
    }

    public function update(Request $request, SalePayment $salePayment)
    {
        //
    }

    public function destroy(SalePayment $salePayment)
    {
        //
    }
}
