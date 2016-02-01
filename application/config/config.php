<?php

/****************************************************
 *            Application Configuration             *
 ****************************************************/
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



/****************************************************
 *                    Database                      *
 ****************************************************/
// Database Switch
define ("DB", false);

// Database Details
define ("DB_HOST",     "");
define ("DB_NAME",     "");
define ("DB_USERNAME", "");
define ("DB_PASSWORD", "");



/****************************************************
 *                    Autoloader                    *
 ****************************************************/
AutoLoader::$autoloadModels = array ();



/****************************************************
 *                    Constants                     *
 ****************************************************/
define ("TITLE",    "EmmaPHP Framework");
define ("BASEPATH", "http://localhost/emmaphp/");
define ("APPPATH", BASEPATH . "application/");

//DEFINE ANY CONSTANTS BELOW