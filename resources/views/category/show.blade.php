@extends('layouts.admin')
@section('title', 'Category Show')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> {{ ucfirst($category->name) }}
            </h3>
            <div class="card-actions">
                <a class="btn btn-primary d-none d-sm-inline-block"  href="{{ route("category.edit",$category->categoryID) }}" >
                    <i class="fas fa-edit"></i> Edit Category
                </a>
            </div>
        </div>
        <div class="card-body">
            <dt>
                <p class=" fs-5">Category Name: {{ $category->name}}</p>
                <p class=" fs-5">Active:{{ $category->isActive == 0 ? "Yes" : "No" }}</p>
            </dt>
        </div>
    </div>

@endsection
