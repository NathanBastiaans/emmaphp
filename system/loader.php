<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader implements SystemComponent {
    
    static $instance;
    static $model;
    static $model_name;
    static $table;
    static $table_name;
    static $controller;
    
    function __construct () {
        
        //Make a link to the loader object.
        self::$instance =& $this;
        
    }
    
    public function controller ($param_controller) {
        
        //create given controller object
        $controller = new $param_controller ();

        /*
         * Check for a supplied method with the GET
         * If set we check if it's public and execute it if not
         * we throw an error
         */
        if (isset ($_GET["m"]))
            if ( ! method_exists ($controller, $_GET["m"]))
                die ("Couldn't find method: " . $_GET["m"]
                    . " <br/>In controller: " . $_GET["c"] . " :(");
            else {
                $reflection = new ReflectionMethod ($controller, $_GET["m"]);
                if ( ! $reflection->isPublic ())
                    die("Method: " . $_GET["m"] . " from"
                        . " Controller: " . $_GET["c"]
                        . " is not a public method.");
                else if (isset ($_GET["a"])) {
                    
                    //Check if arguments should be supplied
                    $args = $_GET["a"];
                    $controller->$_GET["m"] ($args);
                    
                } else
                    $controller->$_GET["m"] ();
            }
        else
            /* 
             * If the index method exists 
             * within the controller, we run it.
             */
            if( method_exists ($controller, "index"))
                    $controller->index ();

        self::$controller =& $controller;
        
    }
    
    public function model ($param_model) {
        
        //Find, include and make the model ready.
        $model_file_name = str_replace ("Model", "", $param_model);
        require_once ("models/" . strtolower ($model_file_name) . ".php");
        $actual_model = ucfirst ($param_model);
        
        //Create the model object
        $this->$param_model = new $actual_model ();
        
        //Link the model to the loader to load and initialize it.
        self::$model_name = $actual_model;
        self::$model =& $this->$actual_model;

        //Load and initialize it into the controller as an object
        $model_name = self::$model_name;
        EmmaController::$instance->$model_name = self::$model;

    }
    
//    public function table ($param_table) {
//
//        $table_file_name = strtolower ($param_table) . ".php";
//        $table_name_actual = ucfirst ($param_table) . "Table";
//        require_once ("tables/" . $table_file_name);
//
//        $this->param_table = new $table_name_actual ();
//
//        self::$table =& $this->param_table;
//        self::$table_name =& $table_name_actual;
//        EmmaController::init_table ();
//
//    }
    
    public function view ($param_view) {
        
        //Load a view
        EmmaController::$instance->init_view ($param_view);
        
    }

}
