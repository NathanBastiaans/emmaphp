<?php

class Database
{

    public $connection;

    private final function __construct ()
    {
        
        $this->initialize ();
        
    }

    private final function __clone () {}
    
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

        return Loader::$database === null
            ? new self ()
            : $databaseReference =& Loader::$database;

    }
    
}