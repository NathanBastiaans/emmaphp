<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader {
    
    static $linkage;
    static $model;
    static $model_name;
    
    function __construct() {
        
        self::$linkage =& $this;
        
    }
    
    public function controller($param_controller) {
        
        $controller = new $param_controller();

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
                    
                    $args = $_GET["a"];
                    $controller->$_GET["m"]($args);
                    
                } else
                    $controller->$_GET["m"]();
            }
        else
            if(method_exists($controller, "index"))
                    $controller->index();
        
    }
    
    public function model($param_model) {
        
        $model_file_name = str_replace("_model", "", $param_model);
        include("models/" . strtolower($model_file_name) . ".php");
        $actual_model = ucfirst($param_model);
        
        $this->$param_model = new $actual_model();
        
        self::$model_name = $actual_model;
        self::$model =& $this->$actual_model;
        Emma_Controller::init_model();
        
    }
    
    public function view($param_view) {
        
        include("views/" . $param_view);
        
    }

}