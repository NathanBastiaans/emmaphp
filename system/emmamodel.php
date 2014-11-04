<?php

abstract class EmmaModel implements Model {
    
    static $instance;
    
    public $db;

    public function __construct () {}
    
    public function query ($query, $params = NULL) {

        if (DB) {
        
            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);

            if (DEBUG_MODE)
                if ($this->db->connection->errorInfo ()[0] != "00000")
                    die ($this->db->connection->errorInfo ());

        }
            
    }

    public function oldFetch ($query, $params = NULL) {

        if (DB) {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $result = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            if (DEBUG_MODE)
                if ($this->db->connection->errorInfo ()[0] != "00000")
                    die ($this->db->connection->errorInfo ());

            return $result ? $result : false;

        }

    }

    public function oldFetchAll ($query, $params = NULL) {

        if (DB) {
        
            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $result = $stmt->fetchAll (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            if (DEBUG_MODE)
                if ($this->db->connection->errorInfo ()[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));

            return $result ? $result : false;

        }

    }

    public function fetch ($query, $params = NULL) {

        if (DB) {
        
            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $result = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            if (DEBUG_MODE)
                if ($this->db->connection->errorInfo ()[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));

            //Send single data object
            return $result ? DataObject::getInstance ($result) : false;

        }
            
    }
    
    public function fetchAll ($query, $params = NULL) {

        if (DB) {

            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $results = $stmt->fetchAll (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            if (DEBUG_MODE)
                if ($this->db->connection->errorInfo ()[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));

            $data_objects = array ();
            foreach ($results as $result) {

                array_push ($data_objects, DataObject::getInstance ($result));

            }

            //Send all data objects in an array
            return $result ? $data_objects : false;

        }
        
    }

    protected function generateSalt () {

        return sha1 (openssl_random_pseudo_bytes (100));

    }

    protected function encrypt ($string) {

        return sha1 ($string);

    }
    
}

