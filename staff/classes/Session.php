<?php
  class Session{
   
    public static function staffAccess($username){
      if(!isset($_SESSION["$username"])) {
        new Redirect( '../index.php');
      }
    }
    public static function staffLoginAccess($username){
      if(isset($_SESSION["$username"])) {
        new Redirect('staff/dashboard.php');
      }
    }
    public static function sessionName($index,$value){
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