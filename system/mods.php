<?php

class Mods implements ISystemComponent
{
    
    public function __construct()
    {
        
        $this->initialize ();
        
    }
    
    private function initialize ()
    {
        
        $this->loadAllMods ();
        
    }
    
    private function loadAllMods ()
    {
        
        $mod_files = scandir ("mods");
        
        for ($i = 0; $i <= 1; $i++) 
            array_splice ($mod_files, 0, 1);
        
        foreach ($mod_files as $file)
            require_once ("mods/" . $file);
        
    }

    public static function getInstance()
    {
        
        return new Mods ();
        
    }

}
