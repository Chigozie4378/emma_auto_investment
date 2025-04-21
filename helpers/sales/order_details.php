<?php
include __DIR__ . '/../_partial.php';
$sales_ctr = new SalesController();
$sales_ctr->onlineSales();
$ctr = new OrdersController();
$orders = $ctr->order();
$order = $orders->fetch_assoc();
$order_details = $ctr->orderDetails();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
    <link rel="icon" href="../assets/images/logo.jpg" type="image/gif" sizes="20x20">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .delete-btn {
            color: #dc3545;
            cursor: pointer;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

        select.price-select {
            width: 100px;
        }

        .total-row {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .order-summary-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .order-summary {
            min-width: 350px;
        }

        .qty-input {
            width: 80px;
            text-align: end;
        }

        .low-stock-text {
            color: red;
            font-weight: bold;
        }

        .not-available {
            color: red;
            font-weight: bold;
        }

        /* Keep a nice blue border and glow when the switch is OFF */
        .form-check-input:not(:checked) {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* When checked (ON), let Bootstrap handle it — blue fill */
        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            box-shadow: none !important;
        }
    </style>
</head>

<body class="p-4">
    <div class="container-fluid">
        <h4 class="text-center mb-4">Order Placed</h4>
        <div class="card">
            <div class="card-body">

                <div class="mb-4">
                    <div>
                        <p><strong>Customer Name:</strong> <?= $order['name']; ?></p>
                        <p><strong>Address:</strong> <?= $order['address']; ?></p>
                        <p><strong>Invoice No:</strong> <?= $sales_ctr->generateInvoice() ?></p>
                        <p><strong>Date:</strong> <?= date('d-m-Y') ?></p>
                    </div>
                </div>


                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <a style="font-size:26px;" href="orders.php"><i class="fa-solid fa-circle-arrow-left"></i> Go Back</a>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="priceToggler">
                        <label class="form-check-label" for="priceToggler"><strong>Switch all to Carton
                                Prices</strong></label>
                    </div>

                </div>
                <form method="post">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Model</th>
                                    <th>Manufacturer</th>
                                    <th>Qty</th>
                                    <th>Qty Rem</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                <?php
                                $sn = 1;
                                foreach ($order_details as $detail) {
                                    $productDetails = $ctr->fetchProductDetails($detail['product_name'], $detail['model'], $detail['manufacturer']);
                                ?>


                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= $detail['product_name'] ?></td>
                                        <input type="hidden" name="product_name[]" value="<?= $detail['product_name'] ?>">

                                        <td><?= $detail['model'] ?></td>
                                        <input type="hidden" name="model[]" value="<?= $detail['model'] ?>">

                                        <td><?= $detail['manufacturer'] ?></td>
                                        <input type="hidden" name="manufacturer[]" value="<?= $detail['manufacturer'] ?>">

                                        <td><input type="number" name="quantity[]" onFocus="this.select()"
                                                class="form-control form-control-sm qty-input" min="0"
                                                value="<?= $detail['quantity'] ?>"></td>

                                        <td class="qty-rem" data-qtyrem="<?= $productDetails['quantity'] ?>"
                                            data-qtyrem-original="<?= $productDetails['quantity'] ?>">
                                            <?= $productDetails['quantity_in_stock'] ?>
                                        </td>
                                        <input type="hidden" name="qty_rem[]" value="<?= $productDetails['quantity'] ?>">
                                        <td>
                                            <select name="price[]" class="form-select form-select-sm price-select"
                                                data-wholesale="<?= $productDetails['wprice'] ?>"
                                                data-carton="<?= $productDetails['cprice'] ?>">
                                                <option value="<?= $productDetails['wprice'] ?>">
                                                    <?= $productDetails['wprice'] ?>
                                                </option>
                                                <option value="<?= $productDetails['cprice'] ?>">
                                                    <?= $productDetails['cprice'] ?>
                                                </option>
                                            </select>
                                        </td>
                                        <input type="hidden" name="availability_status[]" value="<?= $productDetails['quantity'] < $detail['quantity'] ? 'not available' : 'available' ?>">

                                        <td class="amount">0</td>
                                        <td><span class="delete-btn"><i class="fa-solid fa-circle-minus"></i> Delete</span></td>
                                    </tr>
                                <?php } ?>
                                <tr class="total-row">
                                    <td colspan="7" class="text-end">Total Amount: #</td>
                                    <td id="totalAmount">0.00</td>
                                    <input type="hidden" id="totalAmountInput" name="totalAmount" value="0.00">
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="order-summary-container">
                        <div class="order-summary">
                            <div class="d-flex mb-3">
                                <div>
                                    <label class="form-check-label me-3">
                                        <input type="checkbox" class="form-check-input" id="checkDeposit"> Check Deposit
                                    </label>

                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="addTransport"> Add Transport
                                    </label>
                                </div>
                            </div>
                            <div id="depositContainer"></div>

                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3" style="width:100px;">Cash</div>
                                <input type="number" name="cash" id="cash" class="form-control" style="width:200px;"
                                    onFocus="this.select()" value="0">
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3" style="width:100px;">Transfer</div>
                                <input type="number" name="transfer" id="transfer" class="form-control transfer-input" style="width:200px;"
                                    onFocus="this.select()" value="0">
                                <span class="ms-2 transfer-select-placeholder"></span>
                            </div>
                            <div class="mb-3 d-flex align-items-center" id="pos-field">
                                <div class="me-3" style="width:100px;">POS</div>
                                <input type="number" name="pos" id="pos" class="form-control pos-input" style="width:200px;"
                                    onFocus="this.select()" value="0">
                                <span class="ms-2 pos-select-placeholder"></span>
                            </div>
                            <div class="mb-3 d-flex align-items-center transport-field d-none">
                                <div class="me-3" style="width:100px;">Transport</div>
                                <input type="number" name="transport" id="transport" class="form-control" onFocus="this.select()"
                                    style="width:200px;" value="0">
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3" style="width:100px;">Paid</div>
                                <input type="number" name="paid" id="paid" class="form-control" style="width:200px;" value="0" readonly>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3" style="width:100px;">Balance</div>
                                <input type="number" name="balance" id="balance" class="form-control" style="width:200px;" value="0"
                                    readonly>
                            </div>


                            <div class="d-grid">
                                <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function recalculateAmounts() {
            let total = 0;
            $('#productTableBody tr').each(function() {
                if ($(this).hasClass('total-row')) return;

                const qty = parseFloat($(this).find('.qty-input').val()) || 0;
                const qtyRemElement = $(this).find('.qty-rem');
                const originalQtyRem = parseFloat(qtyRemElement.data('qtyrem-original')) || 0;
                const adjustedQtyRem = originalQtyRem - qty;
                const price = parseFloat($(this).find('.price-select').val()) || 0;
                const amount = qty * price;

                if (adjustedQtyRem < 0 || qty > originalQtyRem) {
                    qtyRemElement.html('<span class="not-available">Not Available</span>');
                } else if (qty > 0 && adjustedQtyRem / qty <= 2) {
                    qtyRemElement.html(`<span class="low-stock-text">${adjustedQtyRem}</span>`);
                } else {
                    qtyRemElement.text(adjustedQtyRem);
                }

                $(this).find('.amount').text(amount.toLocaleString());
                total += amount;
            });
            $('#totalAmount').text(total.toLocaleString());
            $('#totalAmountInput').val(total);
            calculatePaidAndBalance(); // Immediately recalculate paid & balance
        }




        // Add dynamic transport field toggle logic



        // Recalculate amounts on qty or price change
        $(document).on('input change', '.qty-input, .price-select', recalculateAmounts);

        // Toggler logic to change all price fields to wholesale or carton
        $('#priceToggler').on('change', function() {
            const useCarton = $(this).is(':checked');
            $('.price-select').each(function() {
                const priceValue = useCarton ? $(this).data('carton') : $(this).data('wholesale');
                $(this).val(priceValue);
            });
            recalculateAmounts();
        });


        // Delete row
        $(document).on('click', '.delete-btn', function() {
            $(this).closest('tr').remove();
            recalculateAmounts();
        });

        $('#addTransport').on('change', function() {
            if ($(this).is(':checked')) {
                $('.transport-field').removeClass('d-none');
            } else {
                $('.transport-field').addClass('d-none');
            }
        });

        $(document).on('keydown', '.transfer-input', function() {
            if ($('.transfer-select-placeholder').is(':empty')) {
                $('.transfer-select-placeholder').html(`
            <select class="form-select form-select-sm" name="bank" style="width:150px; required">
                <option>Select Bank</option>
                <option>First Bank</option>
                 <option>UBA</option>
                <option>Polaris Bank</option>
                <option>Sterling Bank</option>
            </select>
        `);
            }
        });

        $(document).on('keydown', '.pos-input', function() {
            if ($('.pos-select-placeholder').is(':empty')) {
                $('.pos-select-placeholder').html(`
            <div>
                <select class="form-select form-select-sm mb-1" name="pos_type" style="width:150px; required">
                    <option>Select POS</option>
                    <option>Opay</option>
                    <option>Moniepoint</option
                </select>
                <div><strong>Charges</strong> 
                    <input type="radio" name="pos_charges" value="50" checked> 50 
                    <input type="radio" name="pos_charges" value="100" class="ms-2"> 100
                </div>
            </div>
        `);
            }
        });

        function calculatePaidAndBalance() {
            const totalAmount = parseFloat($('#totalAmount').text().replace(/,/g, '')) || 0;
            const cash = parseFloat($('#cash').val()) || 0;
            const transfer = parseFloat($('#transfer').val()) || 0;
            const pos = parseFloat($('#pos').val()) || 0;

            let transport = 0;
            if (!$('#transport').closest('.transport-field').hasClass('d-none')) {
                transport = parseFloat($('#transport').val()) || 0;
            }

            const deposit = parseFloat($('#deposit').val()) || 0;
            const paid = cash + transfer + pos + deposit;
            const balance = (totalAmount + transport) - paid;

            // Insert raw numbers into input fields
            $('#paid').val(paid);
            // $('#balance').val(balance > 0 ? balance : 0);
            $('#balance').val(balance);

        }


        // Trigger recalculations on input/change:
        $(document).on('input change', '.qty-input, .price-select, #cash, #transfer, #pos, #transport', function() {
            recalculateAmounts(); // This will also call calculatePaidAndBalance internally
        });

        $('#addTransport').on('change', function() {
            if ($(this).is(':checked')) {
                $('.transport-field').removeClass('d-none');
            } else {
                $('.transport-field').addClass('d-none');
                $('#transport').val(0); // Reset transport if hidden
            }
            recalculateAmounts();
        });

        $(document).ready(function() {
            recalculateAmounts(); // Set totals & balance on load
        });




        // Trigger recalculations on input
        $(document).on('input', '#cash, #transfer, #pos, #transport', function() {
            calculatePaidAndBalance();
        });

        $(document).ready(function() {
            recalculateAmounts();
        });

        $('#checkDeposit').on('change', function() {
            if ($(this).is(':checked')) {
                const customer_name = <?= json_encode($order['name']) ?>;
                const customer_address = <?= json_encode($order['address']) ?>;

                $.ajax({
                    url: '../utils/check_deposit_ajax.php',
                    method: 'GET',
                    data: {
                        customer_name: customer_name,
                        customer_address: customer_address
                    },
                    success: function(response) {
                        let result;
                        try {
                            result = JSON.parse(response);

                            if (result.success) {
                                $('#depositContainer').html(`
                        <div class="mb-3 d-flex align-items-center">
                            <div class="me-3" style="width:100px;">Deposit</div>
                            <input type="number" id="deposit" name="old_deposit" class="form-control" style="width:200px;" 
                                onFocus="this.select()" value="${result.deposit_amount}" readonly>
                        </div>
                    `);
                                calculatePaidAndBalance();
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'EMMA AUTO MULTI-SERVICES',
                                    text: 'No deposit record found for this customer.',
                                    confirmButtonText: 'OK'
                                });
                                $('#checkDeposit').prop('checked', false);
                                $('#depositContainer').empty();
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", response);
                            alert("An error occurred. Check console for details.");
                            return;
                        }

                    }
                });
            } else {
                $('#depositContainer').empty();
            }
        });

        $('form').on('submit', function(e) {
            let hasNotAvailable = false;
            $('.qty-rem').each(function() {
                if ($(this).html().includes('Not Available')) {
                    hasNotAvailable = true;
                }
            });

            if (hasNotAvailable) {
                Swal.fire({
                    icon: 'error',
                    title: 'EMMA AUTO MULTI-SERVICES',
                    text: 'One or more products are not available in sufficient quantity! Please remove them.',
                    confirmButtonText: 'OK'
                });
                e.preventDefault();
                return;
            }

            // Custom validation for bank, pos_type, pos_charges
            const transfer = parseFloat($('#transfer').val()) || 0;
            if (transfer > 0 && $('select[name="bank"]').length && $('select[name="bank"]').val() === 'Select Bank') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a bank for the transfer payment.',
                    confirmButtonText: 'OK'
                });
                e.preventDefault();
                return;
            }

            const pos = parseFloat($('#pos').val()) || 0;
            if (pos > 0) {
                const posType = $('select[name="pos_type"]').val();
                const posCharges = $('input[name="pos_charges"]:checked').val();
                if (!posType || posType === 'Select POS' || !posCharges) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Fields',
                        text: 'Please select POS type and charges.',
                        confirmButtonText: 'OK'
                    });
                    e.preventDefault();
                    return;
                }
            }
        });
    </script>

</body>

</html>