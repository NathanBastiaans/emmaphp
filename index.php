<?php

/*
 * EmmaPHP Model View Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v1.1.1-ALPHA
 */

define ("VERSION", "v1.1.1-ALPHA");

require_once ("config/config.php");
require_once ("config/database.php");
require_once ("system/systemcomponent.php");
require_once ("system/core.php");

require_once ("web_config.php");

$emma = Core::getInstance ();
$emma->run ();
