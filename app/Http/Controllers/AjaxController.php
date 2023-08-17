<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReceive;
use App\Models\Stock;
use Illuminate\Http\Request;
use function PHPUnit\TextUI\CliArguments\argument;

class AjaxController extends Controller
{
    public function handle($method, Request $request)
    {
        return $this->$method($request->all());
    }

    public static function getProduct($arguments)
    {
        $productID = $arguments['productID'];
        $products = Product::where('productID',$productID)->get();
        return response()->json($products);
    }

    public function productForSale($arguments)
    {
        $warehouseID = $arguments['warehouseID'];

        $productsWithCreditDebtSum = Stock::with('product')
            ->select('productID', 'batchNumber', \DB::raw('SUM(credit) as credit_sum'), \DB::raw('SUM(debt) as debt_sum'))
            ->where('warehouseID', $warehouseID)
            ->groupBy('productID', 'batchNumber')
            ->get();
        // Calculate the difference between credit_sum and debt_sum
        $productsWithCreditDebtSum->each(function ($stock) {
            $stock->difference = $stock->credit_sum - $stock->debt_sum;
        });
        return response()->json(['productsWithCreditDebtSum' => $productsWithCreditDebtSum]);
    }

    public function products($arguments)
    {
        $productName = $arguments['productName'];
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json($products); // Assuming you want to return a JSON response
    }

    public function getProductFromReceive($arguments)
    {
        \Illuminate\Support\Facades\DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $warehouseID = $arguments['warehouseID'];

        $productIDAndBatchNumber = $arguments['productID'];
        $underscorePosition = strpos($productIDAndBatchNumber, '_');

        $productID = substr($productIDAndBatchNumber, 0, $underscorePosition);
        $batchNumber = substr($productIDAndBatchNumber, $underscorePosition + 1);

        $productsWithCreditDebtSum = Stock::with('product')
            ->select('*', \DB::raw('SUM(credit) as credit_sum'), \DB::raw('SUM(debt) as debt_sum'))
            ->where('warehouseID', $warehouseID)
            ->where('productID', $productID)
            ->where('batchNumber', $batchNumber)
            ->groupBy('productID')
            ->get();

        // Calculate the difference between credit_sum and debt_sum
        $productsWithCreditDebtSum->each(function ($stock) {
            $stock->difference = $stock->credit_sum - $stock->debt_sum;
        });

        return response()->json($productsWithCreditDebtSum);
    }
    public function getProductCode($arguments)
    {
        $productCode = $arguments['productCode'];
        $productDetails = Product::where('code', $productCode)->get();
        return response()->json($productDetails); // Assuming you want to return a JSON response
    }

    public function getPurchase($arguments)
    {
        $purchaseID = $arguments['purchaseID'];
        $purchase = Purchase::where('purchaseID', $purchaseID)->get();
        $purchase->load('purchaseReceive');
        $purchase->load('purchaseReturns.purchaseReturnDetails');


        return response()->json(['purchase'=>$purchase]);
    }




}
