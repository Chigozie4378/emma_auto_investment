<?php
class DepositController extends ControllerV2
{
    public $customer_nameErr = "";
    public $customer_addressErr = "";
    public function checkDeposit($customer_name, $customer_address)
    {
        $result = $this->fetchResult('deposit', ["customer_name=$customer_name", "customer_address=$customer_address"]);
        return $result->fetch_assoc();
    }
    public function checkDepositByInvoiceNo($invoice_no)
    {
        $result = $this->fetchResult('deposit', ["invoice_no=$invoice_no"]);
        return $result->fetch_assoc();
    }
    public function checkDepositDetailsByInvoiceNo($invoice_no)
    {
        $result = $this->fetchResult('deposit_details', ["invoice_no=$invoice_no"]);
        return $result;
    }
    public function allDeposit($customer_name, $customer_address)
    {
        $result = $this->fetchResult('deposit', ["customer_name=$customer_name", "customer_address=$customer_address"]);
        return $result->fetch_assoc();
    }
    public function paginateDeposit()
    {
        // Get total records from your method
        $count = mysqli_fetch_assoc($this->fetchResult("deposit", cols: "COUNT(*) AS total_count"));
        $totalRecords = (int)$count['total_count'];
        $pagination = new Pagination($totalRecords, 50, "show_deposit.php");

        // Fetch paginated result
        return [
            'results' => $this->fetchResult("deposit", limit: $pagination->limit, offset: $pagination->offset),
            'pagination' => $pagination->render()
        ];
    }
    public function searchByCustomerName($name)
    {

        return $this->fetchResult(
            "deposit",
            where: [
                "customer_name=$name"
            ],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByCustomerAddress($name, $address)
    {

        return $this->fetchResult(
            "deposit",
            where: [
                "customer_name=$name",
                "customer_address= $address"
            ],
            oper: ["LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByStaffName($staffname)
    {

        return $this->fetchResult(
            "deposit",
            where: [
                "staff=$staffname"
            ],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }
    public function viewDepositDetails()
    {
        if (isset($_GET['invoice_no'])) {
            $invoice_no = $_GET['invoice_no'];
            $customer_name = $_GET['customer_name'];
            $customer_address = $_GET['address'];
            return $this->fetchResult("deposit_details", ["invoice_no=$invoice_no", "customer_name=$customer_name", "customer_address$customer_address"]);
        }
    }
    public function viewDeposit($table)
    {
        if (isset($_GET['invoice_no'])) {
            $invoice_no = $_GET['invoice_no'];
            $customer_name = $_GET['customer_name'];
            $customer_address = $_GET['address'];
            $select =  $this->fetchResult("deposit", ["invoice_no=$invoice_no", "customer_name=$customer_name", "customer_address=$customer_address"]);
            $row = mysqli_fetch_array($select);
            return $row["$table"];
        }
    }
    public function addDeposit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["customer_name"] && $_POST["customer_address"])) {
                $sales_ctr = new SalesController();
                $shared = new Shared();
                $customer_name = $_POST["customer_name"];
                $normalized_name = strtolower(Form::test_input($customer_name));
                if (($normalized_name === "mr")) {
                    echo "<script>alert('Customer name is invalid! Please enter the right customer name to proceed. Thanks.');</script>";
                    return;
                }
                $customer_address = $_POST["customer_address"];
                $cash = $_POST["cash"];
                $transfer = $_POST["transfer"];
                $pos = $_POST["pos"];
                $pos_charges = $_POST["pos_charges"];
                if (empty($_POST["deposit_amount"])) {
                    echo "<script>alert('Deposit Cannot be 0! Please Enter an Amount to proceed. Thanks.');</script>";
                    return;
                }
                $deposit_amount = $_POST["deposit_amount"] - $pos_charges;

                $date = date(" d-m-Y");
                $remark = "deposit";
                $status = "pending";
                $total = 0;
                $quantity = 0;
                $price = 0;
                $amount = 0;
                $balance = 0;
                $customer_type = "Deposit";
                $old_deposit = 0;
                $staff = $shared->getFullname();
                $username = $shared->getUsername();

                // $invoice_no = $_POST["invoice_no"];
                $invoice_no = $sales_ctr->generateInvoice();
                $_SESSION["active_role"] = $shared->getRole();
                $_SESSION["invoice_no_deposit"] = $invoice_no;
                $_SESSION["cash_deposit"] = $cash;
                $_SESSION["transfer_deposit"] = $transfer;
                $_SESSION["pos_deposit"] = $pos;
                $_SESSION["pos_charges_deposit"] = $pos_charges;
                $_SESSION["deposit_amount_deposit"] = $deposit_amount;
                $pos_type = $_POST["pos_type"];



                $bill_type = $sales_ctr->determineBillType($cash, $transfer, $pos, $balance);

                $bank_name = $_POST["bank"];


                $transport = 0;

                if (!empty($_POST["transfer"]) || $_POST["transfer"] != 0) {
                    $this->insert("bank", $customer_name, $customer_address, $invoice_no, $remark, $transfer, $bank_name, $status, $staff, $date);
                }

                // foreach ($_POST as $key => $value) {
                //     if (strpos($key, 'product-name-input-') !== false) {
                //         $product_name = $value;
                //         $inputIndex = substr($key, -1);
                //         $model_input = $_POST["model-input-$inputIndex"];
                //         $manufacturer_input = $_POST["manufacturer-input-$inputIndex"];

                //         $this->insert("sales_details", $customer_name, $customer_address, $invoice_no, $remark, $product_name, $model_input, $manufacturer_input, $quantity, $price, $amount, $staff, $date);
                //         $this->insert("deposit_details", $customer_name, $customer_address, $invoice_no, $product_name, $model_input, $manufacturer_input, $date, $staff);
                //     }
                // }
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'product-name-input-') !== false) {
                        $product_name = $value;
                        $inputIndex = substr($key, -1);
                
                        $model_input = $_POST["model-input-$inputIndex"] ?? '';
                        $manufacturer_input = $_POST["manufacturer-input-$inputIndex"] ?? '';
                
                        $this->insert(
                            "sales_details",
                            $customer_name,
                            $customer_address,
                            $invoice_no,
                            $remark,
                            "Deposit for ".$product_name ?? 'Deposit Made',
                            $model_input,
                            $manufacturer_input,
                            $quantity,
                            $price,
                            $amount,
                            $staff,
                            $date
                        );
                
                        $this->insert(
                            "deposit_details",
                            $customer_name,
                            $customer_address,
                            $invoice_no,
                            $product_name ?? '',
                            $model_input,
                            $manufacturer_input,
                            $date,
                            $staff
                        );
                    }
                }
                
                $this->insert("sales", $customer_name, $customer_address, $invoice_no, $bill_type, $remark, $total, $cash, $transfer, $pos, $old_deposit, $deposit_amount, $transport, $balance, $staff, $date, $username,"");
                $check_deposit = $this->fetchResult("deposit", ["customer_name=$customer_name", "customer_address=$customer_address"]);
                if ($check_deposit->num_rows > 0) {

                    $this->updates(
                        "deposit",
                        U::col("invoice_no=$invoice_no", "cash=cash+$cash", "transfer=transfer+$transfer", "pos=pos+$pos", "deposit_amount=deposit_amount+$deposit_amount", "date=$date", "staff=$staff"),
                        U::where("customer_name=$customer_name", "customer_address=$customer_address")
                    );
                } else {
                    $this->insert("deposit", $customer_name, $customer_address, $invoice_no, $bill_type, $cash, $transfer, $pos, $deposit_amount, $date, $staff);
                }
                if (!empty($_POST["pos"]) || $_POST["pos"] != 0) {
                    $this->insert("pos", $customer_name, $customer_address, $invoice_no, $pos_type, $pos_charges);
                }
                echo "<script> window.location = '../print/deposit.php' </script>";
            } else {
                $this->customer_nameErr = "Please Enter Customer Name";
                $this->customer_addressErr = "Please Enter Customer Name";
            }
        }
    }
}
