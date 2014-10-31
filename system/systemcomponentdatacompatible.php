<?php

interface SystemComponentDataCompatible {

    function __construct ($data);

    public static function getInstance ($data);

}