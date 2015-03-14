<?php

/**
 * Core of the EmmaPHP MVC Framework.
 */
final class Core
{

    static $loader;

    /**
     * Constructor for the core
     * it loads in all configuration and interfaces
     * and then continues to load all components.
     * When that's done the Loader component will be loaded in an instructed
     * to load the designated controller.
     */
    public function __construct ()
    {
        
        // Include all configurations
        require_once ("application/config/config.php");
        require_once ("application/config/database.php");


        // Include all interfaces
        require_once ("system/interfaces/isystemcomponent.php");
        require_once ("system/interfaces/isystemcomponentdatacompatible.php");
        require_once ("system/interfaces/icontroller.php");
        require_once ("system/interfaces/imodel.php");
        require_once ("system/interfaces/itable.php");

        // Include all components
        $sysFiles = glob ("system/components/*.php");

        foreach ($sysFiles as $file)
            require_once ($file);
        
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
        $controllerActual = $_GET["c"] . "Controller";
        $_GET["c"] = null;
        
        // Define the loader
        $this->load = Loader::getInstance ();
        
        // Register the loader to the core
        self::$loader = Loader::getInstance ();
        
        // Use the loader to load the controller
        $this->load->controller ($controllerActual);

    }
    
    static function getRekt ()
    {

		throw new Exception ("Get #REKT", 1337);
    	
	}
    
}
