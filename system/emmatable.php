<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable extends EmmaModel implements ITable
{

    private $tableName;

    function __construct ()
    {

        parent::__construct ();

    }

    public function getTableName () { return $this->tableName; }

    public function initialize ($name)
    {

        $this->tableName = $name;

    }

    public function find ($column, $key)
    {

        $sql = <<<SQL
        SELECT *
          FROM $this->tableName

          WHERE $column = ?
          LIMIT 1;
SQL;

        if (DB)
        {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->db->connection->prepare ($sql);
            $stmt->execute
            (
                array
                (
                    $key
                )
            );
            $result = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            $error = $this->db->connection->errorInfo ();

            if (DEBUG_MODE)
                if ($error[0] != "00000")
                    die (print_r ($this->db->connection->errorInfo ()));

            die (var_dump ($result));

            foreach ($result as $data)
            {

                $key        = key ($results);
                $this->$key = $data;
                next ($results);

            }

        }

    }
    
}