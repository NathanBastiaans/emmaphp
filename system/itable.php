<?php

interface ITable
{

    function __construct ();

    function getTableName ();
    function find ($column, $key);
    function insert ($dataArray);
    function save ();

}