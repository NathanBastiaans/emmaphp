<?php

class Session implements SystemComponent {

    public function get ($var_name) {

        return isset ($_SESSION[$var_name]) ? $_SESSION[$var_name] : false;

    }

    public function set ($var_name, $value) {

        $_SESSION[$var_name] = $value;

    }

    public function nullify ($var_name) {

        $_SESSION[$var_name] = null;

    }

    function __construct () {

        //Nothing to do :(

    }

    public static function getInstance () {

        return new Session;

    }
}
