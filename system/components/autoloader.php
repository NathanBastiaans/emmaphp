<?php

class AutoLoader implements ISystemComponent
{

    static $autoloadModels = array ();

	/**
	 * Constructor autoloader
	 * Loads all models assigned to the autoloader
	 * and passively loads all tables
	 */
    function __construct ()
    {

        if (count (self::$autoloadModels) > 0)
            foreach (self::$autoloadModels as $model)
                EmmaController::$instance->load->model ($model);

        // Load all tables
        $tableFiles = glob ("tables/*.php");

        foreach ($tableFiles as $file)
            require_once ($file);

    }

    public static function getInstance ()
    {

        return new AutoLoader();

    }
}
