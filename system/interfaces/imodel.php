<?php

interface IModel
{

    /**
     * Accepts a SQL query as a string
     * and execute it into the database.
     */
    function query ($query, $params = NULL);
    
    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as a DataObject.
     */
    function fetch ($query, $params = NULL);
    
    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as an array with DataObjects.
     */
    function fetchAll ($query, $params = NULL);

}