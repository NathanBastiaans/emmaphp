<?php

class ModLoader implements ISystemComponent
{
    
    public function __construct()
    {
        
        $this->loadAllMods ();
        
    }
    
    private function loadAllMods ()
    {
        
        $mod_files = scandir ("system/mods");
        
        for ($i = 0; $i <= 1; $i++) 
            array_splice ($mod_files, 0, 1);
        
        foreach ($mod_files as $file)
            require_once ("system/mods/" . $file);
        
    }

    public static function getInstance()
    {
        
        return new self ();
        
    }

}
