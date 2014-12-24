<?php

// Set debug mode
define ("DEBUG_MODE", true);

// Set the default controller
define ("DEFAULT_CONTROLLER", "index");

// Debug mode
if (DEBUG_MODE)
    ini_set ("display_errors", "on");
else
    ini_set ("display_errors", "off");

//Session
if ( ! isset ($_SESSION))
    session_start ();