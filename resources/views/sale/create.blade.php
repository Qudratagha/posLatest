@extends('layouts.admin')
@section('title', 'Sale Create')
@section('content')
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h4 class="card-title fw-semibold">
                <i class="fas fa-users-cog"></i> Add New Sale
            </h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="date" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Date:
                        <input type="date" name="date" class="form-control" id="date" value="{{ old('date') }}" required>
                    </label>

                    <label for="referenceNo" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Reference No:
                        <input type="number" name="referenceNo" class="form-control" value="{{ old('referenceNo') }}" required>
                    </label>

                    <label for="customerID" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Customer:
                        <select name="customerID" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->accountID }}" {{ old('accountID') == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group row">
                    <label for="warehouseID" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Warehouse:
                        <select name="warehouseID" id="warehouseID" class="form-select">
                            <option value="">Select Warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->warehouseID }}" {{ old('warehouseID') == $warehouse->warehouseID ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label for="customerID" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Biller:
                        <select name="customerID" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->accountID }}" {{ old('accountID') == $account->accountID ? 'selected' : '' }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group row">
                    <label for="product" class="form-label col-form-label col-sm-12"> Products:
                        <select name="productID" id="productID" class="form-select form-control productField" onchange="productDetails(this.value)">
                            <option value="">Select Product</option>
                        </select>
                    </label>
                </div>

                <div class="form-group">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Sale Table *</h5>
                            <div class="table-responsive table-responsive-sm mt-3">
                                <table id="myTable" class="table table-hover order-list">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th width="12%">Quantity</th>
                                        <th>Batch No</th>
                                        <th width="8%">Expired Date</th>
                                        <th>Net Unit Cost</th>
                                        <th>Purchase Unit</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>SubTotal</th>
                                        <th><i class="fa fa-trash"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                    <thead class="active" style="font-weight: bolder; font-size: large; color: red">
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th id="total-qty">0</th>
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
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </label>

                    <label for="taxAmount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4 d-none" id="taxAmountLabel"> Tax Amount:
                        <input type="number" name="taxAmount" id="taxAmount" class="form-control" min="0" placeholder="Tax Amount">
                    </label>

                    <label for="discount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Discount:
                        <input type="number" name="discount" class="form-control" value="0" min="0" placeholder="Discount">
                    </label>

                    <label for="shippingCost" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Shipping Cost:
                        <input type="number" name="shippingCost" class="form-control" value="0" min="0" placeholder="Shipping Cost" >
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
                        <select name="paymentStatus" id="paymentStatus" class="form-select">
                            <option value="received">Received</option>
                            <option value="pending">Pending</option>
                        </select>
                    </label>

                </div>

                <div class="form-group row">
                    <label for="description" class="form-label col-form-label "> Note:
                        <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                    </label>
                </div>

                <div class="form-group row mt-2">
{{--                    <div class="offset-2">--}}
                        <input class="btn btn-primary" type="submit" value="Save">
{{--                    </div>--}}
                </div>
            </form>
        </div>
    </div>
@endsection
@section('more-script')
    <script>

        $(document).ready(function() {
            $('.productField').select2();
        })
        $('#orderTax').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Yes') {
                $('#taxAmountLabel').removeClass('d-none');
            } else {
                $('#taxAmountLabel').addClass('d-none');
            }
        });
        $('#warehouseID').on('change', function() {
            var selectedWarehouseID = $(this).val();
            getProduct(selectedWarehouseID);
        });
        $('#productID').on('click', function() {
            if ($('#productID').children('option').length === 1) {
                alert("Please select a warehouse first");
                $('#productID').val(''); // Reset the product dropdown to the default "Select Product" option
            }
        });
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
            return $('#warehouseID').val();
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

                        }else {
                            result.forEach(function (v) {
                                let id = v.batchNumber;
                                strHTML += '<tr id="rowID_' + v.batchNumber + '">';
                                strHTML += '<td>' + v.product.name + '</td>';
                                strHTML += '<td>' + v.product.code + '</td>';
                                strHTML += '<td><input type="number" class="form-control" name="quantity_' + v.batchNumber + '" min="1" max="' + v.credit_sum + '" value="1" onkeyup="changeQuantity(this, ' + id + ')" style="border: none"></td>';
                                strHTML += '<td><input type="number" class="form-control" name="batchNumber_' + v.batchNumber + '" value="' + v.batchNumber + '"></td>';
                                strHTML += `<td style="text-align: center;">${
                                    v.product.isExpire === 0 ?
                                        `<input type="date" id="date" class="form-control" name="expiryDate_${v.batchNumber}" value="">`
                                        : '<div style="display: inline-block; text-align: center;">N/A</div>'
                                }</td>`;
                                strHTML += '<td><input type="number" class="form-control" name="netUnitCost_' + v.batchNumber + '" min="1" value="' + v.product.purchasePrice + '" onkeyup="changeNetUnitCost(this, ' + id + ')" > </td>';
                                strHTML += '<td width="10%"><select class="form-control" name="saleUnit_' + v.batchNumber + '">';
                                units.forEach(function (unit) {
                                    strHTML += '<option value="' + unit.unitID + '">' + unit.name + '</option>';
                                });
                                strHTML += '</select></td>';
                                strHTML += '<td><input type="number" class="form-control" name="discount_' + v.batchNumber + '" min="0" value="0" onkeyup="changeDiscount(this, ' + id + ')"></td>';
                                strHTML += '<td><input type="number" class="form-control" name="tax_' + v.batchNumber + '" min="0" value="0" onkeyup="changeTax(this, ' + id + ')"></td>';
                                strHTML += '<td> <span id="subTotal_' + v.batchNumber + '">' + v.product.purchasePrice + '</span></td>';
                                strHTML += '<td><input type="hidden" name="productID_' + v.batchNumber + '" value="' + v.productID + '"><button type="button" class="btn btn-sm" onclick="deleteRow(this, ' + v.productID + ')" id="' + v.productID + '"><i class="fa fa-trash"></i></button></td>';
                                strHTML += '<input type="hidden" name="netUnitCost_'+ v.productID +'" value="' + v.product.purchasePrice + '">';
                                strHTML += '<input type="hidden" name="code_'+ v.productID +'" value="' + v.product.code + '">';
                                strHTML += '</tr>';
                            });
                            if (!existingProducts.includes(result[0].batchNumber)) {
                                existingProducts.push(result[0].batchNumber);
                            }
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
        }
        function deleteRow(button, id) {
            existingProducts = $.grep(existingProducts, function(value) {
                let index = existingProducts.indexOf(value);
                if (index !== -1) {
                    existingProducts.splice(index, 1);
                }
                return value !== id;
            });
            $(button).closest('tr').remove();
            footerData();
        }

    </script>
@endsection

