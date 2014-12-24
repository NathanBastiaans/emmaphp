<?php

class AutoLoader implements ISystemComponent
{

    function __construct ()
    {

        global $autoloadModels;
        global $autoloadTables;

        foreach ($autoloadModels as $model)
            EmmaController::$instance->load->model ($model);

        foreach ($autoloadTables as $table)
            EmmaController::$instance->load->table ($table);

    }

    public static function getInstance ()
    {

        return new AutoLoader ();

    }
}