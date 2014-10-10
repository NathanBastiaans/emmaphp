<?php

/**
 * Base controller of the EmmaPHP MVC Framework
 */
abstract class EmmaController implements Controller {
    
    static $model;
    static $instance;
    static $table;
    
    protected $load;
    protected $session;
    
    function __construct () {
        
        //Sanity check for session
        if ( ! isset ($_SESSION))
            session_start ();
            
        //Link controller to loader
        $_SESSION["controller"] = $_GET["c"];
        $this->load = Loader::$instance;
        self::$instance =& $this;

        //create the session object
        self::$instance->session = new Session ();

        //Method and argument back references.
        if (isset ($_GET["m"])) $this->method   = $_GET["m"];
        if (isset ($_GET["m"])) $this->arg      = $_GET["a"];
        
    }

    protected function generateSalt () {

        return sha1 (openssl_random_pseudo_bytes (100));

    }

    protected function encrypt ($string) {

        return sha1 ($string);

    }

    private function do_init_view ($param_view) {

        include("views/" . $param_view);

    }

    static function init_view ($param_view) {

        self::$instance->do_init_view($param_view);

    }

//    static function init_table () {
//
//        //Link table to controller
//        $table_name = Loader::$table_name;
//        self::$instance->$table_name = Loader::$table;
//
//    }

    protected function getPost ($param_postname) {

        return isset ($_POST[$param_postname]) ? $_POST[$param_postname] : false;

    }

    protected function getGet ($param_getname) {

        return isset ($_GET[$param_getname]) ? $_GET[$param_getname] : false;

    }

    protected function redirect ($url) {

        if (isset ($url)) {

            header ("Location: " . $url);
            exit (0);

        }

    }
    
    protected function show_404 () {
        
        $this->load->view ("fourohfour.php");
        
    }
 
    //Abstract function for controllers

   
}
