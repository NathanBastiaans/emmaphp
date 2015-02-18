<?php

/**
 * Core of the EmmaPHP MVC Framework.
 */
final class Core
{

    static $controller;

    public function __construct ()
    {
        
        // Include all configurations
        require_once ("application/config/config.php");
        require_once ("application/config/database.php");


        // Include all interfaces
        require_once ("system/isystemcomponent.php");
        require_once ("system/isystemcomponentdatacompatible.php");
        require_once ("system/icontroller.php");
        require_once ("system/imodel.php");
        require_once ("system/itable.php");

        // Include all components
        require_once ("system/loader.php");
        require_once ("system/dataobject.php");
        require_once ("system/mods.php");
        require_once ("system/database.php");
        require_once ("system/emmacontroller.php");
        require_once ("system/emmamodel.php");
        require_once ("system/emmatable.php");
        require_once ("system/autoloader.php");
        
        /*
         * If controller is not set default to
         * the default controller.
         * If the controller is set we use it. 
         */
         if ( ! isset ($_GET["c"]))
         	$_GET["c"] = DEFAULT_CONTROLLER;

        // Check for the controller's actual file.
        if ( ! file_exists ("application/controllers/" . $_GET["c"] . ".php"))
            if (DEBUG_MODE)
                die ("Couldn't find controller: " . $_GET["c"] . " :(");

        // Get it.
        require_once ("application/controllers/" . $_GET["c"] . ".php");

        // Link it, detach the GET request and add the Controller affix.
        $controller_actual = $_GET["c"] . "Controller";
        $_GET["c"] = null;
        
        // Define the loader
        $this->load = new Loader ();
        
        // Use the loader to load the controller
        Core::$controller = $this->load->controller ($controller_actual);

    }
    
}