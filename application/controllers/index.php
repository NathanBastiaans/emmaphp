<?php

/**
 * Default Controller of the EmmaPHP MVC Framework
 */
class IndexController extends EmmaController
{

    public function index ()
    {
    	
	   	$this->page ();

    }
    
    public function welcome ($page = "welcome")
    {
            
    	Loader::view ("templates/header.php");
    	Loader::view ("pages/" . $page . ".php");
    	Loader::view ("templates/footer.php");
        
    }

}
