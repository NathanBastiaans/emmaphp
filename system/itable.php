<?php

interface ITable
{

    function __construct ();

    function getTableName ();
    function find ();
    function insert ();
    function save ();

}