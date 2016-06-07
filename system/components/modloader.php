<?php

class ModLoader implements ISystemComponent
{
    
    public function __construct()
    {
        
        $this->loadAllMods ();
        
    }
    
    private function loadAllMods ()
    {
        
        $modFiles = glob ("system/mods/*.php");

        foreach ($modFiles as $file)
            require_once ($file);
        
    }

    public static function getInstance()
    {
        
        return new self ();
        
    }

}
