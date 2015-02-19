<?php

/*
 * EmmaPHP Model View Table Controller Framework.
 * @author Bob Desaunois
 * 
 * @version v1.3.0
 */

// Define version
define ("VERSION", "v1.3.0");

// Include application config
require_once ("application/config/application_config.php");

// Include core
require_once ("system/components/core.php");

// Run core
new Core ();