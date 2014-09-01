<?php

abstract class Emma_Model {

    protected $db;
    
    function __construct() {
        
        $this->db = new Database();
        
    }

}