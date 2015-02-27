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
        require_once ("system/interfaces/isystemcomponent.php");
        require_once ("system/interfaces/isystemcomponentdatacompatible.php");
        require_once ("system/interfaces/icontroller.php");
        require_once ("system/interfaces/imodel.php");
        require_once ("system/interfaces/itable.php");

        // Include all components
        $sys_files = scandir ("system/components");
        
        for ($i = 0; $i <= 1; $i++) 
            array_splice ($sys_files, 0, 1);
        
        foreach ($sys_files as $file)
            require_once ("system/components/" . $file);
        
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