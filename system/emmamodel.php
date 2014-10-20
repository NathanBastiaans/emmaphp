<?php

abstract class EmmaModel implements Model {
    
    static $instance;
    
    public $db;

    public function __construct () {}
    
    public function query ($query, $params = NULL) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        
    }
    
    public function fetch ($query, $params = NULL) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        $result = $stmt->fetch (PDO::FETCH_ASSOC);
        $stmt->closeCursor ();
        
        return $result;
        
    }
    
    public function fetchAll ($query, $params = NULL) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        $result = $stmt->fetchAll (PDO::FETCH_ASSOC);
        $stmt->closeCursor ();
        
        return $result;
        
    }
    
}
