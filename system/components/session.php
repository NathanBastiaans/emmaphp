<?php

class Session
{

    /**
     * @param $varName
     * @return bool
     */
    static function getAndNullify ($varName)
    {
        
        $val = self::get ($varName);
        self::nullify ($varName);
        return $val;
        
    }

    /**
     * @param $varName
     * @return bool
     */
    static function get ($varName)
    {

        return isset ($_SESSION[$varName]) 
        	? $_SESSION[$varName] 
        	: false;

    }

    /**
     * @param $varName
     * @param $value
     */
    static function set ($varName, $value)
    {

        $_SESSION[$varName] = $value;

    }
    
    /**
     * @param $key
     * @param $value
     */
	static function push ( $key, $value )
	{
		
		array_push ( $_SESSION [$key], $value );
		
	}

    /**
     * @param $varName
     */
    static function nullify ($varName)
    {

        $_SESSION[$varName] = null;

    }
    
}
