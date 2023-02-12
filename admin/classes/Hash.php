<?php
class Hash{
    public static function password($password){
        return password_hash($password,PASSWORD_DEFAULT);
    }
    public static function verify($password1,$password2){
        return password_verify($password1,$password2);
    }
    
}