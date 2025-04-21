<?php
include __DIR__ . '/../_partial.php';
$sales_ctr = new SalesController();
$deposit_ctr = new DepositController();

include "../includes/shared/sales/header.php";
include "../includes/shared/sales/head.php";
include "../includes/shared/sales/navbar.php";
$deposit_ctr->addDeposit();
?>


<style>
    select option:hover {
        background-color: #007BFF;
    }
</style>

<section>
    <div class="container">

        <button type="button" class="btn btn-success" id="add-input">Add Good(s)</button>
        <form action="" method="post">
            <div id="customer" style="display: none;">
                <div class="row pb-3">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" value="Mr " required autocomplete="off">
                            <span class="text-danger"><?php echo $ctr->customer_nameErr ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <label for="customer_address">Customer Address</label>
                            <input type="text" id="customer_address" name="customer_address" class="form-control" required autocomplete="off">
                            <span class="text-danger"><?php echo $ctr->customer_addressErr ?></span>
                        </div>
                        <input type="hidden" name="invoice_no" value="<?= $sales_ctr->generateInvoice() ?>">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Product Name</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <h5>Model</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Manufacturer</h5>
                    </div>
                </div>
            </div>


            <div class="add-items-section">

            </div>

            <div class="deposit-section float-right pb-4" style="display: none;">
                <input class="form-control" style="width:100%;box-sizing:border-box; display:none;" name="pos_charges" id="pos_charges" value="0" required>
                <label for="cash">Cash</label>
                <input class="form-control" oninput="calculateDeposit()" onclick="this.select()" type="number" name="cash" id="cash" value="0" required>
                <p></p>
                <label for="transfer">Transfer</label>
                <input class="form-control"  oninput="calculateDeposit();selectBank()" onclick="this.select();" type="number" name="transfer" id="transfer" value="0" required>
                <span id="select_bank"></span>
                <p></p>
                <label for="pos">POS</label>
                <input class="form-control" oninput="calculateDeposit();selectPos();" onclick="this.select()" type="number" name="pos" id="pos" value="0" required>
                <span id="select_pos"></span>
                <p></p>
                <label for="amount">Deposit Amount</label>
                <div id="deposit" class="mb-2">
                    <input type="number" name="deposit_amount" id="deposit_amount" class="form-control" readonly>
                </div>
                <input type="submit" class="btn btn-primary" value="Make Deposit">
            </div>
        </form>
        <!-- Preloaded bank select (hidden initially) -->
        <div id="bankOptions" style="display:none;">
            <select class="form-control" name="bank" id="bank" required>
                <option value="" disabled selected>Select Bank</option>
                <option value="First Bank">First Bank</option>
                <option value="UBA">UBA</option>
                <option value="Zenith Bank">Zenith Bank</option>
                <option value="Polaris Bank">Polaris Bank</option>
                <option value="Sterling Bank">Sterling Bank</option>
            </select>
        </div>

        <!-- Preloaded POS options (hidden initially) -->
        <div id="posOptions" style="display:none;">
            <select class="form-control" name="pos_type" id="pos_type" required>
                <option value="" disabled selected>Select POS</option>
                <option value="Opay">Opay</option>
                <option value="Monie Point">Monie Point</option>
            </select>

            <div class="form-inline mt-2">
                <label for="">Charges</label>&nbsp;&nbsp;
                <input class="form-control" type="radio" name="pos_charge_radio" value="50"> <label>50</label>&nbsp;&nbsp;
                <input class="form-control" type="radio" name="pos_charge_radio" value="100"> <label>100</label>
            </div>
        </div>


    </div>

</section>
<script>
    function selectBank() {
        const transferVal = parseFloat(document.getElementById("transfer").value) || 0;
        const container = document.getElementById("select_bank");
        if (transferVal > 0) {
            container.innerHTML = document.getElementById("bankOptions").innerHTML;
        } else {
            container.innerHTML = ""; // clear it if 0
        }
    }


    function selectPos() {
        const posVal = parseFloat(document.getElementById("pos").value) || 0;
        const container = document.getElementById("select_pos");

        if (posVal > 0) {
            container.innerHTML = document.getElementById("posOptions").innerHTML;

            // Make sure #pos_charges input exists
            let posChargesInput = document.getElementById("pos_charges");
            if (!posChargesInput) {
                posChargesInput = document.createElement("input");
                posChargesInput.type = "hidden";
                posChargesInput.name = "pos_charges";
                posChargesInput.id = "pos_charges";
                posChargesInput.value = "0";
                document.querySelector(".deposit-section").appendChild(posChargesInput);
            }

            // Bind radios after DOM update
            setTimeout(() => {
                const radios = document.getElementsByName("pos_charge_radio");
                radios.forEach(radio => {
                    radio.addEventListener("change", () => {
                        document.getElementById("pos_charges").value = radio.value;
                        calculateDeposit();
                    });
                });
            }, 10);
        } else {
            container.innerHTML = ""; // clear if pos is 0
            // Also reset the pos_charges to 0 for consistency
            const posChargesInput = document.getElementById("pos_charges");
            if (posChargesInput) posChargesInput.value = 0;
        }
    }


    function calculateDeposit() {
        const getVal = (id) => {
            const el = document.getElementById(id);
            return el ? parseFloat(el.value) || 0 : 0;
        };

        const cash = getVal("cash");
        const transfer = getVal("transfer");
        const pos = getVal("pos");
        const charges = getVal("pos_charges");
        const depositInput = document.getElementById("deposit_amount");

        if (depositInput) {
            depositInput.value = cash + transfer + pos + charges;
        }
    }



    //JQuery Ajax for productname
    function selectProduct(value, index) {
        $(document).ready(function() {
            var productname = value;
            var no = index;
            if (productname != "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/deposit/load_model.php",
                    method: "POST",
                    data: {
                        productname: productname,
                        index: no,
                    },
                    success: function(data) {
                        $("#modeldev" + index).html(data);
                    }
                });
            } else {
                $("#modeldev").css("display", "none");
            }
        });

    }

    //JQuery Ajax for model
    function selectModel(value1, value2, index) {
        $(document).ready(function() {
            var model = value1;
            var productname = value2;
            var no = index;
            if (model && productname != "") {
                $.ajax({
                    url: "/emma_auto_investment/ajax/shared/deposit/load_manufacturer.php",
                    method: "POST",
                    data: {
                        model: model,
                        productname: productname,
                        index: no,
                    },
                    success: function(data) {
                        $("#manufacturerdev" + index).html(data);
                    }
                });
            } else {
                $("#manufacturerdev").css("display", "none");
            }
        });
    }
</script>
<script>
    // Add another input on button click
    const customer = document.querySelector("#customer")
    const depositSection = document.querySelector(".deposit-section");
    const addInputButton = document.querySelector("#add-input");
    const container = document.querySelector(".add-items-section");

    let inputIndex = 1;
    addInputButton.addEventListener("click", () => {
        const addRow = document.createElement("div");
        addRow.className = "row";
        addRow.innerHTML = `
        
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="product-name-container">
                                    <input type="text" class="form-control product-name-input" name="product-name-input-${inputIndex}" id="product-name-input-${inputIndex}" onchange="selectProduct(this.value,${inputIndex}) placeholder="Search Product name" autocomplete="off" />
                                    <select class="form-control" onclick="selectProduct(this.value,${inputIndex})">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                            <div id="modeldev${inputIndex}">
                    <select class="form-control">
                      <option value=""></option>
                    </select>

                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                            <div id="manufacturerdev${inputIndex}">
                    <select class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                            </div>
                        </div>
                    </div>
                </div>
               

      `;
        container.appendChild(addRow);
        inputIndex++;

        container.appendChild(addRow);
        inputIndex++;

        // Update the references to the input and select elements
        const productInputs = document.querySelectorAll(".product-name-input");

        const lastproductInput = productInputs[productInputs.length - 1];

        const selectProduct = addRow.querySelectorAll(".product-name-container select")[0];

        const optionsProduct = Array.from(selectProduct.options);


        // Hide the select field initially
        selectProduct.style.display = "none";
        // Show the select field and filter the options when the user types
        lastproductInput.addEventListener("input", () => {
            const searchTerm = lastproductInput.value.toLowerCase();
            const filteredProductOptions = optionsProduct
                .filter((option) => option.text.toLowerCase().includes(searchTerm))
                .slice(0, 10);

            selectProduct.innerHTML = "";
            filteredProductOptions.forEach((option) => selectProduct.appendChild(option));

            // Hide the select field if there are no matching options
            if (filteredProductOptions.length === 0) {
                selectProduct.style.display = "none";
            } else {
                selectProduct.style.display = "block";
                if (filteredProductOptions.length > 6) {
                    selectProduct.size = 6;
                } else {
                    selectProduct.size = filteredProductOptions.length || 1; // Set a minimum size of 1
                }
                if (filteredProductOptions.length === 1) {
                    lastproductInput.value = filteredProductOptions[0].text;
                    lastproductInput.dispatchEvent(new Event("input"));
                    // selectProduct.style.display = "none";
                }
            }
        });

        // Add event listener to hide the select field when an option is selected
        selectProduct.addEventListener("change", () => {
            selectProduct.style.display = "none";
        });

        // Hide the select field when the user clicks outside of it
        document.addEventListener("click", (event) => {
            if (!event.target.closest(".product-name-container")) {
                const selectsProduct = document.querySelectorAll(".product-name-container select");
                selectsProduct.forEach((productselect) => {
                    productselect.style.display = "none";
                });
            }
        });


        // Update the value of the text input field when an option is selected
        selectProduct.addEventListener("click", (event) => {
            const selectedProductValue = event.target.value;
            const selectedProductOption = optionsProduct.find((option) => option.value === selectedProductValue);
            if (selectedProductOption) {
                lastproductInput.value = selectedProductOption.text;
                lastproductInput.dispatchEvent(new Event("input"));
            }
            selectProduct.style.display = "none";
        });

        depositSection.style.display = "block";
        customer.style.display = "block";
    });
</script>

<?php
include "../includes/shared/sales/footer.php";
?>