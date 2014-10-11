<?php

abstract class EmmaModel implements Model {
    
    static $instance;
    
    public $db;

    public function __construct () {}
    
    /**
     * @todo TEST THESE FUNCTIONS
     */
    public function query ($query, $params) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        
    }
    
    public function fetch ($query, $params) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        $result = $stmt->fetch (PDO::FETCH_ASSOC);
        $stmt->closeCursor ();
        
        return $result;
        
    }
    
    public function fetchAll ($query, $params) {
        
        $stmt = $this->db->connection->prepare ($query);
        $stmt->execute ($params);
        $result = $stmt->fetchAll (PDO::FETCH_ASSOC);
        $stmt->closeCursor ();
        
        return $result;
        
    }
    
}