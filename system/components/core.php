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
			
		// Include all configurations
        require_once ("config.php");


        //Session
        if ( ! isset ($_SESSION))
            session_start ();

        // Route dispatcher. Find route
        $route = Router::dispatch ();

        /*
         * If route doesn't exist set default
         */
        if($route == false) {

            $route = (object) array(
                'segments' => array(
                    'Error', 'index'
                ),
                'matched' => array(
                    "Couldn't find that route."
                )
            );

        }
        
        // Define the loader
        $this->load = Loader::getInstance ();
        
        // Register the loader to the core
        self::$loader = Loader::getInstance ();
        
        // Use the loader to load the controller
        $this->load->controller ($route);

    }
    
    static function getRekt ()
    {

        trigger_error ("You just got #REKT");
        
    }
    
}
