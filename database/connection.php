<?php
     $db = new PDO('sqlite:eventManager.db');
       echo 'Success';
     	$stmt = $db->prepare('SELECT * FROM users');
     	echo $stmt;
  		$stmt->execute();  
 		$result = $stmt->fetchAll();

 		/*$stmt_us = $db->prepare('SELECT * FROM users ');
  		$stmt_us->execute();  
 		$result_us = $stmt_ev->fetchAll();*/
?>