<?php
    class ReturnGoodsHistoriesController extends ControllerV2{
        public function paginateReturnAllGoods()
        {
            // Get total records from your method
            $count = mysqli_fetch_assoc($this->fetchResult("return_goods", cols: "COUNT(*) AS total_count"));
            $totalRecords = (int)$count['total_count'];
            $pagination = new Pagination($totalRecords, 50, "return_goods.php");
    
            // Fetch paginated result
            return [
                'results' => $this->fetchResult("return_goods", limit: $pagination->limit, offset: $pagination->offset),
                'pagination' => $pagination->render()
            ];
        }
        public function paginateReturnEachGoods()
        {
            // Get total records from your method
            $count = mysqli_fetch_assoc($this->fetchResult("return_each_goods", cols: "COUNT(*) AS total_count"));
            $totalRecords = (int)$count['total_count'];
            $pagination = new Pagination($totalRecords, 50, "return_each_goods.php");
    
            // Fetch paginated result
            return [
                'results' => $this->fetchResult("return_each_goods", limit: $pagination->limit, offset: $pagination->offset),
                'pagination' => $pagination->render()
            ];
        }
        public function searchByCustomerName($name)
        {
           
            return $this->fetchResult(
                "return_goods",
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
                "return_goods",
                where: [
                    "customer_name=$name",
                    "address= $address"
                ],
                oper: ["LIKE", "LIKE"],
                order_by: "id DESC"
            );
        }
    
        public function searchByInvoice($invoice_no)
        {
            
            return $this->fetchResult(
                "return_goods",
                where: [
                    "invoice_no=$invoice_no"
                ],
                oper: ["LIKE"],
                order_by: "id DESC"
            );
        }
        public function searchEachByCustomerName($name)
        {
           
            return $this->fetchResult(
                "return_each_goods",
                where: [
                    "customer_name=$name"
                ],
                oper: ["LIKE"],
                order_by: "id DESC"
            );
        }
    
        public function searchEachByCustomerAddress($name, $address)
        {
            
            return $this->fetchResult(
                "return_each_goods",
                where: [
                    "customer_name=$name",
                    "address= $address"
                ],
                oper: ["LIKE", "LIKE"],
                order_by: "id DESC"
            );
        }
    
        public function searchEachByInvoice($invoice_no)
        {
            
            return $this->fetchResult(
                "return_each_goods",
                where: [
                    "invoice_no=$invoice_no"
                ],
                oper: ["LIKE"],
                order_by: "id DESC"
            );
        }
        public function viewReturnGoodsDetails()
        {
            if (isset($_GET['invoice_no'])) {
                $invoice_no = $_GET['invoice_no'];
                return $this->fetchResult("return_goods_details",["invoice_no=$invoice_no"]);
            }
        }
        public function viewReturnGoods($table)
        {
            if (isset($_GET['invoice_no'])) {
                $invoice_no = $_GET['invoice_no'];
                $select =  $this->fetchResult("return_goods",["invoice_no=$invoice_no"]);
                $row = mysqli_fetch_array($select);
                return $row["$table"];
            }
        }
        public function viewEachReturnGoods($table)
        {
            if (isset($_GET['invoice_no'])) {
                $invoice_no = $_GET['invoice_no'];
                $select =  $this->fetchResult("return_each_goods",["invoice_no=$invoice_no"]);
                $row = mysqli_fetch_array($select);
                return $row["$table"];
            }
        }
    }
?>