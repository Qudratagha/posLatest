@extends('layouts.admin')
@section('title', 'Purchase Show')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i>
            </h3>
            <div class="card-actions">
                <a class="btn btn-primary d-none d-sm-inline-block"  href="{{ route("purchase.edit",$purchase->purchaseID) }}" >
                    <i class="fas fa-edit"></i> Edit Purchase
                </a>
            </div>
        </div>
        <div class="card-body">
            <dt>
                <div class="card-body">
                    <dl class="row">
                        <h3 class="text-center">Details</h3>
                        <div class="col-md-12">
                            <h5 class="text-center mb-3 mt-3">Purchase Details</h5>
                            <dl class="row">
                                <div class="col-sm-6">
                                    <dt class="fs-5">Supplier Name: </dt>
                                    <dd class="fs-5">{{ $purchase->account->name }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Purchase Status:</dt>
                                    <dd class="fs-5">{{ ucfirst($purchase->purchaseStatus) }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Order Tax:</dt>
                                    <dd class="fs-5">{{ $purchase->orderTax }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Shipping Cost:</dt>
                                    <dd class="fs-5">{{ $purchase->shippingCost }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Description:</dt>
                                    <dd class="fs-5">{{ $purchase->description }}</dd>
                                </div>
                                <div class="col-sm-6">
                                    <dt class="fs-5">Date:</dt>
                                    <dd class="fs-5">{{ $purchase->date }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-md-12">
                            <h5 class="text-center mb-3">Purchase Orders</h5>
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
                                    @foreach($purchaseOrders as $order)
                                        <tr>
                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->warehouse->name }}</td>
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
                            <h5 class="text-center mb-3">Purchase Receive</h5>
                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Received Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchaseReceives as $receive)
                                        <tr>
                                            <td>{{ $receive->product->name }}</td>
                                            <td>{{ $receive->receivedQty }}</td>
                                            <td>{{ \Carbon\Carbon::parse($receive->date)->format('Y-m-d')  }}</td>
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
