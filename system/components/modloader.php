<?php

class ModLoader implements ISystemComponent
{
    
    public function __construct()
    {
        
        $this->loadAllMods ();
        
    }
    
    private function loadAllMods ()
    {
        
        $modFiles = scandir ("system/mods");
        
        for ($i = 0; $i <= 1; $i++) 
            array_splice ($modFiles, 0, 1);
        
        foreach ($modFiles as $file)
            require_once ("system/mods/" . $file);
        
    }

    public static function getInstance()
    {
        
        return new self ();
        
    }

}
