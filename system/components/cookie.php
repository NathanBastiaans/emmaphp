<?php

/*****************
 *  ! UNTESTED ! *
 *****************/

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

    /**
     * Sets a cookie using PHP's setcookie ()
     * Defaults to expire in a week.
     * 
     * @param string 	$varName
     * @param integer 	$value
     * @param integer 	$time
     * @param string 	$secure
     * @param string 	$httpOnly
     */
    static function set ($varName, $value, $time = 604800, $secure = false, $httpOnly = false)
    {

        setcookie ($varName, $value, $time, "/", BASEPATH, $secure, $httpOnly);

    }

}
