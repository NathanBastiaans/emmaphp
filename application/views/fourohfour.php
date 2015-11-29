<?php
	header ("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>404</title>
    </head>
    <body>
        <h1>Four, oh four! page not found :(</h1>

    	<?php
    	if($this->errorMsg) {
    		echo '<h4>'.$this->errorMsg.'</h4>';
    	}
    	?>

    </body>
</html>
