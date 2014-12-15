<?php

/**
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 *
 * Returns 0 when extension isn't supported
 * Returns 1 when successfully uploaded
 * Returns 2 when couldn't upload for any other reason
 */

class EmmaUploader
{

    const UPLOADS_DIR = "assets/uploads/";
    static $allowedExtensions = array ();

    static function addExtensions ($array)
    {

        foreach ($array as $key)
            array_push  (self::$allowedExtensions, strtolower ($key));

    }

    static function uploadFile ($file)
    {

        if (empty (self::$allowedExtensions))
        {

            die ("[EmmaUploader] FATAL: The allowedExtensions array is empty while running uploadFile ().");

        }

        $temp = explode(".", $file["name"]);
        $extension = end($temp);

        // Check if extension is allowed
        if ( ! in_array (strtolower ($extension), self::$allowedExtensions))
            return 0;

        // Prefix file for unique naming
        $prefix = substr (md5 (mt_rand (0, 100)), 0, 8);

        // Return 1 on success, 2 on failure
        return move_uploaded_file
        (
            $file["tmp_name"],
            self::UPLOADS_DIR . $prefix . "_" . $file["name"]
        )
            ? 1
            : 2;

    }
    
}
