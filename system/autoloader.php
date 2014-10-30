<?php

class AutoLoader implements SystemComponent {

    function __construct () {

        global $autoload;

        foreach ($autoload as $model)
            Loader::$controller->load->model ($model);

    }

    public static function getInstance () {

        return new AutoLoader ();

    }
}