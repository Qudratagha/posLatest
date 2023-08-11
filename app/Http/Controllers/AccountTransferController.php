<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTransfer;
use Illuminate\Http\Request;

class AccountTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AccountTransfer::all();
        return view('account.transfer.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::all();

        return view('account.transfer.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'from' => 'required',
                'to' => 'required|different:from',
                'amount' => 'required',
                'date' => 'required'
            ],
            [
                'to.different' => "From and To Accounts must be different"
            ]
        );

        $from = Account::find($request->from);
        $to = Account::find($request->to);
        $ref = getRef();
        $desc = "<strong>Transfer to ".$to->name."</strong><br>" . $request->desc;
        $desc1 = "<strong>Transfer from ".$from->name."</strong><br>" . $request->desc;

        if($from->type == 'business' && $to->type == 'business'
            || $from->type == 'customer' && $to->type == 'customer'
            || $from->type == 'business' && $to->type == 'customer'
            || $from->type == 'customer' && $to->type == 'business'){
                addTransaction($request->from, $request->date, "Transfer", 0, $request->amount, $desc, "Transfer", $ref);
                addTransaction($request->to, $request->date, "Transfer", $request->amount, 0, $desc1, "Transfer", $ref);
        }       
        if($from->type == 'Vendor' && $to->type == 'Vendor')
           {
            addTransaction($request->from, $request->date, "Transfer", $request->amount, 0, $desc, "Transfer", $ref);
            addTransaction($request->to, $request->date, "Transfer", 0, $request->amount, $desc1, "Transfer", $ref);
        }

        if($from->type == 'Vendor' && $to->type == 'Business'
            || $from->type == 'Vendor' && $to->type == 'Customer'){
                addTransaction($request->from, $request->date, "Transfer", $request->amount, 0, $desc, "Transfer", $ref);
                addTransaction($request->to, $request->date, "Transfer", $request->amount, 0, $desc1, "Transfer", $ref);
        }
        if($from->type == 'Business' && $to->type == 'Vendor'
            || $from->type == 'Customer' && $to->type == 'Vendor'){
                addTransaction($request->from, $request->date, "Transfer", 0, $request->amount, $desc, "Transfer", $ref);
                addTransaction($request->to, $request->date, "Transfer", 0, $request->amount, $desc1, "Transfer", $ref);
        }

        return redirect('/transfer');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountTransfer $accountTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountTransfer $accountTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountTransfer $accountTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountTransfer $accountTransfer)
    {
        //
    }
}
