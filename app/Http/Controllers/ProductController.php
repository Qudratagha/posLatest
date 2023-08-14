<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::orderByDesc('productID')->get();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $units = Unit::all();
        $brands = Brand::all();
        $categories = Category::all();
        return view('product.create', compact('brands', 'categories', 'units'));
    }

    public function store(Request $request)
    {
        $product =Product::create($request->all());
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $request->file('image')->storeAs('public/images/product/' , $filename);
            $product->image = $filename;
            $product->save();
        }
        $request->session()->flash('message', 'Product created Successfully!');
        return to_route('product.index');

    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('product.edit', compact('brands', 'categories', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            Storage::delete('public/images/product/'.$product->image);
            $imageName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images/product/', $imageName);
            $input['image'] = $imageName;
        }
        $product->update($input);
        $request->session()->flash('message', 'Product Updated Successfully!');
        return to_route('product.index');

    }

    public function destroy(Product $product, Request $request)
    {
        $product->delete();
        $request->session()->flash('error', 'Product Deleted Successfully!');
        return to_route('product.index');
    }
}
