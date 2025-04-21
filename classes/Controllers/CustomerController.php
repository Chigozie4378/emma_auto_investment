<?php
class CustomerController extends ControllerV2
{
    public function addCustomer()
    {
        if (isset($_POST["add"])) {
            $customer_name = mysqli_escape_string($this->connect(), $_POST["customername"]);
            $address = mysqli_escape_string($this->connect(), $_POST["address"]);
            $phone_no = mysqli_escape_string($this->connect(), $_POST["phone_no"]);
            $customer = $this->fetchResult("customer", ["customer_name=$customer_name", "address=$address", "phone_no=$phone_no"]);
            $generatedId = UniqueID::generate("customer", "customer_id", true);

            $count = mysqli_num_rows($customer);
            if ($count > 0) { ?>

                <script>
                    document.getElementById('danger').style.display = 'block';
                    document.getElementById('success').style.display = 'none';
                </script>
            <?php } else {
                $this->insert("customer", $customer_name, $address, $phone_no,$generatedId);
            ?>
                <script>
                    document.getElementById('danger').style.display = 'none';
                    document.getElementById('success').style.display = 'block';
                    setTimeout(function() {
                        window.location.href = window.location.href
                    }, 1000);
                </script>
<?php }
        }
    }
    public function showCustomer()
    {
       
        return $this->fetchResult("customer");

    }
    public function paginateCustomer()
    {
        // Get total records from your method
        $count = mysqli_fetch_assoc($this->fetchResult("customer", cols: "COUNT(*) AS total_count",order_by:"id DESC"));
        $totalRecords = (int)$count['total_count'];
        $pagination = new Pagination($totalRecords, 50, "add_new_customer.php");

        // Fetch paginated result
        return [
            'results' => $this->fetchResult("customer", limit: $pagination->limit, offset: $pagination->offset),
            'pagination' => $pagination->render()
        ];
    }
    
    public function customerDelete()
    {
        if (isset($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
            if ($_GET['customer_id']) {
                $this->trashWhere("customer", "customer_id =$customer_id"); ?>
                <script>
                    document.getElementById('delete').style.display = 'block';
                </script>
<?php }
            new Redirect("add_new_customer.php");
        }
    }
    public function customerEdit()
    {
        if (isset($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
            if ($_GET['customer_id']) {
                return $this->fetchResult("customer",["customer_id=$customer_id"]); 
                
            }
        }
    }
    public function customerUpdate()
    {
        if (isset($_POST["update"])) {
            $customer_id = mysqli_escape_string($this->connect(), $_POST["customer_id"]);
            $customer_name = mysqli_escape_string($this->connect(), $_POST["customername"]);
            $address = mysqli_escape_string($this->connect(), $_POST["address"]);
            $phone_no = mysqli_escape_string($this->connect(), $_POST["phone_no"]);

            $this->updates("customer",
            U::col( "customer_name=$customer_name","address=$address","phone_no=$phone_no"),
            U::where("customer_id=$customer_id"));
            
            echo "<script>
                    document.getElementById('update').style.display='block';
                     setTimeout(function(){
                         window.location = 'add_new_customer.php'
                      }, 1000);
            </script>";
        }
    }
}
?>