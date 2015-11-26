<?php 

class CSVExport 
{

    /**
     * The array containing all the values
     * @type array
     */
	public static $values;
	
	/**
     * Strip all HTML tags in the export
     * @type bool
     */
	public static $stripHTML = true;
	
    /**
     * Filename of the exported file.
     * @type string
     */
	public static $filename = 'export.csv';
	
    /**
     * Add a row with the name of values
     * @type bool
     */	
	public static $header = true;
	
	public function __construct ( $values, $filename = 'export.csv', $header = true, $stripHTML = false )
	{
	
		self::$values    = $values;
		self::$header    = $header;
		self::$stripHTML = $stripHTML;

		self::checkFilename ( $filename );

		self::export ();
	
	}
	
	public static function checkFilename ( $filename )
	{

		if ( preg_match ( '/^[a-z0-9-_]+\.csv$/', strtolower( $filename ) ) )
		{
		
			self::$filename = strtolower( $filename );
		
		}
		else 
		{
			
			self::$filename = 'export.csv';
			
		}

	}
	
	public static function export ()
	{
	
		header ( "Cache-control: private" );
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		header ( "Content-Type: application/download" );
		
		header ( "Content-Disposition: attachment;filename=" . self::$filename );
		header ( "Content-Transfer-Encoding: binary" );
		
		ob_start ();
		
		self::$buffer = fopen ( 'php://output', 'w' );

		if ( self::$header )
		{

			foreach ( self::$values[0] as $k => $v )
			{

				echo '"' . $k . '"' . ( $k == end ( self::$values[0] ) ? '' : ';' );

			}

		}
		
		foreach ( self::$values as $row )
		{

			if ( is_object ( $row ) )
			{
				
				$row = get_object_vars ( $row );
				
			}
			
			foreach ( $row as $key => $val )
			{

				$row[$key] = html_entity_decode ( $val );
				
				if ( self::$stripHTML == true )
				{
					
					$row[$key] = strip_tags ( $row[$key] );
					
				}

			}

			fputcsv ( self::$buffer, $row, ";" );

		}

		fclose ( self::$buffer );
		
		echo ob_get_clean ();

		die ();

	}

}
