<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
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
        $category->delete();
        $request->session()->flash('error', 'Category Deleted Successfully!');
        return to_route('category.index');
    }
}
