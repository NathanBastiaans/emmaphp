<?php

interface ITable
{

    function constructor ();

    function getTableName ();
    function find ($column, $key);
    function insert ($dataArray);
    function save ();

}