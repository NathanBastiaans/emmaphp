<?php

/**
 * Core of the EmmaPHP MVC Framework.
 */
class Core {
    
    function __construct () {
        
        //Include all modules
        require_once ("loader.php");
        require_once ("database.php");
        require_once ("controller.php");
        require_once ("model.php");
        require_once ("table.php");
        
    }
    
    public function run () {
        
        /*
         * If controller is not set default to
         * the default controller.
         * If the controller is set we use it. 
         */
        if (!isset ($_GET["c"]))
            if (isset ($_SESSION["controller"]))
                $_GET["c"] = $_SESSION["controller"];
            else
                $_GET["c"] = DEFAULT_CONTROLLER;

        //Check for the controller's actual file.
        if (!file_exists ("controllers/" . $_GET["c"] . ".php"))
            die ("Couldn't find controller: " . $_GET["c"] . " :(");

        //Get it.
        require_once ("controllers/" . $_GET["c"] . ".php");

        //Link it and add the Controller affix.
        $controller_actual = $_GET["c"] . "Controller";
        
        //Load it.
        $this->load = new Loader ();
        $this->load->controller ($controller_actual);

    }
    
}
