<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('categoryID')->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $request->file('image')->storeAs('public/images/category/' , $filename);
        }
        Category::create([
            'name' => $request['name'] ,
            'image' => $filename ?? '',
            'parentID' =>  $request['parentID'],
            'isActive' => $request['isActive'],
        ]);
        if ($request->has('category')){
            $request->session()->flash('message', 'Category created Successfully!');
            return to_route('product.create');
        }
        $request->session()->flash('message', 'Category created Successfully!');
        return to_route('category.index');
    }
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            Storage::delete('public/images/category/'.$category->image);
            $imageName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images/category/', $imageName);
            $input['image'] = $imageName;
        }
        $category->update($input);
        $request->session()->flash('message', 'Category Updated Successfully!');
        return to_route('category.index');
    }

    public function destroy(Category $category, Request $request)
    {
<<<<<<< HEAD
        $check = Category::where('parentID', $category->categoryID)->count();
        if($check > 0){
            return back()->with('error', "Category Can't be deleted");
        }
        $category->delete();
        $request->session()->flash('error', 'Category Deleted Successfully!');
        return to_route('category.index');
=======

        $cat = Category::where('parentID', $category->categoryID)->count();
        $pro = Product::where('categoryID', $category->categoryID)->count();

        if($cat > 0){
            return back()->with('error', "Category Can't be deleted as it has some child categories");
        }
        elseif($pro > 0)
        {
            return back()->with('error', "Category Can't be deleted as it has some products");
        }
        else {
            $category->delete();
            $request->session()->flash('message', 'Category Deleted Successfully!');
            return to_route('category.index');
        }


>>>>>>> 56c0b3b512679e3ae643209cb31690b724e3eec9
    }
}
