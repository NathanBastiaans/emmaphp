<?php

class Cookie
{

    /**
     * 
     * @param string $varName
     * @return Ambigous <boolean, string>
     */
    static function get ($varName)
    {

        return isset ($_COOKIE[$varName]) 
            ? $_COOKIE[$varName] 
            : false;

    }
    
    static function getDefaultHttps ()
    {
        
        return ( ! empty ( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) || $_SERVER['SERVER_PORT'] == 443;
        
    }

    /**
     * Sets a cookie using PHP's setcookie ()
     * Defaults to expire in a week.
     * 
     * @param string  $varName
     * @param integer $value
     * @param integer $time
     * @param bool  $secure
     * @param bool  $httpOnly
     */
    static function set ($varName, $value, $time = 604800, $secure = false, $httpOnly )
    {

		if ( empty ( $httpOnly ) )
			$httpOnly = self::getDefaultHttps ();
	
        setcookie ($varName, $value, $time, "/", BASEPATH, $secure, $httpOnly);

    }

}
