<?php

class AutoLoader implements ISystemComponent
{

    function __construct ()
    {

        global $autoloadModels;
        global $autoloadTables;

        foreach ($autoloadModels as $model)
            Loader::$controller->load->model ($model);

        foreach ($autoloadTables as $table)
            Loader::$controller->load->table ($model);

    }

    public static function getInstance ()
    {

        return new AutoLoader ();

    }
}