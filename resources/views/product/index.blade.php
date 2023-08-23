@extends('layouts.admin')
@section('title', 'Product Index')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="fas fa-users-cog"></i> Products
        </h3>
        <div class="card-actions">
            <a href="{{route('product.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>IsExpiry</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products  as $product)
                    <tr>
                        <td>{{ $product->productID }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->isExpire == 0 ? "Yes" : "No" }}</td>
                        <td>
                            <a href="{{ route('product.show', $product->productID) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="ps-1 pe-1" href="{{ route('product.edit', $product->productID) }}">
                                <i class="text-yellow fa fa-edit"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->productID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="ps-1 pe-1" href="javascript:void(0);" onclick="$(this).closest('form').submit();">
                                    <i class="text-red fa fa-trash"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

