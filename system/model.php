<?php

abstract class EmmaModel {

    protected $db;
    
    function __construct() {
        
        $this->db = new Database();
        
    }

}