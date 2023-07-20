@extends('layouts.admin')
@section('title', 'Warehouse Edit')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i> {{ $warehouse->name }}
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('warehouse.update', $warehouse->warehouseID) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="name" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Name: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="name" class="form-control" value="{{ old('name', $warehouse->name) }}" required placeholder="Warehouse Name">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="phone" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Phone: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="number" name="phone" class="form-control" value="{{ old('phone', $warehouse->phone) }}" required placeholder="Warehouse Phone">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="email" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Email: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="email" name="email" class="form-control" value="{{ old('email' ,$warehouse->email) }}" required placeholder="Warehouse Email">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="address" class=" form-label col-sm-4 col-md-2 col-lg-2  col-form-label">Address: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <textarea  name="address" class="form-control" required> {{ old('address', $warehouse->address) }} </textarea>
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <div class="offset-2">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
