@extends('layouts.admin')
@section('title', 'Category Create')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i> {{ $product->name }}
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('product.update',$product->productID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row mb-1">
                    <label for="name" class="form-label required col-sm-4 col-md-6 col-lg-2  col-form-label">Product Name: </label>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <label for="code" class="form-label required col-sm-4 col-md-6 col-lg-2 col-form-label">Product Code: </label>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <input type="number" name="code" class="form-control" value="{{ old('code',  $product->code) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="brandID" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Brand : </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <select name="brandID" class="form-select" required>
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->brandID }}" {{ old('brandID', $product->brandID) == $brand->brandID ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="categoryID" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Category : </label>
                    <div class="col-sm-6 col-md-6 col-lg-4" >
                        <select name="categoryID" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->categoryID }}" {{ old('categoryID', $product->categoryID) == $category->categoryID ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="productUnit" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Product Unit: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <input type="number" name="productUnit" class="form-control" value="{{ old('productUnit', $product->productUnit) }}" required>
                    </div>
                    <label for="salePrice" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Sale Price: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <input type="number" name="salePrice" class="form-control" value="{{ old('salePrice', $product->salePrice) }}" required>
                    </div>
                </div>


                <div class="form-group row mb-1">
                    <label for="purchasePrice" class="form-label required col-sm-6 col-md-6 col-lg-2   col-form-label">Purchase Price: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <input type="number" name="purchasePrice" class="form-control" value="{{ old('purchasePrice', $product->purchasePrice) }}" required>
                    </div>
                    <label for="wholeSalePrice" class="form-label required col-sm-6 col-md-6 col-lg-2   col-form-label">Whole Sale Price: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <input type="number" name="wholeSalePrice" class="form-control" value="{{ old('wholeSalePrice', $product->wholeSalePrice) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="alertQuantity" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Alert Quantity: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <input type="number" name="alertQuantity" class="form-control" value="{{ old('alertQuantity', $product->alertQuantity) }}" required>
                    </div>
                    <label for="description" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Description: </label>
                    <div class=" col-sm-6 col-md-6 col-lg-4">
                        <input type="text" name="description" class="form-control" value="{{ old('description', $product->description) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <label for="image" class=" form-label col-sm-6 col-md-6 col-lg-2 col-form-label">Picture: </label>
                    <div class=" col-sm-6 col-md-6 col-lg-4">
                        <input type="file" name="image" class="form-control" value="{{ $product->image }}">
                        <img width="30%" class="mt-2 img-circle" src="{{ asset('storage/images/product/'.$product->image) }}" />
                    </div>

                    <label for="name" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Is-Expiry: </label>
                    <div class="col-sm-6 col-md-6 col-lg-4 py-2">
                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="isExpire" value="0" @if($product->isExpire == 0) checked @endif> <span class="form-check-label">Yes</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="isExpire" value="1" @if( $product->isExpire == 1) checked @endif> <span class="form-check-label">No</span>
                        </label>
                    </div>
                </div>



{{--                <div class="form-group row mt-3 ">--}}
{{--                    <label for="name" class="mb-3 form-label required col-sm-4 col-md-2 col-lg-2  col-form-label">Active: </label>--}}
{{--                    <div class="col-sm-4 col-md-4 col-lg-4">--}}
{{--                        <label class="form-check form-check-inline">--}}
{{--                            <input type="radio" class="form-check-input" name="isActive" value="0" @if( $category->isActive == 0 ) checked @endif> <span class="form-check-label">Yes</span>--}}
{{--                        </label>--}}
{{--                        <label class="form-check form-check-inline">--}}
{{--                            <input type="radio" class="form-check-input" name="isActive" value="1" @if( $category->isActive == 1) checked @endif> <span class="form-check-label">No</span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row mt-3">--}}
{{--                    <label for="tags" class="mb-3 form-label col-sm-4 col-md-2 col-lg-2 col-form-label">Picture: </label>--}}
{{--                    <div class="mb-3 col-sm-8 col-md-4 col-lg-4 {{ $errors->has('image') ? 'has-error' : '' }}">--}}
{{--                        <input type="file" name="image" class="form-control @if($errors->has('image')) is-invalid @endif" value="{{ $category->image }}">--}}
{{--                        <img width="30%" class="mt-2 img-circle" src="{{ asset('storage/images/category/'.$category->image) }}" />--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="form-group row">
                    <div class="offset-2">
                        <input class="btn btn-primary" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
