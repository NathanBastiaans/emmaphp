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
    protected function generateRandomStringWithPseudoBytes ();
    
    /**
     * Generates a random string based on the supplied length
     * 
     * @param integer $length
     * @return string
     */
    protected function generateRandomString ($length = 8);

    /**
     * Applies a sha1 encryption on the supplied string
     * and returns it back to the user
     * 
     * @param string $string
     * @return string
     */
    function encrypt ($length = 8);
    
    /**
     * Encrypts a string and returns it encrypted with SHA-1.
     * 
     * @param string $string
     */
    protected function encrypt ($string);
    
    /**
     * A static way to call the active controller instance
     * to set a view to render for the user
     * 
     * @param string $paramView
     */
    static function initView ($paramView);
    
    /**
     * Returns a POST request ment for Arrays.
     */
    protected function postArray ($paramPostName);
    
    /**
     * Returns a POST request.
     */
    protected function post ($paramPostName);
    
    /**
     * Returns a GET request.
     */
    protected function get ($paramGetName);
    
    /**
     * Returns a GET request ment for Arrays.
     */
    protected function getArray ($paramGetName);
    
    /**
     * Redirects the user to the specified URL.
     */
    protected function redirect ($url, $status = 0);
    
    /**
     * Instructs the Loader to load the designated 404 page.
     */
    public function fourOhFour ();
    
}
