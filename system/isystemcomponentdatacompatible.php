<?php

interface ISystemComponentDataCompatible
{

    function __construct ($data);

    public static function getInstance ($data);

}