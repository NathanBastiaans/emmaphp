<?php

//define ("UPLOADS_DIR", BASEPATH . "/assets/uploads");

//This mod is a work in progress.

class Uploader {
    
    
    static function uploadFile ($file) {
        
        $file_name = $file["tmp_name"];
        
        die (var_dump ($file_name));
        
    }
    
}
