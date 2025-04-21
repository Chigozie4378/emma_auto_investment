
<?php
include "../autoload/loader.php";


// Simple fallback if session is not ready
if (empty($_SESSION["invoice_no"]) || empty($_SESSION["active_role"])) {
    unset($_SESSION["active_role"]);

    $redirectTo = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "../index.php";
    header("Location: $redirectTo");
    exit();
}
require_once __DIR__ . '/vendor/autoload.php';

$sales_history_ctr = new SalesHistoriesController();
$staff = explode(" ",    $_SESSION["staff"]);
include "includes/header.php";
$html = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../assets/images/logo.jpg" type="image/gif" sizes="20x20">
        <title>EMMA AUTO AND MULTI-SERVICES COMPANY</title>
        <style>
        @media print {
            @page {
                margin: 0 auto; /* imprtant to logo margin */
                /* sheet-size: 300px 250mm; imprtant to set paper size */
                
            }
            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                font-weight:bold;
            }
    
            table {
                border-collapse: collapse;
                
            }
    
            .table {
                width: 100%;
                font-weight:bold;
            }
            .table2{
                border-collapse: collapse;
                
            }
            th,td{
                font-size:10px;
                border-collapse: collapse;
            }
            .qty{
                width: 10%;
            }
            .goods{
                width: 55%;
            }
            .rate{
                width: 15%;
            }
            .amount{
                width: 20%;
            }
        }
    
        </style>
    </head>
    
    <body>
        <h6 style="text-align: center;">EMMA AUTO AND MULTI-SERVICES COMPANY</h6>
        <p style="text-align: center;font-size:8px;font-weight:bold;">Distributor for Chanlin, Shiroro, Unigo, Jeely, Jieng, Endurance, Tako, Donaten, Sinosat, Sunrain Motorcycle spare parts of all brands of Motorcycles and Tricycle parts all Genuine parts, such as Honda, Bajaj, TVS, Hero and all brands of Motorcycles Engine and Tricycles.  <br>
        <span>Address: No. 37A, Opposite Jesus Life Church, Asubiaro Hospital Junction, Osogbo, Osun State.</span></br>
        <b>Tel: 08062063060, 08119222292, 07063684266</b> </p>
        <div style="text-align:center;border-radius: 50%;"><span
                style="font-size:13px;border: 1px solid;text-align:center; padding: 5px;background-color:rgb(0, 0, 0); color: white;">Invoice</span>
        </div>
        <br>
        <table style="text-align: left;">
            <tr>
                <th style="text-align: left;">Customer Name: </th>
                <td>' . $_SESSION["customer_name"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Customer Address: </th>
                <td>' . $_SESSION["customer_address"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Invoice No.: </th>
                <td>' . $_SESSION["invoice_no"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Customer Address: </th>
                <td>' . $_SESSION["customer_address"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Date: </th>
                <td>' . $_SESSION["date"] . '</td>
            </tr>
            <tr>
            <th style="text-align: left;">Sold By: </th>
            <td>Mr/Miss ' . $staff[1] . '</td>
        </tr>
        </table>
        <br/>
        <table class="table">
            <tr>
                
                <th  colspan="8">Description of Goods</th>
            </tr>
            <tr>
                <td  colspan="8">Old Balance Payment</td>
            </tr>
            
        <tr>';
$html .= '
                <td colspan="4" style="text-align: left;"><b>Paid: # ' . $_SESSION["pay"] . '</b></td>
                <td colspan="4" style="text-align: left;"><b>Remaining Balance: # ' . $_SESSION["new_balance"] . '</b></td>';

$html .= '
        
        </tr>
        </table>
        <br/>
        <span style="font-size:10px;font-weight:bold;">Customer Sign. ____________&nbsp;&nbsp;Cashier Sign. ____________ </span>
        <p style="text-align:center;font-size:10px;font-weight:bold;">You Must Be Born Again!</p>
        
    </body>
    
    </html>';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [72, 234]]);
$mpdf->showImageErrors = false;
$mpdf->WriteHTML($html);
$mpdf->Output();
$_SESSION["last_invoice_url"] = $_SERVER['REQUEST_URI'];
unset($_SESSION["invoice_no"]);
Session::unset("customer_name");
Session::unset("customer_address");
Session::unset("date");
Session::unset("pay");
Session::unset("new_balance");
Session::unset("staff");



?>