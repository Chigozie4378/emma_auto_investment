<?php 
session_start();

include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">ADD NEW PRODUCT</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                            <div class="form-group">
                            <label class="control-label">Name :</label>
                            <div>
                                <input  class="form-control" type="text" name="productname" onmouseover = "selectProduct(this.value)" list="productName" id="productname"  placeholder="Enter Product Name">
                                <datalist id="productName">
                    <?php
                        $select = $mod->showProductInput();
                        while ($row = mysqli_fetch_array($select)){?>
                                        <option value="<?php echo $row['name']?>">
                                            <?php echo $row['name']?>
                                        </option>
                     <?php }?>
                                </datalist>
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label">Model :</label>
                                <div class="" id="modeldev">
                                    <select  class="form-control" >
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label">Company :</label>
                                <div class="" id="manufacturerdev" >
                                    <select class="form-control">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label">Price :</label>
                                <div class="" id="priceDiv">
                                   <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label">Quantity :</label>
                                <div class="">
                                    <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity"
                                        Required />
                                </div>
                            </div>
                            
                            <div id="danger" class='alert alert-danger text-center' style="display: none;">
                                <strong>Danger!</strong> Product Already Exist.
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="add" class="btn btn-success" value="Add">
                            </div>
                            <div id="success" class='alert alert-success text-center' style="display: none;">
                                <strong>Success!</strong> Product Added Successfully.
                            </div>
                        </form>
<script>
    function selectProduct(productname) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("modeldev").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "ajax/load_model.php?productname="+productname, true);
    xhttp.send();
    }

    //
    function selectModel(model,productname) {
        
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("manufacturerdev").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "ajax/load_manufacturer.php?model="+model+"&productname="+productname, true);
      xhttp.send();
    }

    function selectManufaturer(manufacturer,model,productname) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("priceDiv").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "ajax/load_price.php?manufacturer="+manufacturer+"&model="+model+"&productname="+productname, true);
        xhttp.send();
      }
</script>
                        <?php
                   
                    $ctr->addNewProduct();
                    $ctr->ProductDelete();
                  ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>


<!--end-main-container-part-->  
<?php
include "includes/footer.php";
?>