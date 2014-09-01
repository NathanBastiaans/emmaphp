<?php

/*
 * EmmaPHP Model View Controller Framework.
 * @author Bob Desaunois
 * 
 * @version 1.1.0
 */

require_once("config/config.php");
require_once("config/database.php");
require_once("system/core.php");

require_once("web_config.php");

$emma = new Core();
$emma->run();