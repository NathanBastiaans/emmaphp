<?php

interface IController
{

    /**
     * Generates a random string using OpenSSL of pseudobytes based on the supplied length.
     * This requires openssl.
     * 
     * @param integer $length
     * @return string
     */
    function generateRandomStringWithPseudoBytes ($length = 8);
    
    /**
     * Generates a random string based on the supplied length
     * 
     * @param integer $length
     * @return string
     */
    function generateRandomString ($length = 8);

    /**
     * Applies a sha1 encryption on the supplied string
     * and returns it back to the user
     * 
     * @param string $string
     * @return string
     */
    function encrypt ($string);
    
    /**
     * A static way to call the active controller instance
     * to set a view to render for the user
     * 
     * @param string $paramView
     */
    static function initView ($paramView);

    /**
     * Returns a POST request ment for Arrays.
     * @param $paramPostName
     * @return
     */
    function postArray ($paramPostName);

    /**
     * Returns a POST request.
     * @param $paramPostName
     * @return
     */
    function post ($paramPostName);

    /**
     * Returns a GET request.
     * @param $paramGetName
     * @return
     */
    function get ($paramGetName);

    /**
     * Returns a GET request ment for Arrays.
     * @param $paramGetName
     * @return
     */
    function getArray ($paramGetName);

    /**
     * Redirects the user to the specified URL.
     * @param $url
     * @param int $status
     * @return
     */
    function redirect ($url, $status = 0);
    
    /**
     * Instructs the Loader to load the designated 404 page.
     */
    function fourOhFour ();
    
}
