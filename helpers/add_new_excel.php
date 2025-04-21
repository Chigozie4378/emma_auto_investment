<?php
include '_partial.php';
include "../includes/shared/verify_protected_page.php";
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = str_ends_with($basePath, '/helpers') ? './' : '../';

$stocks_ctr = new StocksController();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $basePath ?>assets/images/logo.jpg" type="image/gif" sizes="20x20">

    <!-- CSS Links -->
    <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= $basePath ?>assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= $basePath ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        body {
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.6), rgba(0, 0, 0, 0.8)), url('../assets/images/background.JPG');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        form {
            padding-top: 20%;
        }

        img {
            color: white;
        }
    </style>


</head>

<body>


    <div class="row">
        <div class="offset-4 col-4">

            <div class="text-center">
                <h2>Excel New Product Upload</h2>
                <label for="exampleInputFile"><img width="80px" height="90px" src="../assets/images/file_ulpoad_icon.png" alt=""></label>
            </div>
            <span class="text-white" style="font-weight: bold;"><?php $stocks_ctr->addproductByExcel() ?></span>
            <form method="POST" enctype="multipart/form-data">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Uploads</h3>
                    </div>
                    <div class="card-body">
                        <label for="exampleInputPassword1">Select File(s)</label>
                        <input type="file" name="excel" id="select_file" class="form-control">
                    </div>
                    <div class="card-footer">
                        <input style="float: right;" type="submit" value="Upload" name="upload" id="upload" class="btn btn-primary">
                    </div>

            </form>

        </div>
        <div class="text-center">
            <a href="javascript:history.back()" class="btn btn-default">Go Back</a>
        </div>
    </div>

    <!-- <p style="color:rgb(86, 86, 225)"><?php echo $message ?></p>
    <form action="" method="post" enctype="multipart/form-data">
    upload File:
    <input type="file" name="excel" id="">
    <input type="submit" name = "upload" value="Upload">
    </form> -->

    <!-- original pen: https://codepen.io/roydigerhund/pen/ZQdbeN  -->


    <!-- Core JS Libraries -->
    <script src="<?php echo $basePath; ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $basePath; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button); // Resolve conflict between jQuery UI & Bootstrap
    </script>
    <script src="<?php echo $basePath; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $basePath; ?>assets/dist/js/adminlte.js"></script>
    <script>
        const currentPageToExpire = "<?php echo basename($_SERVER['PHP_SELF']); ?>";

        // Detect if the tab is hidden or navigated away from
        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === "hidden") {
                fetch("<?= BASE_URL ?>ajax/shared/users/clear_verification.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        page: currentPageToExpire
                    }),
                    keepalive: true // ensures it works even on page unload
                });
            }
        });
    </script>

</body>

</html>

<!--Action boxes-->


<!--end-main-container-part-->