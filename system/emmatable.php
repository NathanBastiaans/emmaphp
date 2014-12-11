<?php

/**
 * Base Table of the EmmaPHP MVC Framework
 */
abstract class EmmaTable extends EmmaModel implements ITable
{

    function __construct ()
    {

        parent::__construct ();
        
    }
    
    public function initialize ($tableName)
    {

        $this->fetch
        (
            <<<SQL
            SELECT *
                FROM ?;
SQL
            ,
            array
            (
                $tableName
            )
        );


        
    }
    
}