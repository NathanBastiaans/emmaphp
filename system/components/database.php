<?php

class Database
{

    public $connection;

    /**
     * By defining a private final constructor we restrict manual
     * instancing of the database class from the outside.
     */
    private final function __construct ()
    {
        
        $this->initialize ();
        
    }

    /**
     * By defining a private final __clone () 
     * we restrict the usage of the cloning statement 
     * on all instances of our database object.
     */
    private final function __clone () {}
    
    /**
     * Establishes a database connection using the PDO object.
     */
    private function initialize ()
    {
        
        if (DB)
        {

            $this->connection = $link = new PDO
            (
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";",
                DB_USERNAME,
                DB_PASSWORD
            );

        }
        
    }

    /**
     * Either returns a new Database instance if there isn't one in place already
     * or returns a reference to the already in place database object
     * @return Ambigous <Database, &Database>
     */
    public static function getInstance ()
    {

        return Loader::$database === null
            ? new self ()
            : $ref =& Loader::$database;

    }
    
}