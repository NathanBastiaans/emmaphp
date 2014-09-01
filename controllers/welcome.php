<?php

/**
 * Default Controller of the EmmaPHP MVC Framework
 */
class Welcome_controller extends Emma_Controller {
    
    function __construct() {
        
        parent::__construct();
        
    }
    
    public function index() {
        
        $this->page();
        
    }
    
    public function page($page = "welcome") {
        
        if(!file_exists("views/pages/" . $page . ".php")) {
            
            $this->show_404();
            
        } else {
            
            $this->load->view("pages/" . $page . ".php");
            
        }
        
    }
    
}