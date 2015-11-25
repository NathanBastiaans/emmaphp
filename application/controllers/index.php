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

    public function page2 ($id)
    {

        echo 'ID: #'.$id;

        // Routing by state
        #Router::goToState('home');

    }
    
    public function page ($page = "welcome")
    {
            
    	Loader::view ("templates/header.php");
    	Loader::view ("index/" . $page . ".php");
    	Loader::view ("templates/footer.php");
        
    }

}
