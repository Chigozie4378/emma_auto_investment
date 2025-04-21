<?php
  class Session{
   
    public static function directorAccess($username){
      if(!isset($_SESSION["$username"])) {
        new Redirect( '../director_login.php');
      }
    }
    public static function directorLoginAccess($username){
      if(isset($_SESSION["$username"])) {
        new Redirect('director/dashboard.php');
      }
    }
    public static function name($index,$value){
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


