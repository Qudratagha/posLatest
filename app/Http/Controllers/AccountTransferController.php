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
        //
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
