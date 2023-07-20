<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Mime\Header\all;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('brandID', 'desc')->get();
        return view('brand.index', compact('brands'));
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(Request $request)
    {
        if ($request->has('brand')) {
            Brand::create([
                'name' => $request->name,
                'isActive' => $request->isActive,
            ]);
            $request->session()->flash('message', 'Brand created Successfully!');
            return to_route('product.create');
        }
        Brand::create([
            'name' => $request->name,
            'isActive' => $request->isActive,
        ]);
        $request->session()->flash('message', 'Brand created Successfully!');
        return to_route('brand.index');
   }

    public function show(Brand $brand)
    {
        return view('brand.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name,
            'isActive' => $request->isActive,
        ]);
        $request->session()->flash('message', 'Brand Updated successfully!');;
        return to_route('brand.index');
    }

    public function destroy(Brand $brand, Request $request)
    {
        $brand->delete();
        $request->session()->flash('error', 'Brand Deleted Successfully!');
        return to_route('brand.index');
    }
}
