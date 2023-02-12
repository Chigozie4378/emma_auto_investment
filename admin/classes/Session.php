<?php
  class Session{
   
    public static function adminAccess($username){
      error_reporting(E_ERROR);
      if(!isset($_SESSION["$username"])) {
        new Redirect( '../admin_login.php');
      }
    }
    public static function adminLoginAccess($username){
      error_reporting(E_ERROR);
      if(isset($_SESSION["$username"])) {
        new Redirect('admin/sales_history.php');
      }
    }
    public static function 
     Name($index,$value){
      return $_SESSION["$index"] = $value;
    }
    public static function unset($name){
        unset($_SESSION["$name"]);
        
      
    }
 
    public static function access($username){
      error_reporting(E_ERROR);
      if(!isset($_SESSION["$username"])) {
        new Redirect( 'user_login.php');
      }
    }

    public static function sessionDestroy(){
      session_destroy();
      new Redirect("../index.php");
    }

    
  }


