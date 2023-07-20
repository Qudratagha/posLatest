@extends('layouts.admin')
@section('title', 'Warehouse Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Warehouses
            </h3>
            <div class="card-actions">
                <a href="{{route('warehouse.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Add Warehouse
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Warehouse Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($warehouses  as $warehouse)
                    <tr>
                        <td>{{ $warehouse->warehouseID }}</td>
                        <td>{{ $warehouse->name }}</td>

                        <td>
                            <a href="{{ route('warehouse.show', $warehouse->warehouseID) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="ps-1 pe-1" href="{{ route('warehouse.edit', $warehouse->warehouseID) }}">
                                <i class="text-yellow fa fa-edit"></i>
                            </a>
                            <form action="{{ route('warehouse.destroy', $warehouse->warehouseID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" style="display: inline-block;">
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
@endsection

