<?php

/**
 * Base controller of the EmmaPHP MVC Framework
 */
abstract class EmmaController {
    
    static $model;
    static $instance;
    static $table;
    
    protected $load;
    
    function __construct () {
        
        //Sanity check for session
        if ( ! isset ($_SESSION))
            session_start ();
            
        //Link controller to loader
        $_SESSION["controller"] = $_GET["c"];
        $this->load = Loader::$linkage;
        self::$instance =& $this;
        
    }

    static function init_model () {

        //Link model to controller
        $model_name = Loader::$model_name;
        self::$instance->$model_name = Loader::$model;

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

	protected function getSession ($param_session_name) {

        return isset ($_SESSION[$param_session_name]) ? $_SESSION[ (String) $param_session_name] : false;

    }

    protected function setSession ($param_session_name, $value) {

        $_SESSION[ (String) $param_session_name] = $value;

    }

    protected function redirect ($url) {

        if (isset ($url)) {

            header ("Location: " . BASEPATH . "/" . $url);
            exit (0);

        }

    }
    
    //Abstract function for controllers
    abstract public function index ();
    
    protected function show_404 () {
        
        $this->load->view ("fourohfour.php");
        
    }
    
}
