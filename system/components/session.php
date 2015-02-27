<?php

class Session
{
    
    static function getAndNullify ($varName)
    {
        
        $val = self::get ($varName);
        self::nullify ($varName);
        return $val;
        
    }

    static function get ($varName)
    {

        return isset ($_SESSION[$varName]) 
        	? $_SESSION[$varName] 
        	: false;

    }

    static function set ($varName, $value)
    {

        $_SESSION[$varName] = $value;

    }

    static function nullify ($varName)
    {

        $_SESSION[$varName] = null;

    }
    
}
