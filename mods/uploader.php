<?php

//define ("UPLOADS_DIR", BASEPATH . "/assets/uploads");

class Uploader {
    
    
    static function uploadFile ($file) {
        
        $file_name = $file["tmp_name"];
        
        die (var_dump ($file_name));
        
    }
    
}