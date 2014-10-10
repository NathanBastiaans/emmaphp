<?php

abstract class EmmaModel implements Model {
    
    static $instance;
    
    public $db;
    
    function __construct () {
        
//        $this->db = new Database ();
        
    }

}