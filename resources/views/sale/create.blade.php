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
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
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

                    <label for="" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Warehouse:
                        <select name="warehouseID" class="form-select">
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
                    <label for="date" class="form-label col-form-label col-sm-12"> Products:
                        <div class="col-sm-12">
                            <select name="productID" id="productID" class="form-select" onchange="getProduct(this.value)">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->productID }}">{{ $product->name }}</option>
                                @endforeach
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
                                        <th class="recieved-product-qty d-none">Received</th>
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
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </label>

                    <label for="taxAmount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4 d-none" id="taxAmountLabel"> Tax Amount:
                        <input type="number" name="taxAmount" id="taxAmount" class="form-control" placeholder="Tax Amount" required>
                    </label>

                    <label for="discount" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Discount:
                        <input type="number" name="discount" class="form-control" placeholder="Discount" required>
                    </label>

                    <label for="shippingCost" class="form-label col-form-label col-sm-12 col-md-6 col-lg-4"> Shipping Cost:
                        <input type="number" name="shippingCost" class="form-control" placeholder="Shipping Cost" required>
                    </label>
                </div>

                <div class="form-group row">
                    <label for="description" class="form-label col-form-label "> Note:
                        <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                    </label>
                </div>

                <div class="form-group row mt-2">
                    <div class="offset-2">
                        <input class="btn btn-primary" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('more-script')
    <script>
        var units = @json($units);
        var existingProducts = [];

        $('#orderTax').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Yes') {
                $('#taxAmountLabel').removeClass('d-none');
            } else {
                $('#taxAmountLabel').addClass('d-none');
            }
        });

        function getProduct(productID) {

            var strHTML = "";
            $.ajax({
                url: "{{ route('ajax.handle',"getProduct") }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    productID: productID,
                },
                success: function (result) {
                    let found = $.grep(existingProducts, function(element) {
                        return element === result[0].productID;
                    });
                    if (found.length > 0) {
                        var rowId = result[0].productID; // Example row id
                        var row = $("#tbody #" +'rowID_'+ rowId); // Select the row based on the id
                        var quantityInput = row.find('[name="quantity_' + rowId + '"]');
                        var netUnitCostElement = row.find('[id="netUnitCost_' + rowId + '"]');
                        var discountInput = row.find('[name="discount_' + rowId + '"]');
                        var taxInput = row.find('[name="tax_' + rowId + '"]');

                        var discount = parseInt(discountInput.val());
                        var tax = parseInt(taxInput.val());

                        var quantity = parseInt(quantityInput.val());
                        var netUnitCost = parseInt(netUnitCostElement.text());
                        quantity++;
                        quantityInput.val(quantity);
                        var subtotal = (quantity * netUnitCost) - discount + tax;
                        $('td:has(span#subTotal_' + rowId + ')').find('span#subTotal_' + rowId).text(subtotal);
                    } else {
                        result.forEach(function (v) {
                            let id = v.productID;
                            strHTML += '<tr id="rowID_'+ v.productID +'">';
                            strHTML += '<td>' + v.name + '</td>';
                            strHTML += '<td>' + v.code + '</td>';
                            strHTML += '<td><input type="number" class="form-control" name="quantity_'+v.productID+'" value="1" onchange="changeQuantity(this, '+id+')" style="border: none"></td>';
                            strHTML += '<td><input type="number" class="form-control" name="batchNumber_'+v.productID+'" value=""></td>';
                            if (v.isExpire === 1) {
                                strHTML += '<td>' +
                                    '<input type="date" class="form-control" name="expiryDate_' + v.productID + '" value="">' +
                                    '</td>';
                            } else {
                                // If v.expire is anything other than 1, show "N/A"
                                strHTML += '<td>N/A</td>';
                            }
                            strHTML += '<td><span id="netUnitCost_'+v.productID+'"> ' + v.productUnit + '</span></td>';

                            strHTML += '<td width="10%"><select class="form-control" name="purchaseUnit_'+v.productID+'">';

                            // Loop through the Units from the Laravel variable
                            units.forEach(function(unit) {
                                strHTML += '<option value="' + unit.unitID + '">' + unit.name + '</option>';
                            });
                            strHTML += '</select></td>';

                            strHTML += '<td><input type="number" class="form-control" name="discount_'+v.productID+'" value="0" onchange="changeDiscount(this, '+id+')"></td>';
                            strHTML += '<td><input type="number" class="form-control" name="tax_'+v.productID+'" value="0" onchange="changeTax(this, '+id+')"></td>';

                            strHTML += '<td> <span id="subTotal_'+v.productID+'">' + v.productUnit + '</span></td>';
                            strHTML += '<input type="hidden" name="netUnitCost_'+ v.productID +'" value="' + v.productUnit + '">';
                            strHTML += '<input type="hidden" name="code_'+ v.productID +'" value="' + v.code + '">';
                            strHTML += '<td><input type="hidden" name="productID_'+v.productID+'" value="'+v.productID+'"><button type="button" class="btn btn-sm" onclick="deleteRow(this, '+v.productID+')" id="'+v.productID+'"><i class="fa fa-trash"></i></button></td>';
                            strHTML += '</tr>';
                        });
                        $('#tbody').append(strHTML);
                    }
                    if (!existingProducts.includes(result[0].productID))
                    {
                        existingProducts.push(result[0].productID);
                    }
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

                        var subtotalSpan = $(this).find('span[id^="subTotal_"]');
                        var subtotalValue = parseFloat(subtotalSpan.text().trim());
                        if (!isNaN(subtotalValue)) {
                            subTotalAmount += subtotalValue;
                        }
                        $('th#total').text(subTotalAmount).html();
                    });
                }
            });
            document.getElementById("productID").value = "";

        }

        function changeQuantity(input, id) {
            let row = $(input).closest('tr');
            let latestQuantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row[0].childNodes[5].innerText;
            let quantityIntoUnitCost = latestQuantity * netUnitCost;

            var discountInput = row.find('input[name="discount_' + id + '"]');
            var taxInput = row.find('input[name="tax_' + id + '"]');

            var discount = parseInt(discountInput.val());
            var tax = parseInt(taxInput.val());

            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
            var subTotalAmount = 0;
            var totalQuantity = 0;
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
            });
        }

        function changeDiscount(input, id) {
            let row = $(input).closest('tr');
            let latestQuantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row[0].childNodes[5].innerText;
            let quantityIntoUnitCost = latestQuantity * netUnitCost;

            var discountInput = row.find('input[name="discount_' + id + '"]');
            var taxInput = row.find('input[name="tax_' + id + '"]');

            var discount = parseInt(discountInput.val());
            var tax = parseInt(taxInput.val());

            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
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

        function changeTax(input, id) {
            let row = $(input).closest('tr');
            let latestQuantity = row.find('input[name="quantity_' + id + '"]').val();
            let netUnitCost = row[0].childNodes[5].innerText;
            let quantityIntoUnitCost = latestQuantity * netUnitCost;

            var discountInput = row.find('input[name="discount_' + id + '"]');
            var taxInput = row.find('input[name="tax_' + id + '"]');

            var discount = parseInt(discountInput.val());
            var tax = parseInt(taxInput.val());

            var subtotal = quantityIntoUnitCost - discount + tax;
            $('td:has(span#subTotal_' + id + ')').find('span#subTotal_' + id).text(subtotal);
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
                return value !== id;
            });
            $(button).closest('tr').remove();
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



    </script>
@endsection

