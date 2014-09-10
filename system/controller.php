<?php

/**
 * Base controller of the EmmaPHP MVC Framework
 */
abstract class EmmaController {
    
    static $model;
    static $instance;
    static $table;
    
    protected $load;
    
    function __construct() {
        
        //Sanity check for session
        if( ! $_SESSION) 
            session_start();
            
        //Link controller to loader
        $_SESSION["controller"] = $_GET["c"];
        $this->load = Loader::$linkage;
        self::$instance =& $this;
        
    }
    
    static function init_model() {
        
        //Link model to controller
        $model_name = Loader::$model_name;
        self::$instance->$model_name = Loader::$model;
        
    }
    
    static function init_table() {
        
        //Link table to controller
        $table_name = Loader::$table_name;
        self::$instance->$table_name = Loader::$table;
        
    }
    
    //Abstract function for controllers
    abstract public function index();
    
    protected function show_404() {
        
        $this->load->view("fourohfour.php");
        
    }
    
}