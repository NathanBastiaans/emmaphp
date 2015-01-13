<?php

interface ITable
{

    function __construct ();
    function initialize ($name);

    function getTable ($tableName);
    function getTableName ();
    function getProperTableName ($tableNameArray, $i);
    function find ($column, $key);
    function insert ($dataArray);
    function save ();
    function delete ($column, $key);
    function join ($table, $on, $thisOn);
    function leftJoin ($table, $on, $thisOn);
    function rightJoin ($table, $on, $thisOn);
    function innerJoin ($table, $on, $thisOn);
    function count ($tablerow);

}