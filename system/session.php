<?php

class Session {

    public function get ($var_name) {

        return $_SESSION[$var_name];

    }

    public function set ($var_name, $value) {

        $_SESSION[$var_name] = $value;

    }

}