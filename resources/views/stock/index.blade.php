@extends('layouts.admin')
@section('title', 'Stock Details')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-users-cog"></i> Stocks
            </h3>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover datatable display">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Code </th>
                        <th>Batch Number</th>
                        <th>Remaining Quantity</th>
                        <th>Unit Price</th>
                        <th>Stock Value</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($productsWithCreditDebtSum  as $product)
                        @php
                        $stockDetails = $product->productID.'_'.$product->batchNumber;
                        @endphp
                        <tr>
                            <td>{{ $product->productID }}</td>
                            <td>{{ $product->product->name }}</td>
                            <td>{{ $product->product->code }}</td>
                            <td>{{ $product->batchNumber }}</td>
                            <td>{{ $product->credit_sum - $product->debt_sum }}</td>
                            <td>{{ $product->product->purchasePrice }}</td>
                            <td>{{ ($product->product->purchasePrice) * ($product->credit_sum - $product->debt_sum) }}</td>
                            <td>
                                <a href="{{ route('stock.show', [ 'stockDetails' => $stockDetails] ) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

