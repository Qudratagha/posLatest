@extends('layouts.admin')
@section('title', 'Unit Create')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i> Add New Unit
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('unit.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="name" class=" form-label required col-sm-4 col-md-2 col-lg-2  col-form-label">Unit Name: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Unit Name">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="code" class=" form-label required col-sm-4 col-md-2 col-lg-2  col-form-label" >Unit Code: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="number" name="code" class="form-control" value="{{ old('code') }}" required placeholder="Unit Code">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="parentID" class="form-label required col-sm-4 col-md-2 col-lg-2  col-form-label">Parent Unit: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4 ">
                        <select name="parentID" class="form-select">
                            <option value="">Select Parent</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->unitID }}" {{ old('parentID') == $unit->unitID ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mt-2 ">
                    <label for="operator" class=" form-label required col-sm-4 col-md-2 col-lg-2  col-form-label">Unit Operator: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="operator" class="form-control" value="{{ old('operator') }}" required placeholder="Unit Operator">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="value" class=" form-label required col-sm-4 col-md-2 col-lg-2  col-form-label">Unit Value: </label>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="number" name="value" class="form-control" value="{{ old('value') }}" required placeholder="Unit Value">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <div class="offset-2">
                        <input class="btn btn-primary" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
