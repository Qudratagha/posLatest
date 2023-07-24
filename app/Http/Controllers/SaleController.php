<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseStatus;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('sale.index', compact( 'accounts'));
    }

    public function create()
    {
        $units = Unit::all();
        $warehouses = Warehouse::all();
        $accounts = Account::where('type', 'customer')->get();
        $purchaseStatuses = PurchaseStatus::all();
        $products = Product::all();
        return view('sale.create', compact('warehouses', 'accounts', 'purchaseStatuses', 'products', 'units'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Sale $sale)
    {
        //
    }

    public function edit(Sale $sale)
    {
        //
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
