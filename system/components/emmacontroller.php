<?php

/**
 * Base controller of the EmmaPHP MVC Framework
 */
abstract class EmmaController implements IController {
    
    static $model;
    static $instance;
    static $table;
    
    protected $session;
    protected $method;
    protected $arg;

    public $load;

    /**
     * @see IController::constructor()
     */
    public function constructor ()
    {
            
        // Link loader to controller
        // and the controller instance to itself
        $this->load 	= Loader::$instance;
        self::$instance =& $this;

        // Method and argument back references.
        if (isset ($_GET["m"])) 
            $m = filter_var ($_GET["m"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset ($_GET["a"])) 
            $a = filter_var ($_GET["a"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset ($m)) 
            $this->method = $m;
        
        if (isset ($a)) 
            $this->arg    = $a;

        AutoLoader::getInstance ();
        
		/*
		 * Changing the working directory to "application"
		 * since we don't really need anything from the system folder.
		 */
        chdir ("application");
        
    }

    /**
     * @see IController::generateRandomStringWithPseudoBytes()
     */
    public function generateRandomStringWithPseudoBytes ($length = 8)
    {

        return substr (sha1 (openssl_random_pseudo_bytes (100)), 0, $length);

    }

    /**
     * @see IController::generateRandomString()
     */
    public function generateRandomString ($length = 8)
    {

        return substr (sha1 (mt_rand (0, 100)), 0, $length);

    }

    /**
     * @see IController::encrypt()
     */
    public function encrypt ($string)
    {

        return sha1 ($string);

    }

    /**
     * @see IController::doInitView()
     */
    private function doInitView ($paramView)
    {

        include ("views/" . $paramView);

    }

    /**
     * @see IController::initView()
     */
    static function initView ($paramView)
    {

        self::$instance->doInitView ($paramView);

    }

    /**
     * Returns a post global that's an array
     * 
     * @param string $paramPostName
     * @return Ambigous <boolean, array>
     */
    public function postArray ($paramPostName) {

        return isset ($_POST[$paramPostName]) 
            ? $_POST[$paramPostName]
        	: false;

    }

    /**
     * Returns the requested post global
     * 
     * @param string $paramPostName
     * @return Ambigous <boolean, string>
     */
    public function post ($paramPostName)
    {

        return isset ($_POST[$paramPostName]) 
            ? filter_var ($_POST[$paramPostName], FILTER_SANITIZE_FULL_SPECIAL_CHARS) 
            : false;

    }

    /**
     * Returns the request get global
     * 
     * @param string $paramGetName
     * @return Ambigous <boolean, string>
     */
    public function get ($paramGetName)
    {

        return isset ($_GET[$paramGetName]) 
            ? filter_var ($_GET[$paramGetName], FILTER_SANITIZE_FULL_SPECIAL_CHARS) 
            : false;

    }

    /**
     * Returns a get global that's an array
     * 
     * @param string $paramGetName
     * @return Ambigous <boolean, array>
     */
    public function getArray ($paramGetName)
    {

        return isset ($_GET[$paramGetName]) 
            ? $_GET[$paramGetName]
            : false;

    }

    /**
     * Redirects the user to an URL
     * 
     * @param string $url
     * @param integer $status
     */
    public function redirect ($url, $status = 0)
    {

        if (isset ($url))
        {
            
            if ( $status != 0 ) {
                
                switch ( $status ) {
                    
                    case 301: 
                        header('HTTP/1.1 301 Moved Permanently');
                        break;
                        
                    case 307:
                        header('HTTP/1.1 307 Temporary Redirect');
                        break;
                        
                    case 401:
                        header('HTTP/1.1 401 Unauthorized');
                        break;
                    
                    case 403:
                        header('HTTP/1.1 403 Forbidden');
                        break;
                        
                    case 404: 
                        header('HTTP/1.1 404 Not Found');
                        break;
                        
                    default:
                        header('HTTP/1.1 307 Temporary Redirect');
                        break;
                }
                
            }

            header ("Location: " . $url);
            exit (0);

        }

    }

    /**
     * Renders the customizable 404 page
     */
    public function fourOhFour ()
    {
        
        $this->load->view ("fourohfour.php");
        
    }
   
}
