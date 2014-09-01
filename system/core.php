<?php

/**
 * Core of the EmmaPHP MVC Framework.
 */
class Core {
    
    function __construct() {
        
        require_once("loader.php");
        require_once("database.php");
        require_once("controller.php");
        require_once("model.php");
        
    }
    
    public function run() {
        
        if(!isset($_GET["c"]))
            if(isset($_SESSION["controller"]))
                $_GET["c"] = $_SESSION["controller"];
            else
                $_GET["c"] = DEFAULT_CONTROLLER;

        if(!file_exists("controllers/" . $_GET["c"] . ".php"))
            die("Couldn't find controller: " . $_GET["c"] . " :(");

        require_once("controllers/" . $_GET["c"] . ".php");

        $controller_actual = $_GET["c"] . "Controller";
        
        $this->load = new Loader();
        $this->load->controller($controller_actual);

    }
    
}
