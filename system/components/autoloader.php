<?php

class AutoLoader implements ISystemComponent
{

	/**
	 * Constructor autoloader
	 * Loads all models assigned to the autoloader
	 * and passively loads all tables
	 */
    function __construct ()
    {

        include ("application/config/autoload.php");

        if (count ($autoloadModels) > 0)
            foreach ($autoloadModels as $model)
                EmmaController::$instance->load->model ($model);

        // Load all tables
        $tableFiles = scandir ("application/tables");

        for ($i = 0; $i <= 2; $i++)
            array_splice ($tableFiles, 0, 1);

        foreach ($tableFiles as $file)
            require_once ("application/tables/" . $file);

    }

    public static function getInstance ()
    {

        return new AutoLoader ();

    }
}