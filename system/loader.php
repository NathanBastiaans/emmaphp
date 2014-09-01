<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader {
    
    static $linkage;
    static $model;
    static $model_name;
    
    function __construct() {
        
        //Make a link to the loader object.
        self::$linkage =& $this;
        
    }
    
    public function controller($param_controller) {
        
        //create given controller object
        $controller = new $param_controller();

        /*
         * Check for a supplied method with the GET
         * If set we check if it's public and execute it if not
         * we throw an error
         */
        if(isset($_GET["m"])) 
            if(!method_exists($controller, $_GET["m"]))
                die("Couldn't find method: " . $_GET["m"]
                    . " <br/>In controller: " . $_GET["c"] . " :(");
            else {
                $reflection = new ReflectionMethod($controller, $_GET["m"]);
                if(!$reflection->isPublic())
                    die("Method: " . $_GET["m"] . " from"
                        . " Controller: " . $_GET["c"]
                        . " is not a public method.");
                else if(isset($_GET["a"])) {
                    
                    //Check if arguments should be supplied
                    $args = $_GET["a"];
                    $controller->$_GET["m"]($args);
                    
                } else
                    $controller->$_GET["m"]();
            }
        else
            /* 
             * If the index method exists 
             * within the controller, we run it.
             */
            if(method_exists($controller, "index"))
                    $controller->index();
        
    }
    
    public function model($param_model) {
        
        //Find, include and make the model ready.
        $model_file_name = str_replace("Model", "", $param_model);
        include("models/" . strtolower($model_file_name) . ".php");
        $actual_model = ucfirst($param_model);
        
        //Create the model object
        $this->$param_model = new $actual_model();
        
        //Link the model to the loader to load and initialize it.
        self::$model_name = $actual_model;
        self::$model =& $this->$actual_model;
        Emma_Controller::init_model();
        
    }
    
    public function view($param_view) {
        
        //Load a view
        include("views/" . $param_view);
        
    }

}