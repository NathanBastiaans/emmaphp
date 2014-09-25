<?php

class Database {

    public $connection;
    
    function __construct() {
        
        if(DB) {

                $this->connection =
                        $link = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";",
                                                         DB_USERNAME, DB_PASSWORD);

        }
        
    }
    
//    public function query($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare($sql);
//        $stmt->execute();
//
//    }
//
//    public function fetch($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare($sql);
//        $stmt->execute();
//
//        return $stmt->fetch(PDO::FETCH_ASSOC);
//
//    }
//
//    public function fetchAll($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare($sql);
//        $stmt->execute();
//
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//    }
    
}