@extends('layouts.admin')
@section('title', 'Sale Show')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i>
            </h3>
            <div class="card-actions">
                <a class="btn btn-primary d-none d-sm-inline-block"  href="{{ route("sale.edit",$sale->saleID) }}" >
                    <i class="fas fa-edit"></i> Edit Sale
                </a>
            </div>
        </div>
        <div class="card-body">
            <dt>
                <div class="card-body">
                    <dl class="row">
                        <h3 class="text-center">Details</h3>
                        <div class="col-md-12">
                            <h5 class="text-center mb-3 mt-3">Sale Details</h5>
                            <dl class="row">
                                <div class="col-sm-6">
                                    <dt class="fs-5">Customer Name: </dt>
                                    <dd class="fs-5">{{ $sale->account->name }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Sale Status:</dt>
                                    <dd class="fs-5">{{ ucfirst($sale->saleStatus) }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Order Tax:</dt>
                                    <dd class="fs-5">{{ $sale->orderTax }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Discount:</dt>
                                    <dd class="fs-5">{{ $sale->discountValue }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Shipping Cost:</dt>
                                    <dd class="fs-5">{{ $sale->shippingCost }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Description:</dt>
                                    <dd class="fs-5">{{ $sale->description }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Date:</dt>
                                    <dd class="fs-5">{{ $sale->date }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-md-12">
                            <h5 class="text-center mb-3">Sale Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Warehouse</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Batch Number</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Net Unit Cost</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Tax</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($saleOrders as $order)
                                        <tr>
                                            <td>{{ $order->productID }}</td>
                                            <td>{{ $order->warehouseID }}</td>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->batchNumber ?? '' }}</td>
                                            <td>{{ $order->expiryDate ?? '' }}</td>
                                            <td>{{ $order->netUnitCost }}</td>
                                            <td>{{ $order->discount }}</td>
                                            <td>{{ $order->tax }}</td>
                                            <td>{{ $order->subTotal }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <h5 class="text-center mb-3">Sale Delivered</h5>
                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Delivered Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($saleReceives as $delivers)
                                        @php $productName = \App\Models\Product::where('productID',$delivers->productID)->pluck('name')[0];
                                        @endphp
                                        <tr>
                                            <td>{{ $productName }}</td>
                                            <td>{{ $delivers->receivedQty }}</td>
                                            <td>{{ \Carbon\Carbon::parse($delivers->date)->format('Y-m-d')  }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </dl>
                </div>


            </dt>
        </div>
    </div>

@endsection
