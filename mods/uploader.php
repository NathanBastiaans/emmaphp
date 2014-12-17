<?php

/**
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 *
 * Returns 0 when extension isn't supported
 * Returns a String with the location of the uploaded file when successfully uploaded
 * Returns 2 when couldn't upload for any other reason
 */

class EmmaUploader
{

    const UPLOADS_DIR = "assets/uploads/";
    static $allowedExtensions = array ();

    static function addExtensions ($array)
    {

        // Foreach extension add it to the extension array
        foreach ($array as $key)
            array_push  (self::$allowedExtensions, strtolower ($key));

    }

    static function uploadFile ($file)
    {

        // If no extensions supplied
        if (empty (self::$allowedExtensions))
            die ("[EmmaUploader] FATAL: The allowedExtensions array is empty while running uploadFile ().");


        // Get the extension
        $temp = explode(".", $file["name"]);
        $extension = end($temp);

        // Check if extension is allowed
        if ( ! in_array (strtolower ($extension), self::$allowedExtensions))
            return 0;

        $file["name"] = str_replace(" ", "-", $file["name"]);
		$file["name"] = preg_replace('/[^A-Za-z0-9._\-]/', '', $file["name"]); 

        $assumedLocation = self::UPLOADS_DIR . $file["name"];
		
		if( file_exists($assumedLocation) ) {

			// Prefix file for unique naming
			$prefix = substr (md5 (mt_rand (0, 100)), 0, 8);

			$assumedLocation = self::UPLOADS_DIR . $prefix . "_" . $file["name"];
		
		}

        // Return location of the file on success, 2 on failure
        return move_uploaded_file
        (
            $file["tmp_name"],
            $assumedLocation
        )
            ? $assumedLocation
            : 2;

    }
    
}
