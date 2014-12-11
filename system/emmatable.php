<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable implements ITable
{

    protected $tableName;

    private $db;

    function __construct ($tableName)
    {

        parent::__construct ();

        $this->initialize ();
        
    }
    
    private function initialize ()
    {
        
        $this->db = Database::getInstance();
        
    }
    
}