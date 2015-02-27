<?php

/**
 * Base controller of the EmmaPHP MVC Framework
 */
abstract class EmmaController implements IController {
    
    static $model;
    static $instance;
    static $table;
    
    public $load;

    protected $session;
    protected $method;
    protected $arg;

    public function constructor ()
    {
        
        //Sanity check for session
        if ( ! isset ($_SESSION))
            session_start ();
            
        // Link loader to controller
        // and the controller instance to itself
        $_SESSION["controller"] = $_GET["c"];
        $this->load = Loader::$instance;
        self::$instance =& $this;

        //create the session object [OBSOLETE]
//         self::$instance->session = new Session ();

        //Method and argument back references.
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

    protected function generateRandomStringWithPseudoBytes ($length)
    {

        return substr (sha1 (openssl_random_pseudo_bytes (100)), 0, $length);

    }

    protected function generateRandomString ($length)
    {

        return substr (sha1 (mt_rand (0, 100)), 0, $length);

    }

    protected function encrypt ($string)
    {

        return sha1 ($string);

    }

    private function doInitView ($paramView)
    {

        include ("views/" . $paramView);

    }

    static function initView ($paramView)
    {

        self::$instance->doInitView ($paramView);

    }

    protected function postArray ($paramPostName) {

        return isset ($_POST[$paramPostName]) 
            ? $_POST[$paramPostName]
        : false;

    }

    protected function post ($paramPostName)
    {

        return isset ($_POST[$paramPostName]) 
            ? filter_var ($_POST[$paramPostName], FILTER_SANITIZE_FULL_SPECIAL_CHARS) 
            : false;

    }

    protected function get ($paramGetName)
    {

        return isset ($_GET[$paramGetName]) 
            ? filter_var ($_GET[$paramGetName], FILTER_SANITIZE_FULL_SPECIAL_CHARS) 
            : false;

    }
    
    protected function getArray ($paramGetName)
    {

        return isset ($_GET[$paramGetName]) 
            ? $_GET[$paramGetName]
            : false;

    }

    protected function redirect ($url, $status = 0)
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
    
    protected function fourOhFour ()
    {
        
        $this->load->view ("fourohfour.php");
        
    }
   
}
