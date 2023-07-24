@extends('layouts.admin')
@section('title', 'Purchase Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Sales
            </h3>
            <div class="card-actions">
                <a href="{{route('sale.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Add Sale
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Biller</th>
                    <th>Customer</th>
                    <th>Sale Status</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Grand Status</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection



