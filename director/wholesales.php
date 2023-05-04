<?php
session_start();
include "core/init.php";
include "includes/sales/header.php";
include "includes/sales/head.php";
include "includes/sales/navbar.php";

$mod = new Model();
$ctr = new Controller();
?>

<section class="content">
  <form action="" method="post">
    <input name="customer_type" type="hidden" value="wholesale">
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
                      <select id="title" name="title" class="form-control" style="width: 80px;">
                        <?php
                        echo $_POST['title'];
                        if (isset($_POST["title"])) { ?>
                          <option value="<?php echo $_POST['title'] ?>"><?php echo $_POST['title'] ?></option>
                        <?php  }
                        ?>
                        <option value=""></option>
                        <option value="MR">MR</option>
                        <option value="MRS">MRS</option>
                        <option value="MRS">MISS</option>
                        <option value="ALHAJI">ALHAJI</option>
                        <option value="ALHAJA">ALHAJA</option>
                      </select>
                    </div>
                    <div class="col-md 9">
                      <!-- <input type="text" name="customer_name" class="form-control" value="<?php $ctr->oldValue("customer_name") ?>"> -->
                      <input list="list-customers" class="form-control" id="customer_name" name="customer_name" value="<?php $ctr->oldValue("customer_name") ?>">
                      <datalist id="list-customers">
                        <?php
                        $select1 = $mod->showSalesCustomerName();
                        while ($row2 = mysqli_fetch_array($select1)) {
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
                  <!-- <input type="text" name="address" value="<?php $ctr->oldValue("address") ?>" class="form-control"> -->
                  <input list="list-address" class="form-control" id="address" name="address" value="<?php $ctr->oldValue("address") ?>">
                  <datalist id="list-address">
                    <?php
                    $select2 = $mod->showSalesCustomerAddress();
                    while ($row3 = mysqli_fetch_array($select2)) { ?>
                      <option value="<?php echo $row3['address'] ?>">
                      <?php
                    }
                      ?>
                  </datalist>
                </div>
                <div class="col-sm-4"><label for="">Invoice No. : </label></div>
                <div class="col-sm-8" id="invoice_no"> <input type="text" class="form-control" name="invoice_no" value="<?php $ctr->random() ?>" readonly>
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
              <div class="row" id="wPriceQty">
                <div class="col-sm-4 pt-1">
                  <h6>Unit Price</h6>

                </div>
                <div class="col-sm-8 pt-1">
                  <div id="wpriceDiv">
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
              <div class="text-center pt-1"> <input type="button" name="add" class="btn btn-light" value="Add" onclick="addIntoCart()">
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
      if (manufacturer && model && productname != "") {
        $.ajax({
          url: "sales_ajax/load_wprice.php",
          method: "POST",
          data: {
            manufacturer: manufacturer,
            model: model,
            productname: productname,
          },
          success: function(data) {
            $("#wPriceQty").html(data)
          }

        });
      } else {
        $("#wPriceQty").css("display", "none")
      }
    });
  }
  //JQuery Ajax for productname
  function selectProduct(value) {
    $(document).ready(function() {
      var productname = value;
      if (productname != "") {
        $.ajax({
          url: "sales_ajax/load_model.php",
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
          url: "sales_ajax/load_manufacturer.php",
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



  //JQuery Ajax for load Qty
  // function loadDoc(value1, value2, value3) {
  //   $(document).ready(function() {
  //     var manufacturer = value3;
  //     var model = value2;
  //     var productname = value1;
  //     if (manufacturer && model && productname != "") {
  //       $.ajax({
  //         url: "sales_ajax/load_quantity.php",
  //         method: "POST",
  //         data: {
  //           manufacturer: manufacturer,
  //           model: model,
  //           productname: productname
  //         },
  //         success: function(data) {
  //           $("#demo").html(data);
  //         }
  //       });
  //     } else {
  //       $("#demo").css("display", "none");
  //     }
  //   });

  // }

  function quantity(qty) {

    document.getElementById("total").value = eval(document.getElementById("qty").value) * eval(document.getElementById("price").value)
  }


  function addIntoCart() {
    $(document).ready(function() {
      var productname = document.getElementById("productname").value;
      var model = document.getElementById("model").value;
      var manufacturer = document.getElementById("manufacturer").value;
      var quantity = document.getElementById("qty").value;
      var price = document.getElementById("price").value;
      var total = document.getElementById("total").value;
      var product_id = document.getElementById("product_id").value;
      var qty_db = document.getElementById("qty_db").value;
      if (manufacturer && model && productname && quantity && price && total && product_id && qty_db != "") {
        $.ajax({
          url: "sales_ajax/load_cart.php",
          method: "POST",
          data: {
            manufacturer: manufacturer,
            model: model,
            productname: productname,
            quantity: quantity,
            price: price,
            total: total,
            product_id: product_id,
            qty_db: qty_db
          },
          success: function(data) {
            loadBillingProduct();
            remove();
          }
        });
      } else {
        loadBillingProduct();
      }
    });
  }

  function loadBillingProduct() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("load_billing").innerHTML = this.responseText;
      }
    };
    xhttp.open("POST", "sales_ajax/load_bill_product.php", true);
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
          url: "sales_ajax/update_quantity.php",
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

  function deleteItem(id) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.respondText == "") {

          loadBillingProduct();
        } else {

          loadBillingProduct();
        }
      }
    };

    xhttp.open("GET", "sales_ajax/delete_item.php?id=" + id, true);
    xhttp.send();
  }

  function transferCalc(transfer, pos, cash, total, old_deposit, transport, charges) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depositBal").innerHTML = this.responseText;

      }
    };
    xhttp.open("GET", "sales_ajax/load_deposit.php?cash=" + cash + "&pos=" + pos + "&transfer=" + transfer + "&total=" + total + "&old_deposit=" + old_deposit + "&transport=" + transport + "&charges=" + charges, true);
    xhttp.send();

  }

  function cashCalc(transfer, pos, cash, total, old_deposit, transport, charges) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depositBal").innerHTML = this.responseText;

      }
    };
    xhttp.open("GET", "sales_ajax/load_deposit.php?cash=" + cash + "&pos=" + pos + "&transfer=" + transfer + "&total=" + total + "&old_deposit=" + old_deposit + "&transport=" + transport + "&charges=" + charges, true);
    xhttp.send();

  }

  function posCalc(pos, transfer, cash, total, old_deposit, transport, charges) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depositBal").innerHTML = this.responseText;

      }
    };
    xhttp.open("GET", "sales_ajax/load_deposit.php?pos=" + pos + "&cash=" + cash + "&transfer=" + transfer + "&total=" + total + "&old_deposit=" + old_deposit + "&transport=" + transport + "&charges=" + charges, true);
    xhttp.send();

  }

  function transportCalc(transport, pos, transfer, cash, total, old_deposit, charges) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depositBal").innerHTML = this.responseText;

      }
    };
    xhttp.open("GET", "sales_ajax/load_deposit.php?transport=" + transport + "&pos=" + pos + "&cash=" + cash + "&transfer=" + transfer + "&total=" + total + "&old_deposit=" + old_deposit + "&charges=" + charges, true);
    xhttp.send();

  }

  function addCharges(charges, transfer, pos, cash, total, old_deposit, transport) {
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depositBal").innerHTML =
          this.responseText;
      }
    };
    xhttp.open("GET", "sales_ajax/load_deposit.php?charges=" + charges + "&cash=" + cash + "&pos=" + pos + "&transfer=" + transfer + "&total=" + total + "&old_deposit=" + old_deposit + "&transport=" + transport, true);
    xhttp.send();
  }

  function addTransport() {
    var checkBox = document.getElementById("add_transport");
    if (checkBox.checked == true) {
      const xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("transportDiv").innerHTML =
            this.responseText;
        }
      };
      xhttp.open("GET", "sales_ajax/load_transport.php", true);
      xhttp.send();
    } else {
      const xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("transportDiv").style.display = "none";

        }
      };
      xhttp.open("GET", "sales_ajax/load_transport.php", true);
      xhttp.send();
    }

  }

  function selectPos() {
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("select_pos").innerHTML =
          this.responseText;
      }
    };
    xhttp.open("GET", "sales_ajax/load_pos.php", true);
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
    xhttp.open("GET", "sales_ajax/load_select_bank.php", true);
    xhttp.send();
  }

  function updatePage() {
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("invoice_no").innerHTML =
          this.responseText;
      }
    };
    xhttp.open("GET", "sales_ajax/load_invoice_no.php", true);
    xhttp.send();
  }

  // Update the page every 10 seconds
  setInterval(updatePage, 300);






  function checkDeposit(value1, value2, value3) {
    $(document).ready(function() {
      var title = value1;
      var customer_name = value2;
      var customer_address = value3;
      if (customer_name && customer_address != "") {
        $.ajax({
          url: "sales_ajax/check_deposit.php",
          method: "POST",
          data: {
            title: title,
            customer_name: customer_name,
            customer_address: customer_address
          },
          success: function(data) {
            $("#deposit_amount").html(data);
          }
        });
      } else {
        $("#deposit_amount").css("display", "none");
      }
    });

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



<!--end-main-container-part-->
<?php
$ctr->sales();
include "includes/sales/footer.php";
?>