<?php 
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$ctr = new Controller();
?>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="retail.php">RETAIL</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="wholesale.php">WHOLESALE</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="cartoon.php">CARTOON</a>
  </li>
</ul>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">SALES</h3>
                    </div>
                    <form action="" method="post" class="form-horizontal">
                        <div class="card-body">
                            <div class="container-fluid">
                                
                                <div class="row">
                                    <div class="col-sm-3"><h6>Customer Name</h6> <input type="text" class="form-control" name="customer_name"
                                            value="<?php $ctr->oldValue(" customer_name")?>"></div>
                                    <div class="col-sm-3"><h6>Address</h6><input type="text" class="form-control" name="address"
                                            value="<?php $ctr->oldValue(" address")?>">
                                    </div>
                                    <div class="col-sm-2"><h6>Payment Type</h6> <select class="form-control" name="bill_type">
                                            <?php $ctr->oldSelect("bill_type");?>
                                            <option disabled>Select Payment Type
                                            <option>
                                            <option>Cash</option>
                                            <option>Transfer</option>
                                            <option>Debit</option>
                                            <option>Cash/Transfer</option>
                                            <option>Cash/Debit</option>
                                            <option>Transfer/Debit</option>
                                            <option>Cash/Transfer/Debit</option>
                                        </select></div>
                                    <div class="col-sm-2"><h6>Invoice No</h6><input type="text" class="form-control" name="invoice_no"
                                            value="<?php $ctr->random()?>" readonly>
                                    </div>

                                    <div class="col-sm-2"><h6>Date</h6> <input type="text" class="form-control" name="date"
                                            value="<?php echo date(" d-m-Y") ?>"
                                        readonly></div>
                                </div>
                                <center>
                                    <h4 class="text-primary">Select A Product</h4>
                                </center>
                                
                                <div class="row">
                                    <div class="col-sm-2">
                                      <h6>Product Name</h6>
                                         <input width="50" class="form-control" type="text"
                                            name="productname" onmouseout="selectProduct(this.value)" id="productname"
                                            placeholder="Enter Product Name" list="product">
                                        <datalist id="product" style="height:5.1em;overflow:hidden">
                                            <?php
                                                            $mod = new Model();
                                                            $select = $mod->showProductInput();
                                                            while ($row = mysqli_fetch_array($select)){?>
                                            <option value="<?php echo $row['name']?>">
                                                <?php echo $row['name']?>
                                            </option>
                                            <?php     
                                                            }
                                                                ?>
                                        </datalist>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6>Model</h6>
                                        <div id="modeldev">
                                            <select class="form-control">
                                                <option value=""></option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6>Company</h6>
                                        <div id="manufacturerdev">
                                            <select class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6>Price</h6>
                                        <div id="priceDiv">
                                            <input type="text" class="form-control" readonly value="0">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6>Qty</h6>
                                        <div id="demo">

                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-2"><h6>Total</h6> 
                                    <input type="text" class="form-control" id="total" value="0"
                                            readonly></div>
                                </div>
                                <h6>&nbsp</h6>
                                <center><input type="submit" class="btn btn-success" value="Add"
                                        onclick="addIntoCart()"></center>





                                <div class="row-fluid"
                                    style="background-color: white; min-height: 100px; padding:10px;">
                                    <div class="span12">
                                        <center>
                                            <h4>Taken Products</h4>
                                        </center>

                                        <div id="load_billing">

                                        </div>

                                        <br><br><br><br>

                                        <center>
                                            <input type="submit" id="generate_bill" name="generate_bill"
                                                value="generate bill" class="btn btn-success">
                                        </center>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="ajax/sales_loader.js"></script>
<?php
    
$ctr->sales();

include "includes/footer.php";
?>