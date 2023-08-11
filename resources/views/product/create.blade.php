@extends('layouts.admin')
@section('title', 'Product Create')
@section('content')
    <div class="middle-content container-xxl p-0">

        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h4 class="card-title fw-semibold">
                    <i class="fas fa-users-cog"></i> Add New Product
                </h4>
                <div class="text-center">
                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        <span class="fs-6">Add Brand</span>
                    </button>
                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <span class="fs-6">Add Category</span>
                    </button>
                </div>
            </div>

            <!-- Brand Modal -->
            <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: white; color: #000000">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBrandModalLabel">Add Brand</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="{{ route('brand.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="brand" value="brand">
                                <div class="form-group row ">
                                    <label for="name" class="mb-3 form-label required col-form-label col-4">Brand Name: </label>
                                    <div class="mb-3 col-8">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="name" class="mb-3 form-label required col-form-label col-4">Active: </label>
                                    <div class="mb-3 col-8">
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="isActive" value="0" @if(!old('isActive')) checked @endif> <span class="form-check-label">Yes</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="isActive" value="1" @if(old('isActive')) checked @endif> <span class="form-check-label">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category Modal -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: white; color: #000000">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category" value="category">
                                <div class="form-group row">
                                    <label for="name" class=" form-label required col-form-label col-4">Category Name: </label>
                                    <div class="col-8">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <label for="parentID" class="form-label required col-form-label col-4">Parent Category: </label>
                                    <div class="col-8">
                                        <select name="parentID" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->categoryID }}" {{ old('parentID') == $category->categoryID ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-2 py-2">
                                    <label for="name" class="form-label required col-form-label col-4">Active: </label>
                                    <div class="col-8">
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="isActive" value="0" @if(!old('isActive')) checked @endif> <span class="form-check-label">Yes</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="isActive" value="1" @if(old('isActive')) checked @endif> <span class="form-check-label">No</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row mt-1 mb-2">
                                    <label for="tags" class="form-label col-form-label col-4">Picture: </label>
                                    <div class="col-8">
                                        <input type="file" name="image" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <form class="form-horizontal" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-1">
                        <label for="name" class="form-label required col-sm-4 col-md-6 col-lg-2  col-form-label">Product Name: </label>
                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Product Name">
                        </div>

                        <label for="code" class="form-label required col-sm-4 col-md-6 col-lg-2 col-form-label">Product Code: </label>
                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <input type="number" name="code" class="form-control" value="{{ old('code') }}" required placeholder="Product Code" onchange="productCode(this.value)">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label for="brandID" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Brand : </label>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <select name="brandID" class="form-select" required>
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->brandID }}" {{ old('brandID') == $brand->brandID ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="categoryID" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Category : </label>
                        <div class="col-sm-6 col-md-6 col-lg-4" >
                            <select name="categoryID" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->categoryID }}" {{ old('categoryID') == $category->categoryID ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label for="productUnit" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Product Unit : </label>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <select name="productUnit" class="form-select" required>
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->unitID }}" {{ old('productUnit') == $unit->unitID ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="purchasePrice" class="form-label required col-sm-6 col-md-6 col-lg-2   col-form-label">Purchase Price: </label>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <input type="number" name="purchasePrice" class="form-control" value="{{ old('purchasePrice') }}" required placeholder="Purchase Price">
                        </div>
                    </div>


                    <div class="form-group row mb-1">
                        <label for="salePrice" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Sale Price: </label>
                        <div class="col-sm-6 col-md-6 col-lg-4 {{ $errors->has('salePrice') ? 'has-error' : '' }}">
                            <input type="number" name="salePrice" class="form-control  @if($errors->has('salePrice')) is-invalid @endif" value="{{ old('salePrice') }}" required placeholder="Sale Price">
                        </div>

                        <label for="wholeSalePrice" class="form-label required col-sm-6 col-md-6 col-lg-2   col-form-label">Whole Sale Price: </label>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <input type="number" name="wholeSalePrice" class="form-control" value="{{ old('wholeSalePrice') }}" required placeholder="Whole Sale Price">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label for="alertQuantity" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Alert Quantity: </label>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <input type="number" name="alertQuantity" class="form-control" value="{{ old('alertQuantity') }}" placeholder="Alert Quantity">
                        </div>
                        <label for="description" class="form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Description: </label>
                        <div class=" col-sm-6 col-md-6 col-lg-4">
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Description">
                        </div>
                    </div>

                    <div class="form-group row mb-1">

                        <label for="image" class=" form-label col-sm-6 col-md-6 col-lg-2 col-form-label">Picture: </label>
                        <div class=" col-sm-6 col-md-6 col-lg-4">
                            <input type="file" name="image" class="form-control">
                        </div>

                        <label for="name" class=" form-label required col-sm-6 col-md-6 col-lg-2  col-form-label">Is-expiry: </label>
                        <div class="col-sm-6 col-md-6 col-lg-4 py-2">
                            <label class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="isExpire" value="0" @if(!old('isExpire')) checked @endif> <span class="form-check-label">Yes</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="isExpire" value="1" @if(old('isExpire')) checked @endif> <span class="form-check-label">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row mt-2">
                        <div class="offset-2">
                            <input class="btn btn-primary" id="saveButton" type="submit" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        function productCode(productCode) {
            $.ajax({
                url: "{{ route('ajax.handle',"getProductCode") }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    productCode: productCode,
                },
                success: function (result) {
                    if (result.length > 0 && result[0].code) {
                        alert('This code already exists.');
                        $('input[name="code"]').val('');
                    }
                }
            });
        }
        $(document).ready(function() {
            var confirmationMessage = 'You may have unsaved changes. Are you sure you want to leave?';
            var isSaveButtonClicked = false;

            $('#saveButton').on('click', function() {
                isSaveButtonClicked = true;
            });
            window.addEventListener('beforeunload', function(event) {
                if (!isSaveButtonClicked) {
                    event.returnValue = confirmationMessage;
                    return confirmationMessage;
                }
            });
        });


    </script>
@endsection
