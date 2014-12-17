<?php

/**
 * Loader of the EmmaPHP MVC Framework
 */
class Loader implements ISystemComponent
{
    
    static $instance;
    static $model;
    static $model_name;
    static $table;
    static $table_name;
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

        //Make a link to the loader object.
        self::$instance =& $this;
        
        //Load all mods
        new Mods ();
        
    }

    public function getTable ($tableName)
    {

        $i = 2;
        $tableNameArray = str_split ($tableName);
        function getProperTableName ($tableNameArray, $i)
        {

            // Lowercase the first letter
            array_splice
            (
                $tableNameArray,
                0,
                1,
                strtolower ($tableNameArray[0])
            );

            // If Array index is a capitol
            if (ctype_upper ($tableNameArray[$i]))
            {

                // Add an underscore before that index
                array_splice
                (
                    $tableNameArray,
                    $i,
                    0,
                    "_"
                );

                // Lowercase the index
                array_splice
                (
                    $tableNameArray,
                    $i + 1,
                    1,
                    strtolower ($tableNameArray[$i + 1])
                );
                $i++;

            }

            return $i < (count ($tableNameArray) - 1)
                ? getProperTableName ($tableNameArray, ++$i)
                : str_replace ("_table", "", implode ($tableNameArray));

        }
        return getProperTableName ($tableNameArray, $i);

    }
    
    public function controller ($param_controller)
    {
        
        //create given controller object
        $controller = new $param_controller ();

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

        self::$controller =& $controller;
        
    }
    
    public function model ($param_model)
    {
        
        //Find, include and make the model ready
        $model_file_name = str_replace ("Model", "", $param_model);
        $model_name      = ucfirst ($param_model);
        require_once ("models/" . strtolower ($model_file_name) . ".php");

        //Create the model object
        $model_object = new $model_name ();
        
        //Link the model to the loader to load and initialize it
        self::$model        =& $model_object;
        self::$model_name   =  $model_name;

        //Load and initialize it into the controller as an object
        EmmaController::$instance->$model_name =& self::$model;

    }

    public function table ($param_table)
    {

        // Find the file and include it
        $table_file_name = str_replace ("Table", "", $param_table);
        $table_name_actual = ucfirst ($param_table);
        require_once ("tables/" . strtolower ($table_file_name) . ".php");

        // Create Table object
        $table_object = new $table_name_actual ($table_name_actual);

        // Link the table to the loader to load and initialize it
        self::$table        =& $table_object;
        self::$table_name   =  $table_name_actual;

        // Load and initialize the table into the controller as an object
        EmmaController::$instance->$table_name_actual =& self::$table;
        EmmaController::$instance->$table_name_actual->initialize ($this->getTable ($param_table));

    }

    public function view ($param_view)
    {
        
        //Load a view
        EmmaController::$instance->init_view ($param_view);
        
    }

    public static function getInstance ()
    {

        return new Loader;

    }
    
}
