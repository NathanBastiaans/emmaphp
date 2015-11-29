<?php

/**
 * Error Controller of the EmmaPHP MVC Framework
 */
class ErrorController extends EmmaController
{

    public $errorMsg;

    public function index ($errorMsg = '')
    {

	   	$this->fourOhFour($errorMsg);

    }

    public function fourOhFour ($error = '')
    {

        $this->errorMsg = '';
        if($error) {
            if(DEBUG_MODE) {
                $this->errorMsg = $error;
            }
        }
        
        Loader::view ("fourohfour.php");
        
    }

}
