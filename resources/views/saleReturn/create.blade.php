@extends('layouts.admin')
@section('title', 'Sale Return Create')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('saleReturn.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="date" class="form-label col-form-label col-sm-12 col-md-6 col-lg-2"> Date:
                        <input type="date" name="date" class="form-control" id="date" value="{{ date("Y-m-d") }}" required>
                    </label>
                    <label for="purchase" class="form-label col-form-label col-sm-12 col-md-6 col-lg-2"> Sale:
                        <select name="saleID" id="saleID" class="form-select productField" onchange="getSale(this.value)">
                            <option value="">Select Sale</option>
                            @foreach ($sales as $sale)
                                <option value="{{ $sale->saleID }}">{{ $sale->saleID }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="shippingCost" class="form-label col-form-label col-sm-12 col-md-6 col-lg-3"> Shipping Cost:
                        <input type="number" name="shippingCost" class="form-control" min="0" value="0" placeholder="Shipping Cost" >
                    </label>
                </div>

                <div class="form-group">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Return Table *</h5>
                            <div class="table-responsive table-responsive-sm mt-3">
                                <table id="myTable" class="table table-hover order-list">
                                    <thead>
                                    <tr>
                                        <th width="7%">Name</th>
                                        <th width="10%">Batch No</th>
                                        <th width="10%">Expired Date</th>
                                        <th width="10%">Delivered Quantity</th>
                                        <th width="15%">Sale Unit</th>
                                        <th width="17%">Return Quantity</th>
                                        <th>Reason</th>
                                        <th width="7%"><i class="fa fa-trash"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

{{--                <div class="form-group row">--}}
{{--                    <label for="description" class="form-label col-form-label "> Note:--}}
{{--                        <textarea type="text" name="description" rows="5" class="form-control"></textarea>--}}
{{--                    </label>--}}
{{--                </div>--}}

                <div class="form-group row mt-2">
                    <input class="btn btn-primary" id="saveButton" type="submit" value="Save">
                </div>
            </form>
        </div>

    </div>
@endsection
@section('more-script')
    <script>
        var units = @json($units);
        function getSale(saleID) {
            $('#tbody').empty();
            $.ajax({
                url: "{{ route('ajax.handle', 'getSale') }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    saleID: saleID,
                },
                success: function (result) {
                    var strHTML = '';
                    result.forEach(function (v) {
                        console.log(v);
                        let id = v.batchNumber;
                        strHTML += '<tr id="rowID_'+ id +'">';
                        strHTML += '<td> ' + v.name + '</td>';
                        strHTML += '<td>' + id + '</td>';
                        strHTML += '<td>' + (v.expiryDate || 'N/A') + '</td>';
                        strHTML += '<td>' + v.remainingQty + '</td>';
                        strHTML += '<td><select class="form-control" name="saleUnit_' + id + '" required> <option value="">Select Unit</option>';
                        units.forEach(function (unit) {
                            const isSelected = (unit.unitID === v.saleUnit) ? 'selected' : '';
                            strHTML += '<option value="' + unit.unitID + '" ' + isSelected + '>' + unit.name + '</option>';
                        });
                        strHTML += '</select></td>';
                        strHTML += '<td><input type="number" class="form-control" name="returnQuantity_' + id + '" min="0" max="' + v.remainingQty + '" oninput="validateReturnQuantity(this, ' + v.remainingQty + ')" placeholder="Return Quantity" required></td>';
                        strHTML += '<td><input type="text" class="form-control" name="description_' + id + '" placeholder="Reason"></td>';
                        strHTML += '<input type="hidden" name="saleID" value="'+v.saleID+'">';
                        strHTML += '<input type="hidden" name="customerID_' + id + '" value="'+v.customerID+'">';
                        strHTML += '<input type="hidden" name="expiryDate_' + id + '" value="'+v.expiryDate+'">';
                        strHTML += '<td><input type="hidden" name="productID_'+ id +'" value="'+v.productID+'"><button type="button" class="btn btn-sm" onclick="deleteRow(this, '+v.productID+')" id="'+v.productID+'"><i class="fa fa-trash"></i></button></td>';
                        strHTML += '</tr>';
                    });
                    $('#tbody').html(strHTML);
                }
            });
            document.getElementById("saleID").value = "";
        }

        function deleteRow(button) {
            $(button).closest('tr').remove();
        }
        function validateReturnQuantity(inputElement, maxQuantity) {
            const returnQuantity = parseInt(inputElement.value, 10);
            if (returnQuantity > maxQuantity) {
                alert('Return quantity cannot be greater than received quantity (' + maxQuantity + ').');
                inputElement.value = maxQuantity; // Reset the input value to the maximum allowed
            }
        }

        // $(document).ready(function() {
        //     var confirmationMessage = 'You may have unsaved changes. Are you sure you want to leave?';
        //     var shouldShowConfirmation = true; // Flag to control confirmation message
        //
        //     window.addEventListener('beforeunload', function(event) {
        //         if (shouldShowConfirmation) {
        //             event.returnValue = confirmationMessage;
        //             return confirmationMessage;
        //         }
        //     });
        //     $('#saveButton').click(function() {
        //         shouldShowConfirmation = false;
        //     });
        // });

    </script>
@endsection

