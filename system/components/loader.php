<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader implements ISystemComponent
{
    
    static $instance;
    static $model;
    static $modelName;
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
        
        // Check for the controller's actual file
        if( ! file_exists("application/controllers/" . $paramController->segments[0] . ".php")) {
            if(DEBUG_MODE)
                die ("Couldn't find controller: " . $paramController->segments[0] . " :(");
        }

        // Require controller file
        require_once ("application/controllers/" . $paramController->segments[0] . ".php");
        
        // Add Controller affix
        $paramController->segments[0] = $paramController->segments[0].'Controller';

        // Create given controller object
        $controller = new $paramController->segments[0] ();
        $controller->constructor ();
        if (method_exists ($controller, "init"))
            $controller->init ();

        // Link the controller instance to the loader
        self::$controller =& $controller;
        

        /*
         * Load method from controller
         */
        if( ! method_exists($controller, $paramController->segments[1])) {
           
            die ("Couldn't find method: " . $paramController->segments[1]
                . " <br/>In controller: " . $paramController->segments[0] . " :(");

        } else {


            // Check if the supplied method is public
            $reflection = new ReflectionMethod ($controller, $paramController->segments[1]);
            if ( ! $reflection->isPublic ()) {

                if (DEBUG_MODE)
                    die("Method: " . $paramController->segments[1] . " from"
                    . " Controller: " . $paramController->segments[0]
                    . " is not a public method.");

            } else {

                // If route has any matched vars from regex route. Pass to method
                // Else just run method
                if(isset($paramController->matched)) {
                    call_user_func_array(array($controller, $paramController->segments[1]), $paramController->matched);
                } else {
                    $method = $paramController->segments[1];
                    $controller->$method(); 
                }

            }

        }
        
    }
    
    /**
     * Loads a model into the framework
     * 
     * @param string $paramModel
     */
    public static function model ($paramModel)
    {
        
        //Find, include and make the model ready
        $modelFileName  = str_replace ("Model", "", $paramModel);
        $modelName      = ucfirst ($paramModel);
        require_once ("models/" . strtolower ($modelFileName) . ".php");

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
    public static function view ($paramView)
    {

        if ( ! file_exists ("views/" . $paramView))
        {
        
            self::$controller->fourOhFour ();
        
        }
        else
        {
        
            //Load a view
            self::$controller->initView ($paramView);
        
        }
        
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
