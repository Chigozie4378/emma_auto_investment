
<?php
include "../autoload/loader.php";

require_once __DIR__ . '/vendor/autoload.php';
$deposit_ctr = new DepositController();
$sales_history_ctr = new SalesHistoriesController();

$result = $deposit_ctr->checkDepositByInvoiceNo($_GET["invoice_no"]);
$staff = explode(" ", $result["staff"]);
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
                /* sheet-size: 300px 250mm; important to set paper size */
                
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
                <td>' . $result["customer_name"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Customer Address: </th>
                <td>' . $result["customer_address"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Invoice No: </th>
                <td>' . $result["invoice_no"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Payment Type: </th>
                <td>' . $result["payment_type"] . '</td>
            </tr>
            <tr>
                <th style="text-align: left;">Date: </th>
                <td>' . $result["date"] . '</td>
            </tr>
            <tr>
            <th style="text-align: left;">Sold By: </th>
            <td>Mr/Miss ' . $staff[1] . '</td>
        </tr>
        </table>
        <br/>
        <table class="table">
            <tr>
                
                <th class="goods" colspan="7">Description of Goods</th>
            </tr>';

$select_pos = $sales_history_ctr->showPosByInvoice_no($_GET["invoice_no"]);
$result_pos = mysqli_fetch_assoc($select_pos);

$select = $deposit_ctr->checkDepositDetailsByInvoiceNo($_GET['invoice_no']);
while ($row = mysqli_fetch_assoc($select)) {


    $html .=

        '<tr>
                <td class="goods"  colspan="7">Deposit Made ' . $row['product_name'] . " " . $row['model'] . " " . $row['manufacturer'] . '</td>
            </tr>';
}
$html .= '
            <tr>
            <td colspan="2" style="text-align: left;"><b>Cash: ' . $result["cash"] . '</b></td>
            <td colspan="2" style="text-align: left;"><b>Transfer: ' . $result["transfer"] . '</b></td>
            <td colspan="2" style="text-align: left;"><b>POS: ' . $result["pos"] . '</b></td>
            <td style="text-align: left;"><b>POS Charges: ' . $result_pos["pos_charges"] . '</b></td>
            
        </tr>
        <tr>';
$html .= '
                <td colspan ="4"></td>
                <td colspan="4" style="text-align: left;"><b>Amount Deposited: #' . intval($result["deposit_amount"]) + intval($result_pos["pos_charges"]) . '</b></td>';

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



?>