@extends('layouts.admin')
@section('title', 'Purchase Index')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Purchases
            </h3>
            <div class="card-actions">
                <a href="{{route('purchase.create')}}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Add Purchase
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
                    <th>Supplier</th>
                    <th>Purchase Status</th>
                    <th>Grand Total</th>
                    <th>Paid Amount</th>
                    <th>Due</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($purchases as $key => $purchase)
                    @php
                            $subTotal = $purchase->purchaseOrders->sum('subTotal');
                            $paidAmount = $purchase->purchasePayments->sum('amount');
                            $dueAmount = $subTotal - $paidAmount;
                            $allPayments = $purchase->purchasePayments;
                    @endphp
                    <tr>
                        <td>{{ $purchase->purchaseID }}</td>
                        <td>{{ $purchase->date }}</td>
                        <td>{{ $purchase->refID }}</td>
                        <td>{{ $purchase->account->name }}</td>
                        <td><div class="badge badge-success">{{ $purchase->purchaseStatus->name }}</div></td>
                        <td>{{ $subTotal }}</td>
                        <td>{{ $paidAmount }}</td>
                        <td>{{ $dueAmount }}</td>
                        <td> @if($dueAmount > 0) <div class="badge badge-danger">Due</div> @else <div class="badge badge-success">Paid</div> @endif</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle form-select" type="button" id="dropdownMenuButton_{{ $purchase->purchaseID }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $purchase->purchaseID }}">
                                    <a class="dropdown-item" href="{{ route('purchase.show', $purchase->purchaseID) }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a class="dropdown-item" href="{{ route('purchase.edit', $purchase->purchaseID) }}">
                                        <i class="text-yellow fa fa-edit"></i> Edit
                                    </a>

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#receiveProductModal_{{ $purchase->purchaseID }}">
                                        <i class="text-yellow fa fa-plus"></i> Receive Products
                                    </a>

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addPaymentModal_{{ $purchase->purchaseID }}">
                                        <i class="text-yellow fa fa-plus"></i> Add Payment
                                    </a>

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewPaymentModal_{{ $purchase->purchaseID }}">
                                        <i class="text-yellow fa fa-plus"></i> View Payments
                                    </a>

                                    <form action="{{ route('purchase.destroy', $purchase->purchaseID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="text-red fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="addPaymentModal_{{ $purchase->purchaseID }}" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> <!-- Add "modal-dialog-white" class -->
                            <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPaymentModalLabel" style="color: black; font-weight: bold">Add Payment {{ $purchase->purchaseID }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="{{ route('purchase.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="purchaseID" value="{{ $purchase->purchaseID }}">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-1">
                                                <label>Receivable Amount *</label>
                                                <input type="number" name="amount" class="form-control" value="{{ $subTotal }}" step="any" disabled>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-1">
                                                <label>Paying Amount *</label>
                                                <input type="number" name="amount" class="form-control" step="any" required>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                                                <label>Change :</label>
                                                <span>0.00</span>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-1">
                                                <label>Date</label>
                                                <input type="hidden" name="paidBy" value="a">
                                               <input type="date" name="date" id="date" class="form-control">
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label>Account: </label>
                                                <select name="accountID" class="form-select" required>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->accountID }}" {{ old('accountID') == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label>Payment Note: </label>
                                                <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input class="btn btn-primary" type="submit" value="Save">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="viewPaymentModal_{{ $purchase->purchaseID }}" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content" style="background-color: white; color: #000000">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPaymentModalLabel" style="color: black; font-weight: bold">View Payment {{ $purchase->purchaseID }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body modal-body-scrollable">
                                    <ul class="list-group">
                                        @foreach($allPayments as $payment)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong class="text-primary">Payment Date:</strong>
                                                        <span class="text-secondary">{{$payment->date}}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong class="text-primary">From Amount:</strong>
                                                        <span class="text-secondary">{{$payment->amount}}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong class="text-primary">Account:</strong>
                                                        <span class="text-secondary">{{$payment->account->name}}</span>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <strong class="text-primary">Description:</strong>
                                                        <span class="text-secondary">{{$payment->description}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="receiveProductModal_{{ $purchase->purchaseID }}" tabindex="-1" aria-labelledby="receiveProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl"> <!-- Add "modal-dialog-white" class -->
                            <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="receiveProductModalLabel" style="color: black; font-weight: bold">Receive Order Products {{ $purchase->purchaseID }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="{{ route('purchaseReceive.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="purchaseID" value="{{ $purchase->purchaseID }}">
                                        <input type="hidden" name="warehouseID" value="{{ $purchase->warehouseID }}">
                                        <?php
                                            $uniqueProducts = [];
                                            $receivedQuantity = [];
                                            $summedData = [];
                                        ?>
                                        @foreach ($purchase->purchaseReceive as $order)
                                            <?php
                                                $productID = $order['productID'];
                                                $orderedQty = $order['orderedQty'] ?? 0;
                                                $receivedQty = $order['receivedQty'] ?? 0;

                                                if (!isset($summedData[$productID])) {
                                                    $summedData[$productID] = [
                                                        'productID' => $productID,
                                                        'orderedQty' => $orderedQty,
                                                        'receivedQty' => $receivedQty
                                                    ];
                                                } else {
                                                    $summedData[$productID]['orderedQty'] += $orderedQty;
                                                    $summedData[$productID]['receivedQty'] += $receivedQty;
                                                }
                                            ?>
                                        @endforeach
                                        @php
                                            $allProductsReceived = true;
                                        @endphp
                                        @forelse ($summedData as $data)
                                            @php
                                                $modifiedOrderedQty = $data['orderedQty'] - $data['receivedQty'];
                                                $productID = $data['productID'];
                                                $productName = \App\Models\Product::where('productID', $productID)->pluck('name');
                                            @endphp
                                            @if ($modifiedOrderedQty != 0)
                                                @php echo '<pre>'; print_r($data); echo '</pre>'; $allProductsReceived = false;@endphp
                                                <input type="hidden" name="batchNumber_{{ $data['productID'] }}" class="form-control receive-quantity" value="{{ $data['batchNumber'] }}">
                                                <input type="hidden" name="expiryDate_{{ $data['productID'] }}" class="form-control receive-quantity" value="{{ $data['expiryDate'] }}">
                                                <div class="form-group row mb-3">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="form-label font-weight-bold">Product Name:</label>
                                                        <div class="form-control-plaintext">{{ $productName[0] }}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="form-label font-weight-bold">Order Quantity:</label>
                                                        <div class="form-control-plaintext">{{ $modifiedOrderedQty }}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="form-label font-weight-bold">Warehouse:</label>
                                                        <select name="warehouseID_{{ $data['productID'] }}" class="form-select">
                                                            @foreach($warehouses as $warehouse)
                                                                <option value="{{ $warehouse->warehouseID }}"> {{ $warehouse->name }} </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback" style="display: none;">Receive quantity cannot exceed order quantity.</div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="form-label font-weight-bold">Receive Quantity:</label>
                                                        <input type="number" name="receiveQty_{{ $data['productID'] }}" class="form-control receive-quantity" value="{{ $modifiedOrderedQty }}">
                                                        <div class="invalid-feedback" style="display: none;">Receive quantity cannot exceed order quantity.</div>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endif
                                        @empty
                                            <p>No</p>
                                        @endforelse

                                        @if ($allProductsReceived)
                                            <div class="text-center mb-3 ">
                                                <span class="fw-bold" style="font-size: 1.2rem;">All Products Received</span>
                                            </div>
                                        @endif

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input class="btn btn-primary" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        $(document).ready(function() {
            $('.receive-quantity').on('input', function() {
                var orderQty = parseInt($(this).parent().prev().find('.form-control-static').text());
                var receiveQty = parseInt($(this).val());

                if (receiveQty > orderQty) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').hide();
                }
            });
        });
    </script>
@endsection



