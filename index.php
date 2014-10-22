<?php

/*
 * EmmaPHP Model View Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v1.0.1-BETA
 */

define ("VERSION", "v1.0.1-BETA");

require_once ("config/config.php");
require_once ("config/database.php");
require_once ("system/systemcomponent.php");
require_once ("system/core.php");

require_once ("web_config.php");

$emma = Core::getInstance ();
$emma->run ();
