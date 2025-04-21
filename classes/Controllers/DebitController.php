<?php
class DebitController extends ControllerV2
{

    public function editDebit($tablename)
    {
        if (isset($_GET['customer_name']) && $_GET['customer_address']) {
            $customer_name = $_GET['customer_name'];
            $customer_address = $_GET['customer_address'];
            if ($_GET['customer_name'] && $_GET['customer_address']) {
                $row = mysqli_fetch_array($this->fetchResult("debit", ["customer_name=$customer_name", "address=$customer_address"]));
                return $row["$tablename"];
            }
        }
    }
    public function debitUpdate()
    {
        if (isset($_POST["update"])) {
            $shared = new Shared();
            $id = $_POST["id"];
            $customer_name = $_POST["customer_name"];
            $customer_address = $_POST["address"];
            $date = (!empty($_POST["date"])) ? $_POST["date"] : date("d-m-Y");
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $total = 0;
            $pay = $_POST["pay"];
            $comment = $_POST["comment"];
            $total_paid = $deposit + $pay;
            $new_balance = $balance - $pay;
            $staff = $shared->getFullname();
            $_SESSION["staff"] = $staff;
            $settled = "SETTLED";
            $username = $shared->getUsername();
            $remark = "Old Balance Payment";
            $bill_type = "Cash (Old Balance)";
            Session::name("customer_name", $customer_name);
            Session::name("customer_address", $customer_address);
            Session::name("date", $date);
            Session::name("pay", $pay);
            Session::name("new_balance", $new_balance);
            $this->updates(
                "debit_histories",
                U::col("comments = $settled"),
                U::where("total_balance = 0")
            );
            $this->updates(
                "debit",
                U::col("deposit = deposit + $pay", "balance = balance-$pay", "staff_name = $staff", "date=$date"),
                U::where("id = $id")
            );
            $this->insert("debit_histories", $customer_name, $customer_address, $total, $pay, $total_paid, $new_balance, $new_balance, $staff, $date, $comment, "");

            $this->trashWhere("debit", "balance=0");
            // $invoice_no = $_POST["invoice_no"];
            // Session::name("invoice_no", $invoice_no);

            if ($_POST["payment_type"] == "cash") {
                $sales = new SalesController();
                $invoice_no = $sales->generateInvoice();
                Session::name("invoice_no", $invoice_no);
                $transport = 0;

                $this->insert("sales", $customer_name, $customer_address, $invoice_no, $bill_type, $remark, $total, $pay, "Nill", "Nill", "Nill", $pay, $transport, $new_balance, $staff, $date, $username, "");

                $this->insert("sales_details", $customer_name, $customer_address, $invoice_no, $remark, "Old Balance Payment", "Nill", "Nill", "Nill", "Nill", $pay, $staff, $date);


                $_SESSION["active_role"] = $shared->getRole();

                echo "<script>
                    document.getElementById('update').style.display='block';
                    setTimeout(function(){
                        window.location = '../print/settle_debit.php';
                    }, 1000);
                </script>";
            } else {
                echo "<script>
                document.getElementById('update').style.display='block';
                setTimeout(function(){
                    window.location = 'settle_debit.php'
                 }, 1000);
                    </script>";
            }
        }
    }
    public function CheckRecord()
    {
        if (isset($_POST["check"])) {
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $total = $_POST["total"];
            $deposit = $_POST["deposit"];
            $balance = $_POST["balance"];
            $date = date('d-m-Y', strtotime($_POST["date"]));
            $comment = $_POST["comment"];
            Session::Name("customer_name", $customer_name);
            Session::Name("address", $address);
            Session::Name("total", $total);
            Session::Name("deposit", $deposit);
            Session::Name("balance", $balance);
            Session::Name("date", $date);
        }
    }
    public function addingFromDebitBook()
    {
        if (isset($_POST["add"])) {
            $customer_name = $_POST["customer_name"];
            $address = $_POST["address"];
            $total = $_POST["total"];
            $deposit = $_POST["deposit"];
            $deposit2 = $_POST["deposit"];
            $balance = $_POST["balance"];
            $balance2 = $_POST["balance"];
            $shared = new Shared();
            $staff = $shared->getFullname();
            $date = $_POST["date"];
            $comment = $_POST["comment"];
            $show_debits = $this->fetchResult("debit_histories", ["customer_name=$customer_name", "address=$address"], order_by: "id DESC", limit: 1);
            $row = mysqli_fetch_array($show_debits);
            $dbtotal_deposit = $row["total_paid"];
            $dbtotal_bal = $row["total_balance"];
            $total_deposit = $dbtotal_deposit + $deposit;
            $total_bal = $dbtotal_bal + $balance;
            $select1 = $this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"]);
            if (mysqli_num_rows($select1) > 0) {
                $this->updates(
                    "debit",
                    U::col("total = total + $total", "deposit = deposit + $deposit", "balance = balance + $balance"),
                    U::where("customer_name = $customer_name", "address=$address")
                );
            } else {
                $this->insert("debit", $customer_name, $address, $total, $deposit, $balance, $staff, $date);
            }
            $this->insert("debit_histories", $customer_name, $address, $total, $deposit, $total_deposit, $balance, $total_bal, $staff, $date, $comment, "");
            $this->trashWhere("debit", "balance=0");
            Session::unset("customer_name");
            Session::unset("address");
            Session::unset("total");
            Session::unset("deposit");
            Session::unset("balance");
            Session::unset("date");
            Session::unset("customer_name");
            echo "<script>
            window.location = 'debit_book.php'
            </script>";
        }
    }
}
