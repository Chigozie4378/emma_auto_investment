<?php
class DebitHistoriesController extends ControllerV2
{
    private $debitCache;

    public function allDebit(){
        $result = $this->fetchResult("debit", order_by:"customer_name ASC");
        return $result;

    }
    public function getDebitCache()
    {
        if (!isset($this->debitCache)) {
            $customer_name = $_GET['customer_name'] ?? '';
            $address = $_GET['address'] ?? '';
            $result = $this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"]);
            $this->debitCache = mysqli_fetch_assoc($result);
        }
        return $this->debitCache;
    }
    public function showDebit($column)
    {
        $row = $this->getDebitCache();
        return $row[$column] ?? '';
    }
    public function countDebit()
    {
            $customer_name = $_GET['customer_name'] ?? '';
            $address = $_GET['address'] ?? '';
            $result = $this->fetchResult("debit", ["customer_name=$customer_name", "address=$address"], order_by:"customer_name ASC");
            return mysqli_num_rows($result);
       
    }
    public function filterName($name){
        return $this->fetchResult("debit",["customer_name=$name"],oper:["LIKE"]);
    }
    public function filterAddress($name,$address){
        return $this->fetchResult("debit",["customer_name=$name","address=$address"],oper:["LIKE","LIKE"], order_by:"customer_name ASC");
    }
    public function filterDate($date,$name,$address){
        return $this->fetchResult("debit",["customer_name=$name","address=$address","date=$date"],oper:["LIKE","LIKE","LIKE"], order_by:"customer_name ASC");
    }

    public function viewDebit()
    {
        if (isset($_GET["customer_name"]) && $_GET["address"]) {
            $customer_name = $_GET["customer_name"];
            $customer_address = $_GET["address"];
            return  $this->fetchResult("debit_histories",["customer_name=$customer_name", "address=$customer_address"]);
            
        }
    }
    public function showDebitHistory(){
        $result = $this->fetchResult(
            "debit_histories",
            where: ["id=SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address"],
            oper: ["IN"],order_by:"customer_name ASC"
          );
          

        return $result;
    }
    public function showDebitHistoryName($customer_name){
        $result = $this->fetchResult(
            "debit_histories",
            where: ["id=SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address","customer_name=$customer_name"],
            oper: ["IN","LIKE"],order_by:"customer_name ASC"
          );
          

        return $result;
    }
    public function showDebitHistoryAddress($customer_name,$customer_address){
        $result = $this->fetchResult(
            "debit_histories",
            where: ["id=SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address","customer_name=$customer_name","address=$customer_address"],
            oper: ["IN","LIKE","LIKE"],order_by:"customer_name ASC"
          );
          

        return $result;
    }
    public function showDebitHistoryDate($customer_name,$customer_address,$date){
        $result = $this->fetchResult(
            "debit_histories",
            where: ["id=SELECT MAX(id) FROM debit_histories GROUP BY customer_name, address","customer_name=$customer_name","address=$customer_address","date=$date"],
            oper: ["IN","LIKE","LIKE","LIKE"],order_by:"customer_name ASC"
          );
          

        return $result;
    }
    public function checkDebit($customer_name,$address){
        return $this->fetchResult("debit",["customer_name=$customer_name","address=$address"]);
    }
}
