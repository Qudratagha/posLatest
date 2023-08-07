@extends('layouts.admin')
@section('title', 'Sale Edit')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i>Edit Sale {{ $sale->saleID }}
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
                        <select name="warehouseID" class="form-select" onchange="getProduct(this.value)">
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
{{--                                        @dd($order->productID)--}}
                                        <tr id="rowID_{{ $order->batchNumber }}">
                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->code }}</td>
                                            <td><input type="number" class="form-control" name="quantity_{{$order->batchNumber}}" value="{{ $order->quantity }}" oninput="changeQuantity(this,{{$order->batchNumber}})" style="border: none"></td>
                                            <td><input type="number" class="form-control" name="batchNumber_{{$order->batchNumber}}" value="{{ $order->batchNumber }}"></td>
                                            <td style="text-align: center;">
                                                @if($order->expiryDate == '')
                                                    <div style="display: inline-block; text-align: center;">N/A</div>
                                                @else
                                                    <input type="date" class="form-control" id="date" name="expiryDate_{{$order->batchNumber}}" value="{{ $order->expiryDate }}">
                                                @endif
                                            </td>
                                            <td><input type="number" class="form-control" name="netUnitCost_{{$order->batchNumber}}" min="1" value="{{ $order->netUnitCost }}" oninput="changeNetUnitCost(this, {{$order->batchNumber}})" > </td>
                                            <td>
                                                <select name="purchaseUnit_{{$order->batchNumber}}" id="" class="form-select">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->unitID }}" @if ($unit->unitID == $order->purchaseUnitID) selected @endif > {{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" name="discount_{{$order->batchNumber}}" min="0" value="{{ $order->discountValue }}" oninput="changeDiscount(this, {{$order->batchNumber}} )"></td>
                                            <td><input type="number" class="form-control" name="tax_{{$order->batchNumber}}" min="0" value="{{ $order->tax }}" oninput="changeTax(this, {{$order->batchNumber}})"></td>
                                            <td> <span id="subTotal_{{$order->batchNumber}}"> {{ $order->subTotal }} </span></td>
                                            <input type="hidden" name="code_{{ $order->batchNumber }}" value="{{ $order->code }}">
                                            <input type="hidden" name="netUnitCost_{{ $order->batchNumber }}" value="{{ $order->netUnitCost }}">
                                            <td><input type="hidden" name="productID_{{ $order->batchNumber }}" value="{{ $order->productID }}"><button type="button" class="btn btn-sm" onclick="deleteRow(this, {{$order->batchNumber}})"><i class="fa fa-trash"></i></button></td>
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
                    <label for="orderTax" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4" > Order Tax:
                        <select name="orderTax" id="orderTax" class="form-select" >
                            <option value="No" >No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </label>

                    <label for="taxAmount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4 d-none" id="taxAmountLabel"> Tax Amount:
                        <input type="number" name="taxAmount" id="taxAmount" class="form-control" placeholder="Tax Amount" min="0" value="{{ $sale->orderTax ?? 0 }}" oninput="overallTaxAmount()">
                    </label>

                    <label for="discount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Discount:
                        <input type="number" name="discount" class="form-control" min="0" value="{{ $sale->discount ?? 0 }}" oninput="overallDiscount()" >
                    </label>

                    <label for="shippingCost" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Shipping Cost:
                        <input type="number" name="shippingCost" class="form-control" min="0" value="{{ $sale->shippingCost ?? 0 }}" oninput="overallShippingCost()">
                    </label>
                </div>

                <div class="form-group row">
                    <label for="saleStatus" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Sale Status:
                        <select name="saleStatus" id="saleStatus" class="form-select">
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                        </select>
                    </label>

                    <label for="paymentStatus" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Payment Status:
                        <select name="paymentStatus" id="paymentStatus" class="form-select" onchange="toggleReceivedFields()">
                            <option value="pending">Pending</option>
                            <option value="received">Received</option>
                        </select>
                    </label>
                </div>

                <div class="received-fields d-none">
                    <div class="form-group row">
                        <label for="paymentStatus" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Paying Amount *:
                            <input type="number" name="paying-amount" class="form-control paying-amount" step="any">
                            <div class="invalid-feedback" style="display: none;"></div>
                        </label>
                        <label for="account" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Account *:
                            <select name="accountID" class="form-select">
                                @foreach ($paymentAccounts as $account)
                                    <option value="{{ $account->accountID }}" {{ old('accountID') == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label for="paymentNote" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Payment Note *:
                            <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="form-label col-form-label "> Sale Note:
                        <textarea type="text" name="description" rows="5" class="form-control">{{ $sale->description }}</textarea>
                    </label>
                </div>
                <div class="form-group row mt-2">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>
        </div>
        <div class="container-fluid">
            <table class="table table-bordered table-condensed totals">
                <tbody>
                <tr>
                    <td>
                        <strong>Items</strong>
                        <span class="float-end" id="fItems">0.00</span>
                    </td>
                    <td>
                        <strong>Total</strong>
                        <span class="float-end" id="fSubtotal">0.00</span>
                    </td>
                    <td>
                        <strong>Order Tax</strong>
                        <span class="float-end" id="fOrderTax">0.00</span>
                    </td>
                    <td>
                        <strong>Order Discount</strong>
                        <span class="float-end" id="fOrderDiscount">0.00</span>
                    </td>
                    <td>
                        <strong>Shipping Cost</strong>
                        <span class="float-end" id="fShippingCost">0.00</span>
                    </td>
                    <td>
                        <strong>Grand Total</strong>
                        <span class="float-end" id="fGrandTotal">0.00</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        var pAmount =  $('input[name="paying-amount"]');
        $(document).ready(function() {
            var selectedWarehouseID = $('select[name="warehouseID"]').val();
            getProduct(selectedWarehouseID);
            footerData();

        });
        $(document).ready(function() {
            $('.productField').select2();
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
                        $.each(response.productsWithCreditDebtSum, function(index, product) {
                            $('#productID').append('<option value="' + product.productID+ '_'+ product.batchNumber + '">' + product.product.name +' | ' + product.batchNumber +' | '+ product.difference + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch products.');
                    }
                });
            }
            else {
                $('#productID').empty().append('<option value="">Select Product</option>');
            }
        }

        var units = @json($units);
        var existingProducts = [];

        var saleOrders  = @json( $saleOrders);
        saleOrders.forEach(function(order) {
            existingProducts.push(order.batchNumber);
        });

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
                success: function (result)
                    {
                        if(result[0].difference === 0){
                            alert('Out Of Stock');
                            document.getElementById("productID").value = "";
                            return;
                        }
                        let found = $.grep(existingProducts, function(element) {
                            return element === result[0].batchNumber;
                        });

                        if (found.length > 0)
                        {
                            var rowId = result[0].batchNumber;
                            var row = $("#tbody #" +'rowID_'+ rowId);
                            var quantityInput = row.find('[name="quantity_' + rowId + '"]');
                            var netUnitCostInput = row.find('input[name="netUnitCost_' + rowId + '"]');
                            var discountInput = row.find('[name="discount_' + rowId + '"]');
                            var taxInput = row.find('[name="tax_' + rowId + '"]');
                            var quantity = parseInt(quantityInput.val());
                            var netUnitCost = parseInt(netUnitCostInput.val());
                            var discount = parseInt(discountInput.val());
                            var tax = parseInt(taxInput.val());
                            quantity++;
                            quantityInput.val(quantity);
                            var subtotal = (quantity * netUnitCost) - discount + tax;
                            $('td:has(span#subTotal_' + rowId + ')').find('span#subTotal_' + rowId).text(subtotal);
                            footerData();

                        }else {
                            result.forEach(function (v) {
                                let id = v.batchNumber;
                                strHTML += '<tr id="rowID_' + v.batchNumber + '">';
                                strHTML += '<td>' + v.product.name + '</td>';
                                strHTML += '<td>' + v.product.code + '</td>';
                                strHTML += '<td class="row align-items-center"><div class="col-8"><input type="number" class="form-control" name="quantity_' + v.batchNumber + '" min="1" max="' + v.credit_sum + '" value="1" onchange="changeQuantity(this, ' + id + ')" style="border: none"> </div> <div class="col-4"><span>' + v.credit_sum + '</span> </div></td>';
                                strHTML += '<td><input type="number" class="form-control" name="batchNumber_' + v.batchNumber + '" value="' + v.batchNumber + '"></td>';
                                strHTML += `<td style="text-align: center;">${
                                    v.product.isExpire === 0 ?
                                        `<input type="date" id="date" class="form-control" name="expiryDate_${v.batchNumber}" value="${getCurrentDate()}">`
                                        : '<div style="display: inline-block; text-align: center;">N/A</div>'
                                }</td>`;
                                strHTML += '<td><input type="number" class="form-control" name="netUnitCost_' + v.batchNumber + '" min="1" value="' + v.product.purchasePrice + '" oninput="changeNetUnitCost(this, ' + id + ')" > </td>';
                                strHTML += '<td width="10%"><select class="form-control" name="saleUnit_' + v.batchNumber + '">';
                                units.forEach(function (unit) {
                                    strHTML += '<option value="' + unit.unitID + '">' + unit.name + '</option>';
                                });
                                strHTML += '</select></td>';
                                strHTML += '<td><input type="number" class="form-control" name="discount_' + v.batchNumber + '" min="0" value="0" oninput="changeDiscount(this, ' + id + ')"></td>';
                                strHTML += '<td><input type="number" class="form-control" name="tax_' + v.batchNumber + '" min="0" value="0" oninput="changeTax(this, ' + id + ')"></td>';
                                strHTML += '<td> <span id="subTotal_' + v.batchNumber + '">' + v.product.purchasePrice + '</span></td>';
                                strHTML += '<td><input type="hidden" name="productID_' + v.batchNumber + '" value="' + v.productID + '"><button type="button" class="btn btn-sm" onclick="deleteRow(this, ' + v.productID + ')" id="' + v.productID + '"><i class="fa fa-trash"></i></button></td>';
                                strHTML += '<input type="hidden" name="code_'+ v.productID +'" value="' + v.product.code + '">';
                                strHTML += '</tr>';
                            });
                            if (!existingProducts.includes(result[0].batchNumber)) {
                                existingProducts.push(result[0].batchNumber);
                            }
                        }
                        $('#tbody').append(strHTML);
                        footerData();
                    }
            });
            document.getElementById("productID").value = "";
        }
        function changeQuantity(input, id) {
            let row = $(input).closest('tr');
            let quantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();
            let quantityIntoUnitCost = quantity * netUnitCost;
            var discountInput = row.find('input[name="discount_' + id + '"]').val();
            var taxInput = row.find('input[name="tax_' + id + '"]').val();
            var discount = parseInt(discountInput);
            if (isNaN(discount)){discount = 0;}
            var tax = parseInt(taxInput);
            if (isNaN(tax)){tax = 0;}
            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
            footerData();
        }
        function changeNetUnitCost(input, id) {
            let row = $(input).closest('tr');
            let quantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();
            let quantityIntoUnitCost = quantity * netUnitCost;
            var discountInput = row.find('input[name="discount_' + id + '"]').val();
            var taxInput = row.find('input[name="tax_' + id + '"]').val();
            var discount = parseInt(discountInput);
            if (isNaN(discount)){
                discount = 0;
            }
            var tax = parseInt(taxInput);
            if (isNaN(tax)){
                tax = 0;
            }
            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
            footerData();
        }
        function changeDiscount(input, id) {
            let row = $(input).closest('tr');
            let quantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();
            let quantityIntoUnitCost = quantity * netUnitCost;
            var discountInput = row.find('input[name="discount_' + id + '"]').val();
            var discount = parseInt(discountInput);
            if(isNaN(discount)){
                discount = 0;
            }
            var taxInput = row.find('input[name="tax_' + id + '"]').val();
            var tax = parseInt(taxInput);
            if(isNaN(tax)){
                tax = 0;
            }
            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
            footerData();
        }
        function changeTax(input, id) {
            let row = $(input).closest('tr');
            let quantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row.find('input[name="' + 'netUnitCost_' + id + '"]').val();
            let quantityIntoUnitCost = quantity * netUnitCost;
            var discountInput = row.find('input[name="discount_' + id + '"]').val();
            var taxInput = row.find('input[name="tax_' + id + '"]').val();
            var discount = parseInt(discountInput);
            if(isNaN(discount)){
                discount = 0;
            }
            var tax = parseInt(taxInput);
            if(isNaN(tax)){
                tax = 0;
            }
            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
            footerData();
        }

        function footerData(){
            var subTotalAmount = 0;
            var totalQuantity = 0;
            var totalDiscount = 0;
            var totalTax = 0;

            var overallDiscount = 0;
            var overallShippingCost = 0;
            var overAllTaxAmount = 0;

            var inputOverallDiscount = $('input[name="discount"]');
            var inputAllDiscount  = parseInt(inputOverallDiscount.val());
            if (!isNaN(inputAllDiscount)) {
                overallDiscount = inputAllDiscount ;
            }
            var inputOverallShippingCost = $('input[name="shippingCost"]');
            var inputAllShippingCost  = parseInt(inputOverallShippingCost.val());
            if (!isNaN(inputAllShippingCost)) {
                overallShippingCost = inputAllShippingCost ;
            }
            var inputOverallTaxAmount = $('input[name="taxAmount"]');
            var inputAllTaxAmount  = parseInt(inputOverallTaxAmount.val());
            if (!isNaN(inputAllTaxAmount)) {
                overAllTaxAmount = inputAllTaxAmount ;
            }

            $('tr').each(function() {
                var quantityInput = $(this).find('input[name^="quantity_"]');
                var quantity = parseInt(quantityInput.val());
                if (!isNaN(quantity)) {
                    totalQuantity += quantity;
                }
                $('th#total-qty').text(totalQuantity).html();
                var subtotalSpan = $(this).find('span[id^="subTotal_"]');
                var subtotalValue = parseFloat(subtotalSpan.text().trim());
                if (!isNaN(subtotalValue)) {
                    subTotalAmount += subtotalValue;
                }
                $('th#total').text(subTotalAmount).html();
                var discountInput = $(this).find('input[name^="discount_"]');
                var discount = parseInt(discountInput.val());
                if (!isNaN(discount)) {
                    totalDiscount += discount;
                }
                $('th#total-discount').text(totalDiscount).html();
                var taxInput = $(this).find('input[name^="tax_"]');
                var tax = parseInt(taxInput.val());
                if (!isNaN(tax)) {
                    totalTax += tax;
                }
                $('th#total-tax').text(totalTax).html();
            });
            var payingAmount = subTotalAmount + overAllTaxAmount - totalDiscount + totalTax + overallShippingCost - overallDiscount;
            pAmount.val(payingAmount);
            pAmount.attr('max', payingAmount);

            $('#fItems').text( existingProducts.length + '( ' + totalQuantity + ' )');
            $('#fSubtotal').text(subTotalAmount);
            $('#fOrderDiscount').text(overallDiscount.toFixed(2));
            $('#fShippingCost').text(overallShippingCost.toFixed(2));
            $('#fOrderTax').text(overAllTaxAmount.toFixed(2));
            $('#fGrandTotal').text(payingAmount.toFixed(2));
        }

        function deleteRow(button, id) {
            existingProducts = $.grep(existingProducts, function(value) {
                return value !== id;
            });
            $(button).closest('tr').remove();
            footerData();
        }

        function overallDiscount(){
            footerData();
        }
        function overallShippingCost() {
            footerData();
        }
        function overallTaxAmount() {
            footerData();
        }

        $('#orderTax').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Yes') {
                $('#taxAmountLabel').removeClass('d-none');
            } else {
                $('#taxAmountLabel').addClass('d-none');
            }
        });

        function toggleReceivedFields() {
            const paymentStatus = document.getElementById('paymentStatus').value;
            const receivedFields = document.querySelector('.received-fields');
            if (paymentStatus === 'received') {
                receivedFields.classList.remove('d-none');
            } else {
                receivedFields.classList.add('d-none');
            }
        }

        function handlePayingAmountChange() {
            var inputPayingAmount = $('input[name="paying-amount"]');
            var maxPayingAmount = parseFloat(inputPayingAmount.attr('max'));
            var enteredPayingAmount = parseFloat(inputPayingAmount.val());

            var errorMessage = $('.invalid-feedback');
            if (!isNaN(maxPayingAmount) && !isNaN(enteredPayingAmount) && enteredPayingAmount > maxPayingAmount) {
                errorMessage.text("The amount cannot exceed " + maxPayingAmount.toFixed(2));
                errorMessage.css({
                    'color': '#dc3545',
                    'font-size': '20px',
                    'margin-top': '10px'
                });
                errorMessage.show();
                setTimeout(function() {
                    errorMessage.hide();
                }, 5000);
                inputPayingAmount.val(maxPayingAmount);
            } else {
                errorMessage.hide();
            }
        }
        pAmount.on('input', handlePayingAmountChange);
        handlePayingAmountChange();
    </script>
@endsection
