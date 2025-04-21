<?php
class SalesHistoriesController extends ControllerV2
{
    private $saleCache;
    // Get all sales records by date
    public function get50Sales()
    {
        $date = date("d-m-Y");
        $sales = $this->fetchResult("sales", where: ["date = $date"], oper: ["LIKE"], order_by: "id DESC", limit: 50);
        return $sales;
    }
    public function getStaff50Sales()
    {
        $date = date("d-m-Y");
        $shared = new Shared();
        $username = $shared->getUsername();
        $sales = $this->fetchResult("sales", where: ["date = $date","username=$username"], oper: ["LIKE"], order_by: "id DESC", limit: 50);
        return $sales;
    }
    public function getTodaySales()
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: ["date = $date"],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }
    public function getStaffTodaySales($username )
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: ["date = $date","username=$username"],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }

    public function getTodayTotals()
    {
        $date = date("d-m-Y");
        $totals = $this->fetchResult(
            "sales",
            cols: "SUM(total) AS sumTotal, SUM(deposit) AS credit, SUM(balance) AS balance, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS sumPos",
            where: ["date = $date"],
            oper: ["LIKE"],
        );

        return mysqli_fetch_assoc($totals);
    }

    public function getSalesRecordStats($date)
    {
        
        $totals = $this->fetchResult(
            "sales",
            cols: "SUM(total) AS total, SUM(deposit) AS credit, SUM(balance) AS balance, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS pos",
            where: ["date = $date"],
            oper: ["LIKE"],
        );

        return mysqli_fetch_assoc($totals);
    }
    public function getInvoiceSalesRecordStats($invoice_no)
    {
        
        $totals = $this->fetchResult(
            "sales",
            cols: "SUM(total) AS total, SUM(deposit) AS credit, SUM(balance) AS balance, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS pos",
            where: ["invoice_no = $invoice_no"],
            oper: ["LIKE"],
        );

        return mysqli_fetch_assoc($totals);
    }
    public function getStaffSalesRecordStats($date,$staff)
    {
        
        $totals = $this->fetchResult(
            "sales",
            cols: "SUM(total) AS total, SUM(deposit) AS credit, SUM(balance) AS balance, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS pos",
            where: ["date = $date","staff_name = $staff"],
            oper: ["LIKE","LIKE"],
        );

        return mysqli_fetch_assoc($totals);
    }
    public function getSalesRecordsByDate($date){
        return $this->fetchResult(
            "sales",
            where: ["date = $date"],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }
    public function getSalesRecordsByInvoice($invoice_no){
        return $this->fetchResult(
            "sales",
            where: ["invoice_no = $invoice_no"],
            oper: ["LIKE"],
            order_by: "id DESC"
        );
    }
    public function getSalesRecordsByStaff($date,$staff){
        return $this->fetchResult(
            "sales",
            where: ["date = $date","staff_name = $staff"],
            oper: ["LIKE","LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByCustomerName($name)
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: [
                "customer_name=$name",
                "date = $date"
            ],
            oper: ["LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByCustomerAddress($name, $address)
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: [
                "customer_name=$name",
                "address= $address",
                "date = $date"
            ],
            oper: ["LIKE", "LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }
    public function searchByCustomerNameStaff($name,$username)
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: [
                "customer_name=$name",
                "date = $date",
                "username=$username"
            ],
            oper: ["LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByCustomerAddressStaff($name, $address,$username)
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: [
                "customer_name=$name",
                "address= $address",
                "date = $date",
                "username=$username"
            ],
            oper: ["LIKE", "LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }

    public function searchByStaffName($staffname)
    {
        $date = date("d-m-Y");
        return $this->fetchResult(
            "sales",
            where: [
                "staff_name=$staffname",
                "date = $date"
            ],
            oper: ["LIKE", "LIKE"],
            order_by: "id DESC"
        );
    }

    public function getTotalsByStaffName($staffname)
    {
        $date = date("d-m-Y");
        $totals = $this->fetchResult(
            "sales",
            cols: "SUM(total) AS sumTotal, SUM(deposit) AS credit, SUM(balance) AS balance, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS sumPos",
            where: ["staff_name = $staffname", "date = $date"],
            oper: ["LIKE", "LIKE"],
        );

        return mysqli_fetch_assoc($totals);
    }

    public function getSaleCache()
    {
        if (!isset($this->saleCache)) {
            $invoice_no = $_GET['invoice_no'] ?? '';
            $customer_name = $_GET['customer_name'] ?? '';
            $address = $_GET['address'] ?? '';
            $result = $this->fetchResult("sales", where: ["invoice_no = $invoice_no", "customer_name = $customer_name", "address = $address"], limit: 1);
            $this->saleCache = mysqli_fetch_assoc($result);
        }
        return $this->saleCache;
    }
    public function showSalesDetails()
    {
        if (isset($_GET['invoice_no'])) {
            $invoice_no = $_GET['invoice_no'] ?? '';
            $customer_name = $_GET['customer_name'] ?? '';
            $address = $_GET['address'] ?? '';
            return $this->fetchResult("sales_details", where: ["invoice_no = $invoice_no", "customer_name = $customer_name", "address = $address"]);
        }
        
    }

    public function showSales($column)
    {
        $row = $this->getSaleCache();
        return $row[$column] ?? '';
    }

    public function showPosType($tablename)
    {
        if (isset($_GET['invoice_no'])) {
            $invoice_no = $_GET['invoice_no'];
            $customer_name = $_GET['customer_name'];
            $address = $_GET['address'];
            if ($_GET['invoice_no']) {
                $row = mysqli_fetch_assoc($this->fetchResult("pos", ["customer_name=$customer_name", "customer_address=$address", "invoice_no=$invoice_no"]));
                return $row["$tablename"];
            }
        }
    }
    public function supplyCheck($tablename)
    {
        if (isset($_GET['invoice_no'])) {
            $invoice_no = $_GET['invoice_no'];
            $customer_name = $_GET['customer_name'];
            $customer_address = $_GET['customer_address'];
            if ($_GET['invoice_no']) {
                $row = $this->fetchResult("supply_check", ["invoice_no=$invoice_no", "customer_name=$customer_name", "customer_address=$customer_address"])->fetch_assoc();
                // $row = mysqli_fetch_array($this->showSupplyCheck($invoice, $customer_name, $address));
                return $row["$tablename"];
            }
        }
    }
    public function getSales($invoice_no){
        return $result = $this->fetchResult("sales", where: ["invoice_no = $invoice_no"], limit: 1);
        
    }
    public function getSalesDetails($invoice_no){
        return  $this->fetchResult("sales_details", where: ["invoice_no = $invoice_no"]);
        
    }
    public function showPos($customer_name, $address,$invoice_no){
        return $this->fetchResult("pos", ["customer_name=$customer_name", "customer_address=$address", "invoice_no=$invoice_no"]);
    }
    public function showPosByInvoice_no($invoice_no){
        return $this->fetchResult("pos", ["invoice_no=$invoice_no"]);
    }
    
    public function showUserSupply(){
        return $this->fetchResult("registered",["role=others"]);
    }
    public function showBank()
    {
        return $this->fetchResult("bank",order_by:"id DESC");
    }
    public function paginateTransfer()
    {
        // Get total records from your method
        $count = mysqli_fetch_assoc($this->fetchResult("bank", cols: "COUNT(*) AS total_count",order_by:"id DESC"));
        $totalRecords = (int)$count['total_count'];
        $pagination = new Pagination($totalRecords, 100, "confirm_transfer.php");

        // Fetch paginated result
        return [
            'results' => $this->fetchResult("bank", limit: $pagination->limit, offset: $pagination->offset),
            'pagination' => $pagination->render()
        ];
    }
}
