<?php
  class Redirect{
  
   public function __construct($dir){
    header("location: $dir");
    
   }
  }