<?php

class AutoLoader implements ISystemComponent
{

    function __construct ()
    {

        global $autoloadModels;
        global $autoloadTables;

        if (count ($autoloadModels) > 0)
            foreach ($autoloadModels as $model)
                EmmaController::$instance->load->model ($model);

        if (count ($autoloadTables) > 0)
            foreach ($autoloadTables as $table)
                EmmaController::$instance->load->table ($table);

    }

    public static function getInstance ()
    {

        return new AutoLoader ();

    }
}