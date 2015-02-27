<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader implements ISystemComponent
{
    
    static $instance;
    static $model;
    static $modelName;
//    static $table;
//    static $table_name;
    static $mod;
    static $modName;
    static $controller;
    static $database;
    
    /**
     * Prepares the loader to do whatever necessary.
     */
    function __construct ()
    {
        
        // Load database
        self::$database = Database::getInstance();

        // Link an instance of the loader to itself
        self::$instance =& $this;
        
        //Load all mods
        ModLoader::getInstance ();

    }

    /**
     * Loads a controller into the framework
     * 
     * @param string $paramController
     */
    public function controller ($paramController)
    {
        
        // Create given controller object
        $controller = new $paramController ();
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
    
    /**
     * Loads a model into the framework
     * 
     * @param string $paramModel
     */
    public function model ($paramModel)
    {
        
        //Find, include and make the model ready
        $modelFileName = str_replace ("Model", "", $paramModel);
        $modelName      = ucfirst ($paramModel);
        require_once ("application/models/" . strtolower ($modelFileName) . ".php");

        //Create the model object
        $modelObject = new $modelName ();
        $modelObject->constructor ();
        if (method_exists ($modelObject, "init"))
            $modelObject->init ();

        //Link the model to the loader to load and initialize it
        self::$model       =& $modelObject;
        self::$modelName   =  $modelName;

        //Load and initialize it into the controller as an object
        EmmaController::$instance->$modelName =& self::$model;

    }

    /**
     * Instructs the controller to load and render a view
     * 
     * @param string $paramView
     */
    public function view ($paramView)
    {
        
        //Load a view
        EmmaController::$instance->initView ($paramView);
        
    }

    /**
     * Instance control
     * 
     * @return Loader
     */
    public static function getInstance ()
    {

        return self::$instance === null
        	? self::$instance = new self
        	: $ref =& self::$instance;

    }
    
}
