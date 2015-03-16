<?php

interface IModel
{

    function constructor ();
    
    /**
     * Accepts a SQL query as a string
     * and execute it into the database.
     */
    function query ();
    
    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as a DataObject.
     */
    function fetch ();
    
    /**
     * Accepts a SQL query as a string
     * and executes it into the database.
     * Afterwards it returns the selected data as an array with DataObjects.
     */
    function fetchAll ();

}