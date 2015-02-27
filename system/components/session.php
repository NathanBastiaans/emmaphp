<?php

class Session
{
    
    static function getAndNullify ($var_name)
    {
        
        $val = self::get ($var_name);
        self::nullify ($var_name);
        return $val;
        
    }

    static function get ($var_name)
    {

        return isset ($_SESSION[$var_name]) 
        	? $_SESSION[$var_name] 
        	: false;

    }

    static function set ($var_name, $value)
    {

        $_SESSION[$var_name] = $value;

    }

    static function nullify ($var_name)
    {

        $_SESSION[$var_name] = null;

    }
    
}
