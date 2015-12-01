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
		$path = '../database/database.db';
	}
	try{
	  $db = new PDO('sqlite:' . $path);
	}catch(PDOException $e){
		echo 'Unable to read from database';
	}
	
?>