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
            
    	$this->load->view ("templates/header.php");
    	$this->load->view ("pages/" . $page . ".php");
    	$this->load->view ("templates/footer.php");
        
    }

}