<?php

define("DEBUG_MODE", true);
define("DEFAULT_CONTROLLER", "welcome");

//Debug mode
if(DEBUG_MODE)
    ini_set("display_errors", "on");
else
    ini_set("display_errors", "off");

//Session
if(!isset($_SESSION))
    session_start();