<?php

namespace App\Http\Controllers;

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
        $ref = getRef();

        $salePayment =  SalePayment::create([
            'saleID' => $request['saleID'],
            'amount' => $request['amount'],
            'accountID' => $request['accountID'],
            'description' => $request['description'],
            'refID' => $ref,
            'date' => $request['date'],
        ]);
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
