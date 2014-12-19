<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable implements ITable
{

    private $tableName;
    private $db;

    function __construct ()
    {

        $this->db = Database::getInstance ();

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
            $data_array = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
             && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

            // If query returned result
            if ($data_array)
            {

                $ran = 0;

                $this->properties = array ();

                foreach ($data_array as $data)
                {

                    $ran++ == 0 ? prev ($data_array) : false;

                    $key        = key ($data_array);
                    array_push ($this->properties, $key);
                    $this->$key = $data;
                    next ($data_array);

                }

                return $ref =& $this;

            }

            return false;

        }

    }
    
}