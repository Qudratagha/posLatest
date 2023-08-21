<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Unit;
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
        //
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
