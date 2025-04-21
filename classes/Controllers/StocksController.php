<?php
class StocksController extends ControllerV2
{

    public function paginateStocks()
    {
        // Get total records from your method
        $count = mysqli_fetch_assoc($this->fetchResult("product", cols: "COUNT(*) AS total_count"));
        $totalRecords = (int)$count['total_count'];
        $pagination = new Pagination($totalRecords, 50, "stock.php");

        // Fetch paginated result
        return [
            'results' => $this->fetchResult("product", limit: $pagination->limit, offset: $pagination->offset),
            'pagination' => $pagination->render()
        ];
    }

    public function selectProductName($productname)
    {
        return $this->fetchResult("product", ["name=$productname"], oper: ["LIKE"]);
    }
    public function selectModel($productname, $model)
    {
        return $this->fetchResult("product", ["name=$productname", "model=$model"], oper: ["LIKE", "LIKE"]);
    }
    public function selectManufacturer($productname, $model, $manufacturer)
    {
        return $this->fetchResult("product", ["name=$productname", "model=$model", "manufacturer=$manufacturer"], oper: ["LIKE", "LIKE", "LIKE"]);
    }
    public function show10LatestProduct()
    {
        return $this->fetchResult("product", order_by: "id DESC", limit: 10);
    }
    public function checkProduct($productname, $model, $manufacturer){
        return $this->fetchResult("product", ["name=$productname", "model=$model", "manufacturer=$manufacturer"]);
    }

    public function ProductEdit($tablename)
    {
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            if ($_GET['product_id']) {
                $row = mysqli_fetch_assoc($this->fetchResult("product", ["product_id = $product_id"]));
                return $row["$tablename"];
            }
        }
    }
    public function ProductUpdate()
    {
        if (isset($_POST["edit"])) {
            $product_id = mysqli_escape_string($this->connect(), $_POST["product_id"]);
            $name = mysqli_escape_string($this->connect(), $_POST["name"]);
            $model = mysqli_escape_string($this->connect(), $_POST["model"]);
            $manufacturer = mysqli_escape_string($this->connect(), $_POST["manufacturer"]);
            $new_quantity = $_POST["quantity"];
            $old_quantity = $_POST["quantity1"];
            $quantity = (int)$old_quantity + (int)$new_quantity;
            $cprice = mysqli_escape_string($this->connect(), $_POST["cprice"]);
            $wprice = mysqli_escape_string($this->connect(), $_POST["wprice"]);
            $rprice = mysqli_escape_string($this->connect(), $_POST["rprice"]);

            $this->updates(
                "product",
                U::col("name=$name", "model=$model", "manufacturer=$manufacturer", "quantity=$quantity", "cprice=$cprice", "wprice=$wprice", "rprice=$rprice"),
                U::where("product_id=$product_id")
            );
            echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = 'stock.php'
                    }, 500);
            </script>";
        }
    }
    public function addNewProduct()
    {
        if (isset($_POST["add"])) {
            $name = mysqli_escape_string($this->connect(), $_POST["name"]);
            $model = mysqli_escape_string($this->connect(), $_POST["model"]);
            $manufacturer = mysqli_escape_string($this->connect(), $_POST["manufacturer"]);
            $quantity = mysqli_escape_string($this->connect(), $_POST["quantity"]);
            $cprice = mysqli_escape_string($this->connect(), $_POST["c_price"]);
            $wprice = mysqli_escape_string($this->connect(), $_POST["w_price"]);
            $rprice = mysqli_escape_string($this->connect(), $_POST["r_price"]);
            $generatedId = UniqueID::generate("product", "product_id", true);

            $Product = $this->fetchResult("product", ["name=$name", "model=$model", "manufacturer=$manufacturer"]);
            $count = mysqli_num_rows($Product);
            if ($count > 0) { ?>

                <script>
                    document.getElementById('danger').style.display = 'block';
                    document.getElementById('success').style.display = 'none';
                </script>
            <?php } else {
                $this->insert("product", $name, $manufacturer, $model, $quantity, $cprice, $wprice, $rprice, $generatedId);
            ?>
                <script>
                    document.getElementById('danger').style.display = 'none';
                    document.getElementById('success').style.display = 'block';
                    // setTimeout(function(){
                    //    window.location.href = window.location.href
                    // }, 3000);
                </script>
            <?php }
        }
    }
    public function ProductDelete()
    {
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            if ($_GET['product_id']) {
                $this->trashWhere("product", "product_id =$product_id"); ?>
                <script>
                    document.getElementById('delete').style.display = 'block';
                </script>
<?php }
            new Redirect("stock.php");
        }
    }

    public function addproductByExcel()
    {

        if (isset($_POST["upload"])) {
            if ($_FILES["excel"]["name"]) {
                $filename = explode(".", $_FILES["excel"]["name"]);
                if (end($filename) == "csv") {
                    $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                    $row = 1;
                    while ($data = fgetcsv($handle)) {
                        if ($row == 1) {
                            $row++;
                            continue;
                        }
                        $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                        $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                        $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                        $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                        $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                        $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                        $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));
                        $generatedId = UniqueID::generate("product", "product_id", true);

                        $product = $this->fetchResult("product", ["name=$name", "model=$model", "manufacturer=$manufacturer"]);
                        $count = mysqli_num_rows($product);
                        if ($count > 0) {
                            echo $message = $name . " " . $model . " " . $manufacturer . " Already Exist! ";
                        } else {
                            ini_set('max_execution_time', 5000);
                            ini_set('max_input_time', 5000);
                            ini_set('upload_max_filesize', '100M');
                            ini_set('post_max_size', '100M');
                            ini_set('memory_limit', '3560M');
                            $this->insert("product", $name, $manufacturer, $model, $qty, $cprice, $wprice, $rprice, $generatedId);

                            new Redirect("stock.php");
                        }
                    }
                    fclose($handle);
                } else {
                    echo $message = "Please Select a CSV File";
                }
            } else {
                echo $message = "Please Select a File";
            }
        }
    }
    public function updateExcelPrice()
    {

        if (isset($_POST["upload"])) {
            if ($_FILES["excel"]["name"]) {
                $filename = explode(".", $_FILES["excel"]["name"]);
                if (end($filename) == "csv") {
                    $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                    $row = 1;
                    while ($data = fgetcsv($handle)) {
                        if ($row == 1) {
                            $row++;
                            continue;
                        }
                        $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                        $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                        $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                        $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                        $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                        $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                        $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));
                        ini_set('max_execution_time', 5000);
                        ini_set('max_input_time', 5000);
                        ini_set('upload_max_filesize', '100M');
                        ini_set('post_max_size', '100M');
                        ini_set('memory_limit', '3560M');
                        $this->updates(
                            "product",
                            U::col("cprice=$cprice", "wprice=$wprice", "rprice=$rprice"),
                            U::where("name=$name","manufacturer=$manufacturer", "model=$model")
                        );
                        new Redirect("stock.php");
                    }
                    fclose($handle);
                } else {
                    echo  "Please Select a CSV File";
                }
            } else {
                echo "Please Select a File";
            }
        }
    }
    public function updateExcelQty()
    {

        if (isset($_POST["upload"])) {
            if ($_FILES["excel"]["name"]) {
                $filename = explode(".", $_FILES["excel"]["name"]);
                if (end($filename) == "csv") {
                    $handle = fopen($_FILES["excel"]["tmp_name"], "r");
                    $row = 1;
                    while ($data = fgetcsv($handle)) {
                        if ($row == 1) {
                            $row++;
                            continue;
                        }
                        $name = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[0])));
                        $manufacturer = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[1])));
                        $model = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[2])));
                        $qty = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[3])));
                        $cprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[4])));
                        $wprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[5])));
                        $rprice = trim(str_replace("  ", " ", mysqli_real_escape_string($this->connect(), $data[6])));
                        ini_set('max_execution_time', 5000);
                        ini_set('max_input_time', 5000);
                        ini_set('upload_max_filesize', '100M');
                        ini_set('post_max_size', '100M');
                        ini_set('memory_limit', '3560M');
                        $this->updates(
                            "product",
                            U::col("quantity= quantity+$qty"),
                            U::where("name=$name","manufacturer=$manufacturer", "model=$model")
                        );

                        new Redirect("stock.php");
                    }
                    fclose($handle);
                } else {
                    echo $message = "Please Select a CSV File";
                }
            } else {
                echo $message = "Please Select a File";
            }
        }
    }
}