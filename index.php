<?php

/*
 * EmmaPHP Model View Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v2.0.1-BETA
 */

define ("VERSION", "v2.0.1-BETA");

require_once ("config/config.php");
require_once ("config/application_config.php");
require_once ("config/database.php");

require_once ("system/isystemcomponent.php");
require_once ("system/isystemcomponentdatacompatible.php");
require_once ("system/core.php");


$emma = Core::getInstance ();
$emma->run ();
