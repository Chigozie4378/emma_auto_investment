<?php
session_start();

include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();
$ctr->import();
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="offset-md-4 col-md-4">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-white">EXPORT</h3>
                    </div>
                    <div class="card-body">
                        
                        <br />
                        <div><?php echo $ctr->message; ?></div>
                        <form method="post" enctype="multipart/form-data">
                            <p><label>Select Sql File</label>
                                <input type="file" name="database" />
                            </p>
                            <br />
                            <input type="submit" name="import" class="btn btn-info" value="Import" />
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>


<!--end-main-container-part-->
<?php
include "includes/footer.php";
?>