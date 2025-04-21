<?php
error_reporting(E_ERROR);

  function myAutoload($name){
    if (file_exists("../classes/".$name.".php")) {
      require_once "../classes/".$name.".php";
    }elseif (file_exists("classes/".$name.".php")) {
      require_once "classes/".$name.".php";
    }elseif (file_exists("director/classes/".$name.".php")) {
      require_once "director/classes/".$name.".php";
    }elseif (file_exists("../../director/classes/".$name.".php")) {
      require_once "../../director/classes/".$name.".php";
    }

  }
  spl_autoload_register('myAutoload');
