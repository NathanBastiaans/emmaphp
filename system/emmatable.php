<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable implements ITable
{

    private $tableName;
    private $db;

    private $key;
    private $keyValue;

    function constructor ()
    {

        $this->db = Database::getInstance ();

    }

    public function getTableName () { return $this->tableName; }

    public function initialize ($name)
    {

        $this->tableName = $name;

    }

    public function insert ($dataArray)
    {

        // Get all keys from the array so we may use them in the query
        $keyArray = array_keys($dataArray);

        $query = "INSERT INTO " . $this->tableName . " ";

        $query .= "(";

        // Add key to the query and add a comma only
        // if current index is not last in the array
        $i = 0;
        foreach ($keyArray as $key)
            ++$i < count($keyArray)
                ? $query .= $key . ", "
                : $query .= $key . ")";

        $query .= " VALUES (";

        // Add key to the query and add a comma only
        // if current index is not last in the array
        $i = 0;
        foreach ($dataArray as $data)
            ++$i < count($dataArray)
                ? $query .= "?" . ", "
                : $query .= "?" . ")";

        // Copy the array and clear it of its keys for use in execute ()
        $valuesArray = array_values ($dataArray);

        if (DB)
        {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute
                (
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            $stmt = $this->db->connection->prepare ($query);

            $stmt->execute ($valuesArray);

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
                && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

        }

    }

    public function save ()
    {

        $query = "UPDATE " . $this->tableName . " SET ";

        // Add all properties to the "UPDATE SET"
        $i = 0;
        foreach ($this->properties as $prop)
            if ($prop != "id")
                $i++ == 0
                    ? $query .= "$prop = ?"
                    : $query .= ", $prop = ? ";

        // Update by the supplied key via the find () method
        $query .= "WHERE " . $this->key . " = " . $this->keyValue;

        $query .= " LIMIT 1;";

        if (DB)
        {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute
                (
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            $stmt = $this->db->connection->prepare ($query);

            $propertiesArray = array ();
            $valuesArray     = array ();

            foreach ($this->properties as $prop)
            {

                if ($prop != "id")
                {

                    array_push ($propertiesArray, $prop);
                    array_push ($valuesArray, $this->$prop);

                }

            }

            $stmt->execute ($valuesArray);

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
             && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

        }

    }

    public function find ($column, $key)
    {

        $this->key      = $column;
        $this->keyValue = $key;

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