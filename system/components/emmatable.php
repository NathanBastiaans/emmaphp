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
    private $joinedKeys;
    private $joinsString;

    public function __construct ()
    {

        $this->db = Database::getInstance ();
        $this->initialize ($this->getTable (get_called_class ()));

    }

    /**
     * @see ITable::getProperTableName()
     */
    public function getProperTableName ($tableNameArray, $i)
    {

        // Lowercase the first letter
        array_splice
        (
            $tableNameArray,
            0,
            1,
            strtolower ($tableNameArray[0])
        );

        // If Array index is a capitol
        if (ctype_upper ($tableNameArray[$i]))
        {

            // Add an underscore before that index
            array_splice
            (
                $tableNameArray,
                $i,
                0,
                "_"
            );

            // Lowercase the index
            array_splice
            (
                $tableNameArray,
                $i + 1,
                1,
                strtolower ($tableNameArray[$i + 1])
            );
            $i++;

        }

        return $i < (count ($tableNameArray) - 1)
            ? $this->getProperTableName ($tableNameArray, ++$i)
            : str_replace ("_table", "", implode ($tableNameArray));

    }

    /**
     * @see ITable::getTable()
     */
    public function getTable ($tableName)
    {

        $i = 2;
        $tableNameArray = str_split ($tableName);

        return $this->getProperTableName ($tableNameArray, $i);

    }

    /**
     * @see ITable::getTableName()
     */
    public function getTableName () { return $this->tableName; }

    /**
     * @see ITable::initialize()
     */
    public function initialize ($name)
    {

        $this->tableName   = $name;
        $this->joinedKeys  = array ();

    }

    /**
     * @see ITable::insert()
     */
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
        foreach ($dataArray as $data) // Just using foreach as an increment
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

    /**
     * Saves all changes to the table
     * @see ITable::save()
     */
    public function save ()
    {

        $query = "UPDATE " . $this->tableName . " $this->joinsString SET ";

        // Add all properties to the "UPDATE SET"
        $i = 0;
        foreach ($this->properties as $prop)
            if ($prop != "id" && ! in_array($prop, $this->joinedKeys))
                    $i++ == 0
                        ? $query .= "$prop = ?"
                        : $query .= ", $prop = ? ";

        // Update by the supplied key via the find () method
        $query .= " WHERE $this->tableName." . $this->key . " = '" . $this->keyValue . "'";

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

                if ($prop != "id" && ! in_array($prop, $this->joinedKeys))
                {

                    array_push ($propertiesArray, $prop);
                    array_push ($valuesArray,     $this->$prop);

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

    /**
     * @see ITable::join()
     */
    public function join ($table, $on, $thisOn)
    {

        if ($on == $this->key)
            die ("[" . $this->tableName .
                 "] AMBIGIUOUS KEYS CRASH. JOINED TABLE DETECTED WITH IDENTICLE KEY TO ORIGINAL TABLE.");

        array_push ($this->joinedKeys, $on);

        $this->joinsString .= <<<SQL
            JOIN $table ON ($table.$on = $this->tableName.$thisOn)
SQL;

    }

    /**
     * @see ITable::leftJoin()
     */
    public function leftJoin ($table, $on, $thisOn)
    {

        if ($on == $this->key)
            die ("[" . $this->tableName .
                 "] AMBIGIUOUS KEYS CRASH. JOINED TABLE DETECTED WITH IDENTICLE KEY TO ORIGINAL TABLE.");

        array_push ($this->joinedKeys, $on);

        $this->joinsString .= <<<SQL
            LEFT JOIN $table ON ($table.$on = $this->tableName.$thisOn)
SQL;

    }

    /**
     * @see ITable::rightJoin()
     */
    public function rightJoin ($table, $on, $thisOn)
    {

        if ($on == $this->key)
            die ("[" . $this->tableName .
                 "] AMBIGIUOUS KEYS CRASH. JOINED TABLE DETECTED WITH IDENTICLE KEY TO ORIGINAL TABLE.");

        array_push ($this->joinedKeys, $on);

        $this->joinsString .= <<<SQL
            RIGHT JOIN $table ON ($table.$on = $this->tableName.$thisOn)
SQL;

    }

    /**
     * @see ITable::innerJoin()
     */
    public function innerJoin ($table, $on, $thisOn)
    {

        if ($on == $this->key)
            die ("[" . $this->tableName .
                 "] AMBIGIUOUS KEYS CRASH. JOINED TABLE DETECTED WITH IDENTICLE KEY TO ORIGINAL TABLE.");

        array_push ($this->joinedKeys, $on);

        $this->joinsString .= <<<SQL
            INNER JOIN $table ON ($table.$on = $this->tableName.$thisOn)
SQL;

    }

    /**
     * @see ITable::outerJoin()
     */
    public function outerJoin ($table, $on, $thisOn)
    {

        if ($on == $this->key)
            die ("[" . $this->tableName .
                 "] AMBIGIUOUS KEYS CRASH. JOINED TABLE DETECTED WITH IDENTICLE KEY TO ORIGINAL TABLE.");

        array_push ($this->joinedKeys, $on);

        $this->joinsString .= <<<SQL
            OUTER JOIN $table ON ($table.$on = $this->tableName.$thisOn)
SQL;

    }

    /**
     * @see ITable::find()
     */
    public function find ($column, $key)
    {

        $this->key      = $column;
        $this->keyValue = $key;

        $sql = <<<SQL
        SELECT *
          FROM $this->tableName

          $this->joinsString

          WHERE $this->key = ?
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
                    $this->keyValue
                )
            );
            $dataArray = $stmt->fetch (PDO::FETCH_ASSOC);
            $stmt->closeCursor ();

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
             && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

            // If query returned result
            if ($dataArray)
            {

                $ran = 0;

                $this->properties = array ();

                foreach ($dataArray as $data)
                {

                    if ( ! in_array ($data, $this->properties))
                    {

                        $ran++ == 0 ? prev ($dataArray) : false;

                        $key        = key ($dataArray);
                        array_push ($this->properties, $key);
                        $this->$key = $data;
                        next ($dataArray);

                    }


                }

                return $ref =& $this;

            }

            return false;

        }

    }

    /**
     * @see ITable::count()
     */
    public function count ($tableRow)
    {
        $this->tableRow = $tableRow;

        $sql = <<<SQL
        SELECT
          $this->tableRow

        FROM $this->tableName
SQL;

        if (DB)
        {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->db->connection->prepare ($sql);
            $stmt->execute();
            $data = $stmt->rowCount ();
            $stmt->closeCursor ();

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
             && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

            // If query returned result
            return $data;

        }

    }

    /**
     * @see ITable::delete()
     */
    public function delete ($column, $key)
    {

        $this->key      = $column;
        $this->keyValue = $key;

        $sql = <<<SQL
        DELETE
          FROM $this->tableName

          WHERE $this->key = ?
          LIMIT 1;
SQL;

        if (DB)
        {

            if (DEBUG_MODE)
                $this->db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->db->connection->prepare ($sql);
            $stmt->execute(array ($key));
            $stmt->closeCursor ();

            $error = $this->db->connection->errorInfo ();

            if
            (
                DEBUG_MODE
             && $error[0] != "00000"
            )
                die (print_r ($this->db->connection->errorInfo ()));

        }

    }

}
