<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader implements ISystemComponent
{
    
    static $instance;
    static $model;
    static $model_name;
//    static $table;
//    static $table_name;
    static $mod;
    static $mod_name;
    static $controller;
    static $database;
    
    function __construct ()
    {
        
        $this->initialize ();

    }
    
    private function initialize ()
    {

        // Load database
        self::$database = Database::getInstance();

        // Link an instance of the loader to itself
        self::$instance =& $this;
        
        //Load all mods
        new Mods ();
        
    }

    public function controller ($param_controller)
    {
        
        // Create given controller object
        $controller = new $param_controller ();
        $controller->constructor ();
        if (method_exists ($controller, "init"))
            $controller->init ();

        /*
         * Check for a supplied method with the GET
         * If set we check if it's public and execute it if not
         * we throw an error
         */
        if (isset ($_GET["m"]))
        {

            if ( ! method_exists ($controller, $_GET["m"]))
                die ("Couldn't find method: " . $_GET["m"]
                    . " <br/>In controller: " . $_GET["c"] . " :(");
            else
            {

                // Check if the supplied method is public
                $reflection = new ReflectionMethod ($controller, $_GET["m"]);
                if ( ! $reflection->isPublic ())
                {

                    if (DEBUG_MODE)
                        die("Method: " . $_GET["m"] . " from"
                        . " Controller: " . $_GET["c"]
                        . " is not a public method.");

                }
                else if (isset ($_GET["a"]))
                {
                    
                    //Check if arguments should be supplied
                    $args = filter_var ($_GET["a"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $controller->$_GET["m"] ($args);

                }
                else
                {

                    $controller->$_GET["m"] ();

                }

            }

        } else { // if $_GET["m"] isn't set

            // If the index method exists within the controller, we run it.
            if (method_exists($controller, "index"))
                $controller->index();

        }

        // Link the controller to the loader
        self::$controller =& $controller;
        
        // Return the reference to the controller instance back to the Core
        return self::$controller;
        
    }
    
    public function model ($param_model)
    {
        
        //Find, include and make the model ready
        $model_file_name = str_replace ("Model", "", $param_model);
        $model_name      = ucfirst ($param_model);
        require_once ("application/models/" . strtolower ($model_file_name) . ".php");

        //Create the model object
        $model_object = new $model_name ();
        $model_object->constructor ();
        if (method_exists ($model_object, "init"))
            $model_object->init ();

        //Link the model to the loader to load and initialize it
        self::$model        =& $model_object;
        self::$model_name   =  $model_name;

        //Load and initialize it into the controller as an object
        EmmaController::$instance->$model_name =& self::$model;

    }

    public function view ($param_view)
    {
        
        //Load a view
        EmmaController::$instance->initView ($param_view);
        
    }

    public static function getInstance ()
    {

        return new Loader;

    }
    
}
