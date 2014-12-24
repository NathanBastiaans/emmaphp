<?php

/**
 * Core of the EmmaPHP MVC Framework.
 */
class Core implements ISystemComponent
{

    static $instance;

    function __construct ()
    {

        $this->initialize ();
        
    }
    
    private function initialize ()
    {
        
        //Include all interfaces
        require_once("icontroller.php");
        require_once("imodel.php");
        require_once ("itable.php");

        //Include all components
        require_once ("loader.php");
        require_once("dataobject.php");
        require_once ("mods.php");
        require_once ("database.php");
        require_once ("emmacontroller.php");
        require_once ("emmamodel.php");
        require_once ("emmatable.php");
        require_once ("session.php");
        require_once ("autoloader.php");
        
    }
    
    public function run ()
    {
        
        /*
         * If controller is not set default to
         * the default controller.
         * If the controller is set we use it. 
         */
        if ( ! isset ($_GET["c"]))
            if (isset ($_SESSION["controller"]))
                $_GET["c"] = $_SESSION["controller"];
            else
                $_GET["c"] = DEFAULT_CONTROLLER;

        //Check for the controller's actual file.
        if ( ! file_exists ("controllers/" . $_GET["c"] . ".php"))
            if (DEBUG_MODE)
                die ("Couldn't find controller: " . $_GET["c"] . " :(");

        //Get it.
        require_once ("controllers/" . $_GET["c"] . ".php");

        //Link it, detach the GET request and add the Controller affix.
        $controller_actual = $_GET["c"] . "Controller";
        $_GET["c"] = null;
        
        //Load it.
        $this->load = new Loader ();
        $this->load->controller ($controller_actual);

    }

    public static function getInstance ()
    {

        return self::$instance === null
            ? new self ()
            : false;

    }
    
}