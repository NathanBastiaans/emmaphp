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

    static function addExtensions ( $array )
    {

	    // Foreach extension make them lowercase
        foreach ( $array as $key )
            array_push  ( self::$allowedExtensions, strtolower ( $key ) );

    }

    static function uploadFile ( $file , $uploadDir = self::UPLOADS_DIR )
    {

	    // If no extensions were set
        if ( empty ( self::$allowedExtensions ) )
        {

            die ( "[EmmaUploader] FATAL: The allowedExtensions array is empty while running uploadFile ()." );

        }
		
		// If the given path does not end on a slash
		if ( substr ( $uploadDir , -1 ) != "/" )
		{
		
			$uploadDir.= "/";
		
		}

	    // Get the extension
        $temp = explode ( ".", $file["name"] );
        $extension = end ( $temp );

        // Check if extension is allowed
        if ( ! in_array ( strtolower ( $extension ), self::$allowedExtensions ) )
            return 0;
			
		$file["name"] = str_replace ( " ", "-", $file["name"] );
		$file["name"] = preg_replace ( '/[^A-Za-z0-9._\-]/', '', $file["name"] );

	    // Assume the location where the file is stored
        $assumedLocation = $uploadDir . $file["name"];
		
		// If the assumed location exists
		if ( file_exists ( $assumedLocation ) ) {

			// Prefix file for unique naming
			$prefix = substr (md5 (mt_rand (0, 100)), 0, 8);

			$assumedLocation = $uploadDir . $prefix . "_" . $file["name"];
		
		}
		
		// Return path to file on success, 2 on failure
		$return = move_uploaded_file
        (
            $file["tmp_name"],
            $assumedLocation
        )
            ? $assumedLocation
            : 2;
			
		if ( $return != 2 && ( $extension == "jpeg" || $extension == "jpg" ) )
		{
		
			self::image_fix_orientation( $assumedLocation );

		}

		return $return;
		
    }

	public function imageFixOrientation ( $filename )
	{
	
		$exif = exif_read_data ( $filename );
		
		if ( ! empty ( $exif['Orientation'] ) ) 
		{
		
			$image = imagecreatefromjpeg ( $filename );
			
			switch ( $exif['Orientation'] )
			{
			
				case 3:
					$image = imagerotate ( $image, 180, 0 );
					break;

				case 6:
					$image = imagerotate ( $image, -90, 0 );
					break;

				case 8:
					$image = imagerotate ( $image, 90, 0 );
					break;
					
			}

			imagejpeg ( $image, $filename, 90 );
			
		}
		
	}

}
