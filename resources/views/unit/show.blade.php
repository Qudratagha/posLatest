@extends('layouts.admin')
@section('title', 'Unit Show')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> {{ ucfirst($unit->name) }}
            </h3>
            <div class="card-actions">
                <a class="btn btn-primary d-none d-sm-inline-block"  href="{{ route("unit.edit",$unit->unitID) }}" >
                    <i class="fas fa-edit"></i> Edit Unit
                </a>
            </div>
        </div>
        <div class="card-body">
            <dt>
                <p class=" fs-5">Unit Name: {{ $unit->name}}</p>
                <p class=" fs-5">Unit Code: {{ $unit->code}}</p>
                <p class=" fs-5">Parent:    {{ $unit->parentID ? $unit->parentID  : '' }}</p>
                <p class=" fs-5">Unit Operator: {{ $unit->operator}}</p>
                <p class=" fs-5">Unit Value: {{ $unit->value}}</p>
            </dt>
        </div>
    </div>

@endsection
