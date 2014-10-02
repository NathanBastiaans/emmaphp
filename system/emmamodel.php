<?php

abstract class EmmaModel implements SystemComponent {

    protected $db;
    
    function __construct () {
        
        $this->db = new Database ();
        
    }

//    public function query ($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare ($sql);
//        $stmt->execute ();
//
//    }
//
//    public function fetch ($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare ($sql);
//        $stmt->execute ();
//
//        return $stmt->fetch (PDO::FETCH_ASSOC);
//
//    }
//
//    public function fetchAll ($param_query) {
//
//        $sql = $param_query;
//        $stmt = $this->connection->prepare ($sql);
//        $stmt->execute ();
//
//        return $stmt->fetchAll (PDO::FETCH_ASSOC);
//
//    }

}