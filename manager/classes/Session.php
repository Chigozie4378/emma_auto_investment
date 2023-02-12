<?php
  class Session{
   
    public static function managerAccess($username){
      if(!isset($_SESSION["$username"])) {
        new Redirect( '../manager_login.php');
      }
    }
    public static function managerLoginAccess($username){
      if(isset($_SESSION["$username"])) {
        new Redirect('manager/dashboard.php');
      }
    }
    public static function Name($index,$value){
      return $_SESSION["$index"] = $value;
    }
    public static function unset($name){
        unset($_SESSION["$name"]);
        
      
    }
 
    public static function access($username){
      if(!isset($_SESSION["$username"])) {
        new Redirect( 'user_login.php');
      }
    }

    public static function sessionDestroy(){
      session_destroy();
      new Redirect("../index.php");
    }

    
  }


