<?php

interface IModel
{

    /**
     * Accepts a SQL query as a string
     * and execute it into the database.
     *
     * @param $query
     * @param array $params
     * @return bool|DataObject
     */
    function query ($query, $params = NULL);
    
    /**
     */

    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as a DataObject.
     *
     * @param $query
     * @param array $params
     * @return bool|DataObject
     */
    function fetch ($query, $params = NULL);

    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as an array with DataObjects.
     *
     * @param $query
     * @param array $params
     * @return bool|DataObject
     */
    function fetchAll ($query, $params = NULL);

}