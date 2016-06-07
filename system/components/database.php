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
    
    public function query ($query, $params = NULL)
    {
        if (DB)
        {
        
            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $error = $this->db->connection->errorInfo ();
            if (DEBUG_MODE)
                if ($error[0] != "00000")
                    die ($this->db->connection->errorInfo ());
        }
            
    }

    public function fetch ($query, $params = NULL)
    {
        if (DB)
        {
        
            if (DEBUG_MODE)
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $result = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();
            $error = $this->db->connection->errorInfo ();
            if (DEBUG_MODE)
                if ($error[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));
            //Send single data object
            return $result 
			    ? DataObject::getInstance ($result)
			    : false;
        }
            
    }
    
    public function fetchAll ($query, $params = NULL)
    {
        if (DB)
        {
            if (DEBUG_MODE) 
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->db->connection->prepare ($query);
            $stmt->execute ($params);
            $results = $stmt->fetchAll (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();
            $error = $this->db->connection->errorInfo ();
            if (DEBUG_MODE)
                if ($error[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));
            $dataObjects = array ();
            foreach ($results as $result)
                array_push ($dataObjects, DataObject::getInstance ($result));
            //Send all data objects in an array
            return $results ? $dataObjects : false;
        }
        
    }

    /**
     * Either returns a new Database instance if there isn't one in place already
     * or returns a reference to the already in place database object
     *
     * @return Ambigous <Database, &Database>
     */
    public static function getInstance ()
    {

        return Loader::$database === null
            ? new self ()
            : $ref =& Loader::$database;

    }
    
}
