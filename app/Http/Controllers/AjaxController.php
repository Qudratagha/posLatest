<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $productsWithCreditSum = Stock::with('product')
            ->select('productID', \DB::raw('SUM(credit) as credit_sum'))
            ->where('warehouseID', $warehouseID)
            ->groupBy('productID')
            ->get();
        return response()->json(['productsWithCreditSum' => $productsWithCreditSum]);
    }

    public function products($arguments)
    {

        $productName = $arguments['productName'];
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json($products); // Assuming you want to return a JSON response
    }
}
