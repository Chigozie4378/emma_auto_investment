<?php
session_start();

include "../autoload/loader.php";

if (isset($_GET['printed'])) {
    unset($_SESSION["invoice"], $_SESSION["customer_name"], $_SESSION["address"]);
    header("Location: ../../" . $_GET['role'] . "/retail.php");
    exit;
}

if (!isset($_SESSION["invoice"])) {
    $shared = new Shared();
    $role = $shared->getRole();
    header("Location: ../../$role/retail.php");
    exit;
}

$sales_history_ctr = new SalesHistoriesController();
$shared = new Shared();
$role = $shared->getRole();

$result_pos = mysqli_fetch_assoc($sales_history_ctr->showPos($_SESSION["customer_name"], $_SESSION["address"], $_SESSION["invoice"]));
$sales_history = $sales_history_ctr->getSales($_SESSION["invoice"]);
$sales_history_result = mysqli_fetch_assoc($sales_history);

$staff = explode(" ", $sales_history_result["staff_name"]);

if (isset($_GET['view']) && $_GET['view'] === 'html') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retail Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 72mm;
            margin: 0 auto;
            padding: 10px;
        }

        #loading-screen {
            position: fixed;
            background: rgba(255, 255, 255, 0.9);
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            #printBtn, #loading-screen {
                display: none;
            }

            @page {
                size: 72mm auto;
                margin: 0;
            }

            body, html {
                margin: 0;
                padding: 0;
            }

            .receipt {
                width: 100%;
            }

            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                font-weight: bold;
            }

            .table {
                width: 100%;
            }

            th, td {
                font-size: 10px;
            }

            .qty { width: 10%; }
            .goods { width: 55%; }
            .rate { width: 15%; }
            .amount { width: 20%; }
        }
    </style>
    <script>
        window.onload = function () {
            document.getElementById("loading-screen").style.display = "none";
            window.print();
            window.onafterprint = function () {
                window.location.href = "retail_print.php?printed=1&role=<?= $role ?>";
            };
        };
    </script>
</head>
<body>
    <div id="loading-screen">Preparing your receipt, please wait…</div>
    <button id="printBtn" onclick="window.print()">Print Again</button>

    <div class="receipt">
        <h6 style="text-align:center;">EMMA AUTO AND MULTI-SERVICES COMPANY</h6>
        <p style="text-align: center;font-size:8px;font-weight:bold;">
            Distributor for Chanlin, Shiroro...<br>
            Address: No. 37A, Opposite Jesus Life Church, Asubiaro Hospital Junction, Osogbo, Osun State.<br>
            <b>Tel: 08062063060, 08119222292, 07063684266</b>
        </p>
        <div style="text-align:center;"><span style="font-size:13px;padding: 5px;background:black;color:white;">Invoice</span></div>
        <br>
        <table>
            <tr><th>Customer Name:</th><td><?= $sales_history_result["customer_name"] ?></td></tr>
            <tr><th>Invoice No:</th><td><?= $sales_history_result["invoice_no"] ?></td></tr>
            <tr><th>Payment Type:</th><td><?= $sales_history_result["payment_type"] ?></td></tr>
            <tr><th>Date:</th><td><?= $sales_history_result["date"] ?></td></tr>
            <tr><th>Sold By:</th><td>Mr/Miss <?= $staff[1] ?></td></tr>
        </table>
        <br>
        <table class="table">
            <tr>
                <th class="qty">Qty</th>
                <th class="goods" colspan="4">Description of Goods</th>
                <th class="rate">Rate</th>
                <th class="amount">Amount</th>
            </tr>
            <?php
            $select = $sales_history_ctr->getSalesDetails($_SESSION["invoice"]);
            while ($row = mysqli_fetch_array($select)) {
                echo '<tr>
                    <td class="qty">' . $row['quantity'] . '</td>
                    <td class="goods" colspan="4">' . $row['product_name'] . ' ' . $row['model'] . ' ' . $row['manufacturer'] . '</td>
                    <td class="rate">' . $row['price'] . '</td>
                    <td class="amount">' . $row['amount'] . '</td>
                </tr>';
            }
            ?>
            <tr>
                <td colspan="5" style="text-align:right;"><b>Total Amount:</b></td>
                <td colspan="2"><?= $sales_history_result["total"] ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Cash: <?= $sales_history_result["cash"] ?></b></td>
                <td colspan="2"><b>Transfer: <?= $sales_history_result["transfer"] ?></b></td>
                <td colspan="2"><b>POS: <?= $sales_history_result["pos"] ?></b></td>
            </tr>
            <tr>
                <?php
                $total_paid = intval($sales_history_result["deposit"]) + intval($result_pos["pos_charges"]);
                if ($sales_history_result["old_deposit"] == 0): ?>
                    <td colspan="4"><b>Total Payment: <?= $total_paid ?></b></td>
                    <td colspan="4"><b>Balance: <?= $sales_history_result["balance"] ?></b></td>
                <?php else: ?>
                    <td colspan="2"><b>Old Deposit: <?= $sales_history_result["old_deposit"] ?></b></td>
                    <td colspan="2"><b>Total Payment: <?= $total_paid ?></b></td>
                    <td colspan="4"><b>Balance: <?= $sales_history_result["balance"] ?></b></td>
                <?php endif; ?>
            </tr>
        </table>
        <br>
        <span style="font-size:10px;font-weight:bold;">Customer Sign. ____________ &nbsp;&nbsp; Cashier Sign. ____________</span>
        <p style="text-align:center;font-size:10px;font-weight:bold;">You Must Be Born Again!</p>
    </div>
</body>
</html>
<?php
exit;
}
?>
