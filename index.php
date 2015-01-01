<?php

/*
 * EmmaPHP Model View Table Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v1.0.0
 */

// Define version
define ("VERSION", "v1.0.0");

// Include application config
require_once ("config/application_config.php");

// Include core
require_once ("system/core.php");

// Run core
$emma = Core::getInstance ();
$emma->run ();