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
    
    public function page ($page = "welcome")
    {
            
    	Loader::view ("templates/header.php");
    	Loader::view ("index/" . $page . ".php");
    	Loader::view ("templates/footer.php");
        
    }

}
