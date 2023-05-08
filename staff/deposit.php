<?php
session_start();

include "core/init.php";

$mod = new Model();
$ctr = new Controller();
?>
<?php
include "includes/header.php";
include "includes/head.php";
include "includes/navbar.php";
$ctr->addDeposit();

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
                        <input type="hidden" name="invoice_no" value="<?php $ctr->random() ?>">
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


            <div class="add-items-section"></div>
            <div class="deposit-section float-right pb-4" style="display: none;">
                <input class="form-control" style="width:100%;box-sizing:border-box; display:none;" name="pos_charges" id="pos_charges" value="0" required>
                <label for="cash">Cash</label>
                <input class="form-control" style="width:100%;box-sizing:border-box" onkeyup="cashCalc(this.value,document.getElementById('pos').value,document.getElementById('transfer').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="number" name="cash" id="cash" value="0" required>
                <p></p>
                <label for="transfer">Transfer</label>
                <input onkeydown="selectBank()" class="form-control" style="width:100%;box-sizing:border-box" onkeyup="transferCalc(this.value,document.getElementById('pos').value,document.getElementById('cash').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="number" name="transfer" id="transfer" value="0" required>
                <span id="select_bank"></span>
                <p></p>
                <label for="pos">POS</label>
                <input class="form-control" onkeydown="selectPos()" style="width:100%;box-sizing:border-box" onkeyup="posCalc(this.value,document.getElementById('transfer').value,document.getElementById('cash').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="number" name="pos" id="pos" value="0" required>
                <span id="select_pos"></span>
                <p></p>
                <label for="amount">Deposit Amount</label>
                <div id="deposit" class="mb-2">
                    <input type="number" name="deposit_amount" id="deposit_amount" class="form-control" readonly>
                </div>
                <input type="submit" class="btn btn-primary" value="Make Deposit">
            </div>
        </form>


    </div>

</section>
<script>
    function transferCalc(transfer, pos, cash, pos_charges) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deposit").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/load_deposit2.php?cash=" + cash + "&pos=" + pos + "&transfer=" + transfer + "&pos_charges=" + pos_charges, true);
        xhttp.send();

    }

    function cashCalc(transfer, pos, cash, pos_charges) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deposit").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/load_deposit2.php?cash=" + cash + "&pos=" + pos + "&transfer=" + transfer + "&pos_charges=" + pos_charges, true);
        xhttp.send();

    }

    function posCalc(pos, transfer, cash, pos_charges) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deposit").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/load_deposit2.php?pos=" + pos + "&cash=" + cash + "&transfer=" + transfer + "&pos_charges=" + pos_charges, true);
        xhttp.send();

    }

    function addCharges(pos_charges, pos, transfer, cash) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deposit").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/load_deposit2.php?pos_charges=" + pos_charges + "&pos=" + pos + "&cash=" + cash + "&transfer=" + transfer, true);
        xhttp.send();

    }

    function selectPos() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("select_pos").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_pos2.php", true);
        xhttp.send();
    }

    function selectBank() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("select_bank").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "ajax/load_select_bank.php", true);
        xhttp.send();
    }

    //JQuery Ajax for productname
    function selectProduct(value, index) {
        $(document).ready(function() {
            var productname = value;
            var no = index;
            if (productname != "") {
                $.ajax({
                    url: "ajax/load_model2.php",
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
                    url: "ajax/load_manufacturer.php",
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
                    $mod = new Model();
                    $select = $mod->showProductInput();
                    while ($row = mysqli_fetch_array($select)) { ?>
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
include "includes/footer.php";
?>
<?php
// session_start();

// // Establish database connection
// $host = "localhost";
// $user = "username";
// $pass = "password";
// $dbname = "database_name";
// $conn = mysqli_connect($host, $user, $pass, $dbname);

// if (isset($_POST['item'])) {
//     $items = $_POST['item'];
//     // Insert the data into a table
//     foreach ($items as $item) {
//         $escaped_item = mysqli_real_escape_string($conn, $item);
//         $sql = "INSERT INTO items (item_name) VALUES ('$escaped_item')";
//         mysqli_query($conn, $sql);
//     }
//     $_SESSION['item'] = $items;
//     // Redirect to another page to display the input values
//     header("Location: display.php");
// }

// if (isset($_SESSION['item'])) {
//     $items = $_SESSION['item'];
// } else {
//     $items = array();
// }
?>

<!-- <form method="post">
    <div id="input-container">
        <?php foreach ($items as $item) { ?>
            <input type="text" name="item[]" value="<?php echo htmlspecialchars($item); ?>">
        <?php } ?>
    </div>
    <button type="button" id="add-input">Add Input</button>
    <input type="submit" value="Save">
</form> -->