<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
