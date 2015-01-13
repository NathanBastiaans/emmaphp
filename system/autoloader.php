<?php

class AutoLoader implements ISystemComponent
{

    function __construct ()
    {

        include ("config/autoload.php");

        if (count ($autoloadModels) > 0)
            foreach ($autoloadModels as $model)
                EmmaController::$instance->load->model ($model);

        // Load all tables
        $table_files = scandir ("tables");

        for ($i = 0; $i <= 2; $i++)
            array_splice ($table_files, 0, 1);

        foreach ($table_files as $file)
            require_once ("tables/" . $file);

    }

    public static function getInstance ()
    {

        return new AutoLoader ();

    }
}