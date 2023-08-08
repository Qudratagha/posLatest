<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $productsWithCreditDebtSum = Stock::with('product')
            ->select('productID', 'batchNumber', \DB::raw('SUM(credit) as credit_sum'), \DB::raw('SUM(debt) as debt_sum'))
            ->groupBy('productID', 'batchNumber')
            ->get();
        $productsWithCreditDebtSum->each(function ($stock) {
            $stock->difference = $stock->credit_sum - $stock->debt_sum;
        });
        return view('stock.index', compact('productsWithCreditDebtSum'));
    }

    public function show($stockDetails)
    {
        list($productID, $batchNumber) = explode('_', $stockDetails);
        $stocks = Stock::with('product')
            ->where('productID', $productID)
            ->where('batchNumber', $batchNumber)
            ->get();
        return view('stock.show', ['stocks' => $stocks]);
    }
}
