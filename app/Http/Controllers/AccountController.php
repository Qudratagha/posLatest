<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        return view('account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $account = Account::create($request->all());
        if($request->initialBalance > 0){
            $ref = getRef();
            addTransaction($account->accountID, now(), "Initial Amount", $request->initialBalance, 0,$ref, "Initial Account Balance");
        }
        $request->session()->flash('message', 'Account created Successfully!');
        return to_route('account.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $account->update($request->all());
        $request->session()->flash('message', 'Account Updated Successfully!');
        return to_route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Account $account)
    {
        $account->delete();
        $request->session()->flash('error', 'Account Deleted Successfully!');
        return to_route('account.index');
    }

    public function statement($id){
        $account = Account::find($id);
        return view('account.statement.statement', compact('account'));
    }

    public function statementDetails($id, $from, $to)
    {
        /* $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d'); */
        $items = Transaction::where('accountID', $id)->where('date', '>=', $from)->where('date', '<=', $to)->get();
        $prev = Transaction::where('accountID', $id)->where('date', '<', $from)->get();

        $p_balance = 0;
        foreach ($prev as $item) {
            $p_balance += $item->credit;
            $p_balance -= $item->debt;
        }

        $all = Transaction::where('accountID', $id)->get();

        $c_balance = 0;
        foreach ($all as $item) {
            $c_balance += $item->credit;
            $c_balance -= $item->debt;
        }
        return view('account.statement.statment_details')->with(compact('items', 'p_balance', 'c_balance'));
    }
}
