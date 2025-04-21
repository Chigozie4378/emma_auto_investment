<?php

class DashboardController extends ControllerV2
{


    public function getDashboardStats()
    {
        $date = date("d-m-Y");

        $stats = $this->fetchResult(
            "sales",
            cols: "COUNT(customer_name) AS countcustomers, SUM(total) AS sumTotal, SUM(deposit) AS credit, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS sumPos, SUM(balance) AS balance",
            where: ["date=$date"], oper: ["LIKE"]

        ); 
        return mysqli_fetch_assoc($stats);
    }

    public function getStaffDashboardStats()
    {
        $date = date("d-m-Y");
        $shared = new Shared();
        $username = $shared->getUsername();

        $stats = $this->fetchResult(
            "sales",
            cols: "COUNT(customer_name) AS countcustomers, SUM(total) AS sumTotal, SUM(deposit) AS credit, SUM(cash) AS cash, SUM(transfer) AS transfer, SUM(pos) AS sumPos, SUM(balance) AS balance",
            where: ["date=$date","username=$username"], oper: ["LIKE"]

        ); 
        return mysqli_fetch_assoc($stats);
    }
}
