<?php
include __DIR__ . '/../_partial.php';

$sales_ctr = new SalesController();
?>

<?php
include "../includes/shared/sales/header.php";
include "../includes/shared/sales/head.php";
include "../includes/shared/sales/navbar.php";
?>

<section class="content">
    
    <form action="" method="post">
        <?php

        if ($_SERVER['PHP_SELF'] == $path . '/retail.php') {
            echo '<input name="customer_type" type="hidden" value="retail">';
        } elseif ($_SERVER['PHP_SELF'] == $path . '/wholesales.php') {
            echo '<input name="customer_type" type="hidden" value="wholesale">';
        } elseif ($_SERVER['PHP_SELF'] == $path . '/cartoon.php') {
            echo '<input name="customer_type" type="hidden" value="cartoon">';
        }
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <div class="card card-primary">
                        <div class="card-body bg-primary rounded">
                            <div class="row">
                                <div class="col-sm-4"><label for="">Customer_Name: </label></div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php
                                            $title = $_POST['title'] ?? '';
                                            $isRetail = ($_SERVER['PHP_SELF'] == $path . '/retail.php');
                                            ?>

                                            <select name="title" id="title" class="form-control" style="width: 80px;">
                                                <?php Form::oldSelect("title"); ?>
                                                <?php if (!empty($title)) : ?>
                                                    <option value="<?= $title ?>"><?= $title ?></option>
                                                <?php elseif (!$isRetail): ?>
                                                    <option value=""></option>
                                                <?php endif; ?>

                                                <option value="MR">MR</option>
                                                <option value="MRS">MRS</option>
                                                <option value="MISS">MISS</option>
                                                <option value="ALHAJI">ALHAJI</option>
                                                <option value="ALHAJA">ALHAJA</option>
                                            </select>

                                        </div>
                                        <div class="col-md 9">
                                            <!-- <input type="text" name="customer_name" class="form-control" value="<?php Form::oldValue("customer_name") ?>"> -->
                                            <?php if ($_SERVER['PHP_SELF'] == $path . '/retail.php') {
                                                echo ' <input list="list-customers" class="form-control" id="customer_name" name="customer_name" onclick="select()" value="Sir">';
                                            } else {
                                                echo "<input list='list-customers' class='form-control' id='customer_name' name='customer_name' value='" . Form::oldValue("customer_name") . "'>";
                                            }
                                            ?>



                                            <datalist id="list-customers">
                                                <?php
                                                $select1 = $sales_ctr->showSalesCustomerName();
                                                while ($row2 = mysqli_fetch_assoc($select1)) {
                                                    $customer_name = explode(" ", $row2['customer_name']); ?>
                                                    <option value="<?php echo $customer_name[1] ?>">
                                                    <?php
                                                }
                                                    ?>
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"><label for="">Address: </label></div>
                                <div class="col-sm-8">
                                    <?php
                                    if ($_SERVER['PHP_SELF'] == $path . '/retail.php') {
                                        echo '<input list="list-address" class="form-control" id="address" name="address" onclick="select()" value="Address">';
                                    } else {
                                        echo '<input list="list-address" class="form-control" id="address" name="address" value="' . Form::oldValue("address") . '">';
                                    }
                                    ?>
                                    <datalist id="list-address">
                                        <?php
                                        $select2 = $sales_ctr->showSalesCustomerAddress();
                                        while ($row3 = mysqli_fetch_assoc($select2)) { ?>
                                            <option value="<?php echo $row3['address'] ?>">
                                            <?php
                                        }
                                            ?>
                                    </datalist>
                                </div>
                                <div class="col-sm-4"><label for="">Invoice No. : </label></div>
                                <div class="col-sm-8" id="invoice_no"> <input type="text" class="form-control" name="invoice_no" value="<?= $sales_ctr->generateInvoice() ?>" readonly>
                                </div>

                                <div class="col-sm-4"><label for="">Date : </label></div>
                                <div class="col-sm-8">

                                    <input type="text" class="form-control" name="date" value="<?php echo date(" d-m-Y") ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-body bg-info rounded">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6>Product Name</h6>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control chosen" name="productname" onchange="selectProduct(this.value)" id="productname">
                                        <option value="">Please Select Item</option>
                                        <?php
                                        $select = $sales_ctr->filterProductName();
                                        while ($row = mysqli_fetch_assoc($select)) { ?>
                                            <option value="<?php echo $row['name'] ?>">
                                                <?php echo $row['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 pt-1">
                                    <h6>Model</h6>
                                </div>
                                <div class="col-sm-8 pt-1">

                                    <div id="modeldev">
                                        <select class="form-control">
                                            <option value=""></option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-4 pt-1">
                                    <h6>Company</h6>
                                </div>
                                <div class="col-sm-8 pt-1">

                                    <div id="manufacturerdev">
                                        <select class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="PriceQty">
                                <div class="col-sm-4 pt-1">
                                    <h6>Unit Price</h6>

                                </div>
                                <div class="col-sm-8 pt-1">
                                    <div id="priceDiv">
                                        <input type="text" class="form-control" readonly value="0">
                                    </div>
                                </div>
                                <div class="col-sm-4 pt-1">
                                    <h6>Quantity</h6>
                                </div>
                                <div class="col-sm-8 pt-1">

                                    <div id="demo">

                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 pt-1">
                                    <h6>Total</h6>
                                </div>
                                <div class="col-sm-8 pt-1">

                                    <input type="text" class="form-control" id="total" value="0" readonly>
                                </div>
                            </div>
                            <!-- <div class="text-center pt-1"> <input type="button" name="add" class="btn btn-light" value="Add" onclick="addIntoCart()">
                            </div> -->
                            <div class="text-center pt-1">
                                <button id="add-to-cart-btn" class="btn btn-light">Add</button>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div style=" background-color: rgb(255, 255, 255);
              width: autopx;
              height: 75vh;
              overflow: scroll;">
                                <center>
                                    <h4>Taken Products</h4>
                                </center>

                                <div id="load_billing">

                                </div>
                                <center>
                                    <input type="submit" id="generate_bill" name="generate_bill" value="Checkout" class="btn btn-success">
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    function selectManufacturer(value1, value2, value3) {
        $(document).ready(function() {
            var manufacturer = value1;
            var model = value2;
            var productname = value3;

            // Get current price type based on page name
            let path = window.location.pathname;
            let page = path.split("/").pop(); // e.g. cartoon.php
            let price_type = "cprice";

            if (page.includes("wholesales")) price_type = "wprice";
            else if (page.includes("retail")) price_type = "rprice";

            if (manufacturer && model && productname !== "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/sales/load_price.php",
                    method: "POST",
                    data: {
                        manufacturer: manufacturer,
                        model: model,
                        productname: productname,
                        price_type: price_type
                    },
                    success: function(data) {
                        $("#PriceQty").html(data)
                    }
                });
            } else {
                $("#PriceQty").css("display", "none")
            }
        });
    }

    //JQuery Ajax for productname
    function selectProduct(value) {
        $(document).ready(function() {
            var productname = value;
            if (productname != "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/sales/load_model.php",
                    method: "POST",
                    data: {
                        productname: productname
                    },
                    success: function(data) {
                        $("#modeldev").html(data);
                    }
                });
            } else {
                $("#modeldev").css("display", "none");
            }
        });

    }

    //JQuery Ajax for model
    function selectModel(value1, value2) {
        $(document).ready(function() {
            var model = value1;
            var productname = value2;
            if (model && productname != "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/sales/load_manufacturer.php",
                    method: "POST",
                    data: {
                        model: model,
                        productname: productname
                    },
                    success: function(data) {
                        $("#manufacturerdev").html(data);
                    }
                });
            } else {
                $("#manufacturerdev").css("display", "none");
            }
        });
    }



    function quantity(qty) {

        document.getElementById("total").value = eval(document.getElementById("qty").value) * eval(document.getElementById("price").value)
    }

    // modern_add_to_cart.js

    document.addEventListener("DOMContentLoaded", () => {
        const addToCartBtn = document.querySelector("#add-to-cart-btn");

        if (!addToCartBtn) return;

        addToCartBtn.addEventListener("click", (event) => {
            event.preventDefault();

            const productname = document.querySelector("#productname")?.value.trim();
            const model = document.querySelector("#model")?.value.trim();
            const manufacturer = document.querySelector("#manufacturer")?.value.trim();
            const quantity = document.querySelector("#qty")?.value.trim();
            const price = document.querySelector("#price")?.value.trim();
            const total = document.querySelector("#total")?.value.trim();
            const product_id = document.querySelector("#product_id")?.value.trim();
            const qty_db = document.querySelector("#qty_db")?.value.trim();


            const allFieldsFilled =
                productname &&
                model &&
                manufacturer &&
                quantity &&
                price &&
                total &&
                product_id &&
                qty_db;

            if (allFieldsFilled) {
                fetch("/emma_auto_investment/ajax/shared/sales/load_cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: new URLSearchParams({
                            manufacturer,
                            model,
                            productname,
                            quantity,
                            price,
                            total,
                            product_id,
                            qty_db,
                        }),
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        loadBillingProduct();
                        remove();
                    })
                    .catch((error) => console.error("Error:", error));
            } else {
                loadBillingProduct();
            }
        });
    });


    // function loadBillingProduct() {
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             document.getElementById("load_billing").innerHTML = this.responseText;
    //         }
    //     };
    //     xhttp.open("POST", "/emma_auto_investment/ajax/shared/sales/load_bill_product.php", true);
    //     xhttp.send();
    // }
    function loadBillingProduct() {
        const cash = document.getElementById("cash")?.value || 0;
        const transfer = document.getElementById("transfer")?.value || 0;
        const pos = document.getElementById("pos")?.value || 0;
        const transport = document.getElementById("transport")?.value || 0;
        const oldDeposit = document.getElementById("old_deposit")?.value || 0;

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("load_billing").innerHTML = this.responseText;

                // Restore previous values after reload
                document.getElementById("cash").value = cash;
                document.getElementById("transfer").value = transfer;
                document.getElementById("pos").value = pos;
                document.getElementById("transport").value = transport;
                document.getElementById("old_deposit").value = oldDeposit;

                showBankSelect();
                showPosSelect();
                calculateTotals();
            }
        };
        xhttp.open("POST", "/emma_auto_investment/ajax/shared/sales/load_bill_product.php", true);
        xhttp.send();
    }


    //JQuery Ajax for update cart Qty
    function updateQty(value1, value2, value3, value4, value5, value6) {
        $(document).ready(function() {
            var quantity = value1;
            var productname = value2;
            var model = value3;
            var manufacturer = value4;
            var price = value5;
            var amount = value6;
            if (quantity && productname && model && manufacturer && price != "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/sales/update_quantity.php",
                    method: "POST",
                    data: {
                        quantity: quantity,
                        productname: productname,
                        model: model,
                        manufacturer: manufacturer,
                        price: price,
                        amount: amount
                    },
                    success: function(data) {
                        loadBillingProduct();
                    }
                });
            } else {
                loadBillingProduct();
            }
        });

    }

    function updateQtyFromField(input) {
        const quantity = input.value;
        const productname = input.dataset.name;
        const model = input.dataset.model;
        const manufacturer = input.dataset.manufacturer;
        const price = input.dataset.price;
        const amount = quantity * price;

        if (quantity && productname && model && manufacturer && price) {
            $.ajax({
                url: "/emma_auto_investment/ajax/shared/sales/update_quantity.php",
                method: "POST",
                data: {
                    quantity: quantity,
                    productname: productname,
                    model: model,
                    manufacturer: manufacturer,
                    price: price,
                    amount: amount
                },
                success: function(data) {
                    // console.log("Quantity updated:", data);
                    loadBillingProduct(); // Refresh the table
                },
                error: function() {
                    alert("Failed to update quantity.");
                }
            });
        }
    }


    function deleteItem(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                loadBillingProduct(); // Refreshes cart content via AJAX
            }
        };
        xhttp.open("GET", "/emma_auto_investment/ajax/shared/sales/delete_item.php?id=" + id, true);
        xhttp.send();
    }





    loadBillingProduct()

    function remove() {
        document.getElementById('model').value = '';
        document.getElementById('manufacturer').value = '';
        document.getElementById('price').value = '';
        document.getElementById('qty').value = '';
        document.getElementById('total').value = '';
    }
</script>


<script>
    // function calculateTotals() {
    //     let qtyFields = document.querySelectorAll(".qty-field");
    //     let amountCells = document.querySelectorAll(".amount-cell");
    //     let total = 0;

    //     qtyFields.forEach((input, index) => {
    //         const price = parseFloat(input.dataset.price) || 0;
    //         const qty = parseInt(input.value) || 0;
    //         const amount = qty * price;
    //         amountCells[index].textContent = amount.toFixed(2);
    //         total += amount;
    //     });

    //     document.getElementById("tot").value = total;
    //     document.getElementById("totalDisplay").textContent = total.toFixed(2);

    //     // Get input values
    //     const cash = parseFloat(document.getElementById("cash").value) || 0;
    //     const transfer = parseFloat(document.getElementById("transfer").value) || 0;
    //     const pos = parseFloat(document.getElementById("pos").value) || 0;
    //     const transport = parseFloat(document.getElementById("transport")?.value) || 0;
    //     const oldDeposit = parseFloat(document.getElementById("old_deposit")?.value) || 0;

    //     const totalDeposit = cash + transfer + pos + oldDeposit;
    //     const balance = total + transport - totalDeposit;

    //     document.getElementById("deposit").value = totalDeposit.toFixed(2);
    //     document.getElementById("balance").value = balance.toFixed(2);
    // }

    function calculateTotals() {
        let qtyFields = document.querySelectorAll(".qty-field");
        let amountCells = document.querySelectorAll(".amount-cell");
        let total = 0;

        qtyFields.forEach((input, index) => {
            const price = parseFloat(input.dataset.price) || 0;
            const qty = parseInt(input.value) || 0;
            const amount = qty * price;
            amountCells[index].textContent = amount.toFixed(2);
            total += amount;
        });

        document.getElementById("tot").value = total;
        document.getElementById("totalDisplay").textContent = total.toFixed(2);

        // Get values from inputs
        const cash = parseFloat(document.getElementById("cash").value) || 0;
        const transfer = parseFloat(document.getElementById("transfer").value) || 0;
        const pos = parseFloat(document.getElementById("pos").value) || 0;
        const transport = parseFloat(document.getElementById("transport")?.value) || 0;
        const oldDeposit = parseFloat(document.getElementById("old_deposit")?.value) || 0;

        const totalDeposit = cash + transfer + pos + oldDeposit;
        let balance = total + transport;

        // Only subtract deposit if there’s an actual payment
        if (totalDeposit > 0) {
            balance -= totalDeposit;
        }

        // Update DOM
        document.getElementById("deposit").value = totalDeposit.toFixed(2);
        document.getElementById("balance").value = balance.toFixed(2);
    }
    document.addEventListener("DOMContentLoaded", () => {
        calculateTotals(); // Initial load

        // Attach both input and change events to quantity fields
        document.querySelectorAll(".qty-field").forEach((input) => {
            input.addEventListener("input", calculateTotals);
            input.addEventListener("change", calculateTotals);
        });
    });



    function toggleTransportField() {
        const row = document.getElementById("transportRow");
        row.style.display = document.getElementById("add_transport").checked ? "" : "none";
        calculateTotals();
    }

    function showBankSelect() {
        const transfer = document.getElementById("transfer").value;
        const bankSelect = `
        <select class="form-control" name="bank" id="bank">
            <option value="">Select Bank</option>
            <option value="First Bank">First Bank</option>
            <option value="UBA">UBA</option>
            <option value="Zenith Bank">Zenith Bank</option>
            <option value="Polaris Bank">Polaris Bank</option>
            <option value="Sterling Bank">Sterling Bank</option>
        </select>`;
        document.getElementById("bank_select").innerHTML = transfer > 0 ? bankSelect : '';
    }

    function showPosSelect() {
        const pos = document.getElementById("pos").value;
        const posSelect = `
        <select class="form-control" name="pos_type" id="pos_type">
            <option value="">Select POS</option>
            <option value="Opay">Opay</option>
            <option value="Monie Point">Monie Point</option>
        </select>
        <span class="font-weight-bold">Charges</span>
        <div class="form-inline">
            <input class="form-control" type="radio" name="pos_charges" id="pos_charges" value="50">&nbsp;&nbsp; <label for="">50</label>&nbsp;&nbsp;
            <input class="form-control" type="radio" name="pos_charges" id="pos_charges" value="100">&nbsp;&nbsp; <label for="">100</label>
        </div>`;
        document.getElementById("pos_select").innerHTML = pos > 0 ? posSelect : '';
    }

    function checkDeposit() {
        const checked = document.getElementById("check").checked;
        if (!checked) {
            document.getElementById("depositRow").style.display = "none";
            document.getElementById("old_deposit").value = 0;
            calculateTotals();
            return;
        }

        const name = document.getElementById("customer_name").value;
        const title = document.getElementById("title").value;
        const customer_address = document.getElementById("address").value;
        if (!name || !customer_address) return;

        // Call server via AJAX to verify deposit
        fetch(`/emma_auto_investment/ajax/shared/sales/check_deposit.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    title: title,
                    name: name,
                    customer_address: customer_address
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("depositRow").style.display = "";
                    document.getElementById("old_deposit").value = data.amount;
                } else {
                    document.getElementById("depositRow").style.display = "none";
                    document.getElementById("old_deposit").value = 0;
                }
                calculateTotals();
            });
    }

    document.addEventListener("DOMContentLoaded", calculateTotals);
</script>


<!--end-main-container-part-->
<?php
$sales_ctr->sales();
include "../includes/shared/sales/footer.php";
?>