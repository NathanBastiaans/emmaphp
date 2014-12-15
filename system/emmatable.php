<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable extends EmmaModel implements ITable
{

    private $db;

    function __construct ()
    {

        $this->db = Database::getInstance ();

    }

    public function getTable ()
    {

        $i = 2;
        $tableNameArray = str_split (__CLASS__);
        function getProperTableName ($tableNameArray, $i)
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
                ? getProperTableName ($tableNameArray, ++$i)
                : implode ($tableNameArray);

        }
        return getProperTableName ($tableNameArray, $i);

    }

    protected function find ($column, $key)
    {

        $dataobject = $this->fetch
        (
            <<<SQL
          SELECT *
            FROM ?

            WHERE ? = ?
            LIMIT 1;
SQL
            ,
            array
            (
                $this->getTable (),
                $column,
                $key
            )
        );


    }
    
}