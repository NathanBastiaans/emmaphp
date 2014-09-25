<?php

/*
 * EmmaPHP Model View Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v1.0.0-ALPHA
 */

require_once ("config/config.php");
require_once ("config/database.php");
require_once ("system/core.php");

require_once ("web_config.php");

$emma = new Core ();
$emma->run ();