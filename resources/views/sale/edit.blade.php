@extends('layouts.admin')
@section('title', 'Sale Edit')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i>Edit Sale
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('sale.update',$sale->saleID) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="purchaseID" value="{{ $sale->saleID }}">
                <div class="form-group row">

                    <div class="form-group row">
                        <label for="date" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Date:
                            <input type="date" name="date" class="form-control" id="date" value="{{ old('date', $sale->date) }}" required>
                        </label>

                        <label for="referenceNo" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Reference No:
                            <input type="number" name="referenceNo" class="form-control" value="{{ old('referenceNo', $sale->referenceNo) }}" required>
                        </label>

                        <label for="customerID" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Customer:
                            <select name="customerID" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->accountID }}" {{ old('customerID') == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>


                    <label for="warehouse" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Warehouse:
                        <select name="warehouseID" class="form-select">
                            <option value="">Select Warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->warehouseID }}" {{ old('warehouseID', $selectedWarehouseID) == $warehouse->warehouseID ? 'selected' : ''   }}>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label for="supplier" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Supplier:
                        <select name="customerID" class="form-select">
                            <option value="">Select Supplier</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->accountID }}" {{ old('customerID', $sale->customerID) == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>


                <div class="form-group row">
                    <label for="productID" class="form-label col-form-label col-sm-12"> Products:
                        <div class="col-sm-12">
                            <select name="productID" id="productID" class="form-select productField" onchange="productDetails(this.value)">
                                <option value="">Select Product</option>
                            </select>
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Order Table *</h5>
                            <div class="table-responsive table-responsive-sm mt-3">
                                <table id="myTable" class="table table-hover order-list">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th width="12%">Quantity</th>
                                        <th width="12%">Batch No</th>
                                        <th width="8%">Expired Date</th>
                                        <th width="10%">Net Unit Cost</th>
                                        <th width="10%">Purchase Unit</th>
                                        <th width="10%">Discount</th>
                                        <th width="10%">Tax</th>
                                        <th>SubTotal</th>
                                        <th width="4"><i class="fa fa-trash"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @foreach($saleOrders as $order)
                                        <tr id="rowID_{{ $order->productID }}">
                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->code }}</td>
                                            <td><input type="number" class="form-control" name="quantity_{{$order->productID}}" value="{{ $order->quantity }}" onkeyup="changeQuantity(this,{{$order->productID}})" style="border: none"></td>
                                            <td><input type="number" class="form-control" name="batchNumber_{{$order->productID}}" value="{{ $order->batchNumber }}"></td>
                                            <td style="text-align: center;">
                                                @if($order->expiryDate == '')
                                                    <div style="display: inline-block; text-align: center;">N/A</div>
                                                @else
                                                    <input type="date" class="form-control" id="date" name="expiryDate_{{$order->productID}}" value="{{ $order->expiryDate }}">
                                                @endif
                                            </td>
                                            <td><input type="number" class="form-control" name="netUnitCost_{{$order->productID}}" min="1" value="{{ $order->netUnitCost }}" onkeyup="changeNetUnitCost(this, {{$order->productID}})" > </td>
                                            <td>
                                                <select name="purchaseUnit_{{$order->productID}}" id="" class="form-select">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->unitID }}" @if ($unit->unitID == $order->purchaseUnitID) selected @endif > {{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" name="discount_{{$order->productID}}" min="0" value="{{ $order->discount }}" onkeyup="changeDiscount(this, {{$order->productID}} )"></td>
                                            <td><input type="number" class="form-control" name="tax_{{$order->productID}}" min="0" value="{{ $order->tax }}" onkeyup="changeTax(this, {{$order->productID}})"></td>
                                            <td> <span id="subTotal_{{$order->productID}}"> {{ $order->subTotal }} </span></td>
                                            <input type="hidden" name="code_{{ $order->productID }}" value="{{ $order->code }}">
                                            <input type="hidden" name="netUnitCost_{{ $order->productID }}" value="{{ $order->netUnitCost }}">


                                            <td><input type="hidden" name="productID_{{ $order->productID }}" value=""><button type="button" class="btn btn-sm" onclick="deleteRow(this, {{$order->productID}})"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <thead class="active" style="font-weight: bolder; font-size: large; color: red">
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th id="total-qty">0</th>
                                        <th class="recieved-product-qty d-none"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="total-discount">0.00</th>
                                        <th id="total-tax">0.00</th>
                                        <th id="total">0.00</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="orderTax" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Order Tax:
                        <select name="orderTax" id="orderTax" class="form-select">
                            <option value="No" >No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </label>

                    <label for="taxAmount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4 d-none" id="taxAmountLabel"> Tax Amount:
                        <input type="number" name="taxAmount" id="taxAmount" class="form-control" placeholder="Tax Amount">
                    </label>

                    <label for="discount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Discount:
                        <input type="number" name="discount" class="form-control" min="0" value="{{ $sale->discount }}" >
                    </label>

                    <label for="shippingCost" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Shipping Cost:
                        <input type="number" name="shippingCost" class="form-control" min="0" value="{{ $sale->shippingCost }}">
                    </label>
                </div>
                <div class="form-group row">
                    <label for="description" class="form-label col-form-label "> Note:
                        <textarea type="text" name="description" rows="5" class="form-control">{{ $sale->description }}</textarea>
                    </label>
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

@section('more-script')
    <script>

        $(document).ready(function() {
            var selectedWarehouseID = $('select[name="warehouseID"]').val();
            getProduct(selectedWarehouseID);

        });
        $(document).ready(function() {
            $('.productField').select2();
            // var selectedWarehouseID = $('#warehouseID').val();
            // console.log(selectedWarehouseID);
        })

        function getProduct(warehouseID) {
            if (warehouseID !== '') {
                $.ajax({
                    url: "{{ route('ajax.handle',"productForSale") }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        warehouseID: warehouseID
                    },
                    success: function(response) {
                        $('#productID').empty();
                        $('#productID').append('<option value="">Select Product</option>');
                        $.each(response.productsWithCreditSum, function(index, product) {
                            $('#productID').append('<option value="' + product.productID+ '_'+ product.batchNumber + '">' + product.product.name +' | '+ product.batchNumber +' | '+ product.credit_sum + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch products.');
                    }
                });
            } else {
                $('#productID').empty().append('<option value="">Select Product</option>');
            }
        }

        var units = @json($units);
        var existingProducts = [];
        function getSelectedWarehouseID() {
            return  $('select[name="warehouseID"]').val();
        }

        function productDetails(productID)
        {
            var warehouseID = getSelectedWarehouseID();
            var strHTML = "";
            $.ajax({
                url: "{{ route('ajax.handle',"getProductFromReceive") }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    warehouseID : warehouseID,
                    productID: productID,
                },
                success: function (result) {
                    {
                        // let found = $.grep(existingProducts, function(element) {
                        //     return element === result[0].batchNumber;
                        // });
                        // if (found.length > 0)
                        // {
                        //     var rowId = result[0].batchNumber;
                        //     var row = $("#tbody #" +'rowID_'+ rowId);
                        //     var quantityInput = row.find('[name="quantity_' + rowId + '"]');
                        //     var netUnitCostInput = row.find('input[name="netUnitCost_' + rowId + '"]');
                        //     var discountInput = row.find('[name="discount_' + rowId + '"]');
                        //     var taxInput = row.find('[name="tax_' + rowId + '"]');
                        //     var quantity = parseInt(quantityInput.val());
                        //     var netUnitCost = parseInt(netUnitCostInput.val());
                        //     var discount = parseInt(discountInput.val());
                        //     var tax = parseInt(taxInput.val());
                        //     quantity++;
                        //     quantityInput.val(quantity);
                        //     var subtotal = (quantity * netUnitCost) - discount + tax;
                        //     $('td:has(span#subTotal_' + rowId + ')').find('span#subTotal_' + rowId).text(subtotal);
                        //
                        // }else {
                        //     result.forEach(function (v) {
                        //         let id = v.batchNumber;
                        //         strHTML += '<tr id="rowID_' + v.batchNumber + '">';
                        //         strHTML += '<td>' + v.product.name + '</td>';
                        //         strHTML += '<td>' + v.product.code + '</td>';
                        //         strHTML += '<td class="row align-items-center"><div class="col-8"><input type="number" class="form-control" name="quantity_' + v.batchNumber + '" min="1" max="' + v.credit_sum + '" value="1" onchange="changeQuantity(this, ' + id + ')" style="border: none"> </div> <div class="col-4"><span>' + v.credit_sum + '</span> </div></td>';
                        //         strHTML += '<td><input type="number" class="form-control" name="batchNumber_' + v.batchNumber + '" value="' + v.batchNumber + '"></td>';
                        //         strHTML += `<td style="text-align: center;">${
                        //             v.product.isExpire === 0 ?
                        //                 `<input type="date" id="date" class="form-control" name="expiryDate_${v.batchNumber}" value="${getCurrentDate()}">`
                        //                 : '<div style="display: inline-block; text-align: center;">N/A</div>'
                        //         }</td>`;
                        //         strHTML += '<td><input type="number" class="form-control" name="netUnitCost_' + v.batchNumber + '" min="1" value="' + v.product.purchasePrice + '" onkeyup="changeNetUnitCost(this, ' + id + ')" > </td>';
                        //         strHTML += '<td width="10%"><select class="form-control" name="saleUnit_' + v.batchNumber + '">';
                        //         units.forEach(function (unit) {
                        //             strHTML += '<option value="' + unit.unitID + '">' + unit.name + '</option>';
                        //         });
                        //         strHTML += '</select></td>';
                        //         strHTML += '<td><input type="number" class="form-control" name="discount_' + v.batchNumber + '" min="0" value="0" onkeyup="changeDiscount(this, ' + id + ')"></td>';
                        //         strHTML += '<td><input type="number" class="form-control" name="tax_' + v.batchNumber + '" min="0" value="0" onkeyup="changeTax(this, ' + id + ')"></td>';
                        //         strHTML += '<td> <span id="subTotal_' + v.batchNumber + '">' + v.product.purchasePrice + '</span></td>';
                        //         strHTML += '<td><input type="hidden" name="productID_' + v.batchNumber + '" value="' + v.productID + '"><button type="button" class="btn btn-sm" onclick="deleteRow(this, ' + v.productID + ')" id="' + v.productID + '"><i class="fa fa-trash"></i></button></td>';
                        //         // strHTML += '<input type="hidden" name="netUnitCost_'+ v.productID +'" value="' + v.product.purchasePrice + '">';
                        //         strHTML += '<input type="hidden" name="code_'+ v.productID +'" value="' + v.product.code + '">';
                        //         strHTML += '</tr>';
                        //     });
                        //     if (!existingProducts.includes(result[0].batchNumber)) {
                        //         existingProducts.push(result[0].batchNumber);
                        //     }
                        // }
                    }
                    // $('#tbody').append(strHTML);
                    // footerData();
                }
            });
            // document.getElementById("productID").value = "";
        }




        {{--        var units = @json($units);--}}
{{--        var existingProducts = [];--}}
{{--        var productsArr = @json($purchaseOrders);--}}
{{--        productsArr.forEach(function(item) {--}}
{{--            if (!existingProducts.includes(item.productID))--}}
{{--            {--}}
{{--                existingProducts.push(item.productID);--}}
{{--            }--}}
{{--        });--}}

{{--        $(document).ready(function() {--}}
{{--            // Your code here--}}
{{--            var totalQuantity = 0;--}}
{{--            var totalDiscount = 0;--}}
{{--            var totalTax = 0;--}}
{{--            var subTotalAmount = 0;--}}

{{--            $('tr').each(function() {--}}
{{--                var quantityInput = $(this).find('input[name^="quantity_"]');--}}
{{--                var quantity = parseInt(quantityInput.val());--}}
{{--                if (!isNaN(quantity)) {--}}
{{--                    totalQuantity += quantity;--}}
{{--                }--}}
{{--                $('th#total-qty').text(totalQuantity);--}}

{{--                var discountInput = $(this).find('input[name^="discount_"]');--}}
{{--                var discount = parseInt(discountInput.val());--}}
{{--                if (!isNaN(discount)) {--}}
{{--                    totalDiscount += discount;--}}
{{--                }--}}

{{--                $('th#total-discount').text(totalDiscount);--}}

{{--                var taxInput = $(this).find('input[name^="tax_"]');--}}
{{--                var tax = parseInt(taxInput.val());--}}
{{--                if (!isNaN(tax)) {--}}
{{--                    totalTax += tax;--}}
{{--                }--}}

{{--                $('th#total-tax').text(totalTax);--}}

{{--                var subtotalSpan = $(this).find('span[id^="subTotal_"]');--}}
{{--                var subtotalValue = parseFloat(subtotalSpan.text().trim());--}}
{{--                if (!isNaN(subtotalValue)) {--}}
{{--                    subTotalAmount += subtotalValue;--}}
{{--                }--}}

{{--                $('th#total').text(subTotalAmount);--}}
{{--            });--}}
{{--        });--}}

{{--        $('#orderTax').change(function() {--}}
{{--            var selectedValue = $(this).val();--}}
{{--            if (selectedValue === 'Yes') {--}}
{{--                $('#taxAmountLabel').removeClass('d-none');--}}
{{--            } else {--}}
{{--                $('#taxAmountLabel').addClass('d-none');--}}
{{--            }--}}
{{--        });--}}

{{--        function getProduct(productID) {--}}
{{--            var strHTML = "";--}}
{{--            $.ajax({--}}
{{--                url: "{{ route('ajax.handle',"getProduct") }}",--}}
{{--                method: 'post',--}}
{{--                data: {--}}
{{--                    _token: "{{ csrf_token() }}",--}}
{{--                    productID: productID,--}}
{{--                },--}}
{{--                success: function (result) {--}}
{{--                    let found = $.grep(existingProducts, function(element) {--}}
{{--                        return element === result[0].productID;--}}
{{--                    });--}}
{{--                    if (found.length > 0) {--}}
{{--                        var rowId = result[0].productID; // Example row id--}}
{{--                        var row = $("#tbody #" +'rowID_'+ rowId); // Select the row based on the id--}}
{{--                        var quantityInput = row.find('[name="quantity_' + rowId + '"]');--}}
{{--                        var netUnitCostInput = row.find('input[name="' + 'netUnitCost_' + rowId + '"]').val();--}}
{{--                        var discountInput = row.find('[name="discount_' + rowId + '"]').val();--}}
{{--                        var taxInput = row.find('[name="tax_' + rowId + '"]').val();--}}
{{--                        var quantity = parseInt(quantityInput.val());--}}
{{--                        var netUnitCost = parseInt(netUnitCostInput);--}}
{{--                        var discount = parseInt(discountInput);--}}
{{--                        var tax = parseInt(taxInput);--}}
{{--                        quantity++;--}}
{{--                        quantityInput.val(quantity);--}}
{{--                        var subtotal = (quantity * netUnitCost) - discount + tax;--}}
{{--                        $('td:has(span#subTotal_' + rowId + ')').find('span#subTotal_' + rowId).text(subtotal);--}}
{{--                    } else {--}}
{{--                        result.forEach(function (v) {--}}
{{--                            let id = v.productID;--}}
{{--                            strHTML += '<tr id="rowID_'+ v.productID +'">';--}}
{{--                            strHTML += '<td>' + v.name + '</td>';--}}
{{--                            strHTML += '<td>' + v.code + '</td>';--}}
{{--                            strHTML += '<td><input type="number" class="form-control" name="quantity_'+v.productID+'" min="1" value="1" onkeyup="changeQuantity(this, '+id+')" style="border: none"></td>';--}}
{{--                            strHTML += '<td><input type="number" class="form-control" name="batchNumber_'+v.productID+'" value=""></td>';--}}
{{--                            strHTML += `<td style="text-align: center;">${--}}
{{--                                v.isExpire === 0 ?--}}
{{--                                    `<input type="date" id="date" class="form-control" name="expiryDate_${v.productID}" value="">`--}}
{{--                                    : '<div style="display: inline-block; text-align: center;">N/A</div>'--}}
{{--                            }</td>`;--}}
{{--                            strHTML += '<td><input type="number" class="form-control" name="netUnitCost_'+v.productID+'" min="1" value="'+ v.purchasePrice +'" onkeyup="changeNetUnitCost(this, '+id+')" > </td>';--}}
{{--                            strHTML += '<td width="10%"><select class="form-control" name="purchaseUnit_'+v.productID+'">';--}}
{{--                            units.forEach(function(unit) {--}}
{{--                                strHTML += '<option value="' + unit.unitID + '">' + unit.name + '</option>';--}}
{{--                            });--}}
{{--                            strHTML += '</select></td>';--}}
{{--                            strHTML += '<td><input type="number" class="form-control" name="discount_'+v.productID+'" min="0" value="0" onkeyup="changeDiscount(this, '+id+')"></td>';--}}
{{--                            strHTML += '<td><input type="number" class="form-control" name="tax_'+v.productID+'"  min="0" value="0" onkeyup="changeTax(this, '+id+')"></td>';--}}
{{--                            strHTML += '<td> <span id="subTotal_'+v.productID+'">' + v.purchasePrice + '</span></td>';--}}
{{--                            strHTML += '<input type="hidden" name="netUnitCost_'+ v.productID +'" value="' + v.purchasePrice + '">';--}}
{{--                            strHTML += '<input type="hidden" name="code_'+ v.productID +'" value="' + v.code + '">';--}}
{{--                            strHTML += '<td><input type="hidden" name="productID_'+v.productID+'" value="'+v.productID+'"><button type="button" class="btn btn-sm" onclick="deleteRow(this, '+v.productID+')" id="'+v.productID+'"><i class="fa fa-trash"></i></button></td>';--}}
{{--                            strHTML += '</tr>';--}}
{{--                        });--}}
{{--                        $('#tbody').append(strHTML);--}}
{{--                    }--}}
{{--                    if (!existingProducts.includes(result[0].productID))--}}
{{--                    { existingProducts.push(result[0].productID);}--}}
{{--                    rowData();--}}
{{--                }--}}
{{--            });--}}
{{--            document.getElementById("productID").value = "";--}}

{{--        }--}}

{{--        function changeQuantity(input, id) {--}}
{{--            let row = $(input).closest('tr');--}}
{{--            let quantity = row.find('input[name="quantity_' + id + '"]').val();--}}
{{--            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();--}}
{{--            let quantityIntoUnitCost = quantity * netUnitCost;--}}
{{--            var discountInput = row.find('input[name="discount_' + id + '"]').val();--}}
{{--            var taxInput = row.find('input[name="tax_' + id + '"]').val();--}}
{{--            var discount = parseInt(discountInput);--}}
{{--            if (isNaN(discount)){--}}
{{--                discount = 0;--}}
{{--            }--}}
{{--            var tax = parseInt(taxInput);--}}
{{--            if (isNaN(tax)){--}}
{{--                tax = 0;--}}
{{--            }--}}
{{--            var subtotal = quantityIntoUnitCost - discount + tax;--}}
{{--            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);--}}
{{--            rowData();--}}
{{--        }--}}

{{--        function changeDiscount(input, id) {--}}
{{--            let row = $(input).closest('tr');--}}
{{--            let quantity = row.find('input[name="quantity_' + id + '"]').val();--}}
{{--            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();--}}
{{--            let quantityIntoUnitCost = quantity * netUnitCost;--}}
{{--            var discountInput = row.find('input[name="discount_' + id + '"]').val();--}}
{{--            var discount = parseInt(discountInput);--}}
{{--            if(isNaN(discount)){--}}
{{--                discount = 0;--}}
{{--            }--}}
{{--            var taxInput = row.find('input[name="tax_' + id + '"]').val();--}}
{{--            var tax = parseInt(taxInput);--}}
{{--            if(isNaN(tax)){--}}
{{--                tax = 0;--}}
{{--            }--}}
{{--            var subtotal = quantityIntoUnitCost - discount + tax;--}}
{{--            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);--}}
{{--            rowData();--}}
{{--        }--}}

{{--        function changeTax(input, id) {--}}
{{--            let row = $(input).closest('tr');--}}
{{--            let quantity = row.find('input[name="quantity_' + id + '"]').val();--}}
{{--            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();--}}
{{--            let quantityIntoUnitCost = quantity * netUnitCost;--}}
{{--            var discountInput = row.find('input[name="discount_' + id + '"]').val();--}}
{{--            var taxInput = row.find('input[name="tax_' + id + '"]').val();--}}
{{--            var discount = parseInt(discountInput);--}}
{{--            if(isNaN(discount)){--}}
{{--                discount = 0;--}}
{{--            }--}}
{{--            var tax = parseInt(taxInput);--}}
{{--            if(isNaN(tax)){--}}
{{--                tax = 0;--}}
{{--            }--}}
{{--            var subtotal = quantityIntoUnitCost - discount + tax;--}}
{{--            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);--}}
{{--            rowData();--}}
{{--        }--}}
{{--        function deleteRow(button, id) {--}}
{{--            existingProducts = $.grep(existingProducts, function(value) {--}}
{{--                return value !== id;--}}
{{--            });--}}
{{--            $(button).closest('tr').remove();--}}
{{--            rowData();--}}

{{--        }--}}

{{--        function changeNetUnitCost(input, id) {--}}
{{--            let row = $(input).closest('tr');--}}
{{--            let quantity = row.find('input[name="quantity_' + id + '"]').val();--}}
{{--            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();--}}
{{--            let quantityIntoUnitCost = quantity * netUnitCost;--}}
{{--            var discountInput = row.find('input[name="discount_' + id + '"]').val();--}}
{{--            var taxInput = row.find('input[name="tax_' + id + '"]').val();--}}
{{--            var discount = parseInt(discountInput);--}}
{{--            if (isNaN(discount)){--}}
{{--                discount = 0;--}}
{{--            }--}}
{{--            var tax = parseInt(taxInput);--}}
{{--            if (isNaN(tax)){--}}
{{--                tax = 0;--}}
{{--            }--}}
{{--            var subtotal = quantityIntoUnitCost - discount + tax;--}}
{{--            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);--}}
{{--            rowData()--}}
{{--        }--}}

{{--        function rowData(){--}}
{{--            var subTotalAmount = 0;--}}
{{--            var totalQuantity = 0;--}}
{{--            var totalDiscount = 0;--}}
{{--            var totalTax = 0;--}}
{{--            $('tr').each(function() {--}}
{{--                var quantityInput = $(this).find('input[name^="quantity_"]');--}}
{{--                var quantity = parseInt(quantityInput.val());--}}
{{--                if (!isNaN(quantity)) {--}}
{{--                    totalQuantity += quantity;--}}
{{--                }--}}
{{--                $('th#total-qty').text(totalQuantity).html();--}}
{{--                var subtotalSpan = $(this).find('span[id^="subTotal_"]');--}}
{{--                var subtotalValue = parseFloat(subtotalSpan.text().trim());--}}
{{--                if (!isNaN(subtotalValue)) {--}}
{{--                    subTotalAmount += subtotalValue;--}}
{{--                }--}}
{{--                $('th#total').text(subTotalAmount).html();--}}
{{--                var discountInput = $(this).find('input[name^="discount_"]');--}}
{{--                var discount = parseInt(discountInput.val());--}}
{{--                if (!isNaN(discount)) {--}}
{{--                    totalDiscount += discount;--}}
{{--                }--}}
{{--                $('th#total-discount').text(totalDiscount).html();--}}
{{--                var taxInput = $(this).find('input[name^="tax_"]');--}}
{{--                var tax = parseInt(taxInput.val());--}}
{{--                if (!isNaN(tax)) {--}}
{{--                    totalTax += tax;--}}
{{--                }--}}
{{--                $('th#total-tax').text(totalTax).html();--}}
{{--            });--}}
{{--        }--}}

    </script>
@endsection
