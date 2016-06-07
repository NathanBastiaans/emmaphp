<?php

interface ITable
{

	/**
	 * Initializes all variables.
	 * 
	 * @param string $name
	 */
    function initialize ($name);

    /**
     * Returns the properly formatted table name.
     * 
     * @param string $tableName
     */
    function getTable ($tableName);
    
    /**
     * Returns the raw table name.
     */
    function getTableName ();
    
    /**
     * Returns a proper tablename.
     * 
     * @param array $tableNameArray
     * @param integer $i
     */
    function getProperTableName ($tableNameArray, $i);
    
    /**
     * Allows for searching data by a column and it's key using
     * the mysql SELECT statement
     * 
     * @param string $column
     * @param string $key
     */
    function find ($column, $key);
    
    /**
     * Supplies the user with a way to use the INSERT statement
     * to execute queries into the database to insert data into tables.
     * 
     * @param Array $dataArray
     */
    function insert ($dataArray);
    
    /**
     * Allows for inserting data into the database.
     */
    function save ();
    
    /**
     * Allows for deleting data through
     * the mysql DELETE statement
     * 
     * @param string $column
     * @param string $key
     */
    function delete ($column, $key);
    
    /**
     * Joins tables through the mysql JOIN statement
     * 
     * @param string $table
     * @param string $on
     * @param string $thisOn
     */
    function join ($table, $on, $thisOn);
    
    /**
     * Joins tables through the mysql LEFT JOIN statement
     * 
     * @param string $table
     * @param string $on
     * @param string $thisOn
     */
    function leftJoin ($table, $on, $thisOn);
    
    /**
     * Joins tables through the mysql RIGHT JOIN statement
     * 
     * @param string $table
     * @param string $on
     * @param string $thisOn
     */
    function rightJoin ($table, $on, $thisOn);
    
    /**
     * Joins tables through the mysql INNER JOIN statement
     * 
     * @param string $table
     * @param string $on
     * @param string $thisOn
     */
    function innerJoin ($table, $on, $thisOn);
    
    /**
     * Joins tables through the mysql OUTER JOIN statement
     * 
     * @param string $table
     * @param string $on
     * @param string $thisOn
     */
    function outerJoin ($table, $on, $thisOn);
    
    /**
     * Returns the amount of rows found by using
     * the mysql COUNT statement
     * 
     * @param string $tablerow
     */
    function count ($tablerow);

}