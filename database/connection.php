<?php

	$path =	'database/database.db';
	if (!(file_exists($path))) {
		$path = 'database.db';
	}
	if (!(file_exists($path))) {
		$path = 'events/database.db';
	}
	if (!(file_exists($path))) {
		$path = 'accounts/database.db';
	}
	if (!(file_exists($path))) {
		$path = 'PHP/database.db';
	}
	if (!(file_exists($path))) {
		$path = 'CSS/database.db';
	}
	if (!(file_exists($path))) {
		$path = 'images/database.db';
	}
	try{
	  $db = new PDO('sqlite:' . $path);
	}catch(PDOException $e){
		echo 'Unable to read from database';
	}
	
?>