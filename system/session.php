<?php

class Session implements SystemComponent {

    function __construct () {

        //Nothing to do :(

    }
    
    private function initialize () {
        
        //Again nothing to do.. Q______Q
        
    }
    
    public function getAndNullify ($var_name)
    {
        
        $val = $this->get ($var_name);
        $this->nullify ($var_name);
        return $val;
        
    }

    public function get ($var_name) {

        return isset ($_SESSION[$var_name]) ? $_SESSION[$var_name] : false;

    }

    public function set ($var_name, $value) {

        $_SESSION[$var_name] = $value;

    }

    public function nullify ($var_name) {

        $_SESSION[$var_name] = null;

    }


    public static function getInstance () {

        return new Session;

    }
    
}
