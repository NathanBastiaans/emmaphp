<?php

interface IController
{

	/**
	 * Abstract constructor for controllers.
	 */
    function constructor ();
    
    /**
     * Generates a random string using OpenSSL's technology.
     */
    protected function generateRandomStringWithPseudoBytes ();
    
    /**
     * Generates a random string.
     */
    function generateRandomString ();

    /**
     * Accepts a string and returns it encrypted.
     */
    function encrypt ();
    
    /**
     * Includes a view to render it to the user.
     */
    function doInitView ();
    
    /**
     * Instructs the currently loaded controller to
     * use doInitView () to render a view.
     */
    function initView ();
    
    /**
     * Returns a POST request ment for Arrays.
     */
    function postArray ();
    
    /**
     * Returns a POST request.
     */
    function post ();
    
    /**
     * Returns a GET request.
     */
    function get ();
    
    /**
     * Returns a GET request ment for Arrays.
     */
    function getArray ();
    
    /**
     * Redirects the user to the specified URL.
     */
    function redirect ();
    
    /**
     * Instructs the Loader to load the designated 404 page.
     */
    function fourOhFour ();
    
}
