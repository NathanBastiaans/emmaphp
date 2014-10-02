<?php

class Database implements SystemComponent {

    public $connection;
    
    function __construct () {
        
        if (DB) {

                $this->connection =
                        $link = new PDO ("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";",
                                                         DB_USERNAME, DB_PASSWORD);

        }
        
    }

    public static function getInstance () {

        return new Database;

    }
}