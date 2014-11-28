<?php

class Database implements ISystemComponent
{

    public $connection;
    
    function __construct ()
    {
        
        $this->initialize ();
        
    }
    
    private function initialize ()
    {
        
        if (DB)
        {

            $this->connection = $link = new PDO
            (

                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";",
                DB_USERNAME,
                DB_PASSWORD);

            }
        
    }

    public static function getInstance ()
    {

        return new Database;

    }
    
}