<?php
include_once('connection.php');

function createUser($username, $password){
	global $db;

	$stmt = $db->prepare('SELECT username FROM User WHERE username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();

	$result = $stmt->fetchAll();

	if (count($result) > 0) {
		return false;
	}

	$stmt = $db->prepare('INSERT INTO User(username,password) VALUES(:username, :password)');

	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);

	try{
		$stmt->execute();
	}catch(PDOException $e){
		return -1;
	}

	return true;
}

function deleteUser($username){
	global $db;

	$stmt = $db->prepare('SELECT idUser FROM User where username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();

	$result = $stmt->fetchAll();

	if (!(count($result) === 1)) {
		return false;
	}

	$idUser = $result[0]['idUser'];

	$stmt = $db->prepare('DELETE FROM AttendEvent WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('DELETE FROM Comment WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('SELECT idEvent FROM AdminEvent WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->execute();

	$result = $stmt->fetchAll();

	$stmt = $db->prepare('DELETE FROM AdminEvent WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->execute();

	foreach($result as $row) {
		$stmt = $db->prepare('DELETE FROM EventType WHERE idEvent = :idEvent');
		$stmt->bindParam(':idEvent', $row['idEvent'], PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $db->prepare('DELETE FROM Event WHERE idEvent = :idEvent');
		$stmt->bindParam(':idEvent', $row['idEvent'], PDO::PARAM_INT);
		$stmt->execute();
	}

	$stmt = $db->prepare('DELETE FROM User WHERE username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();

	return true;
}

  function getAllUsers() {
  	global $db;
    $stmt = $db->prepare('SELECT * FROM User');
    try{
    $stmt->execute();
	}catch(PDOException $e){
	return -1;
	}
    return $stmt->fetchAll();
  }

  function getUser($dbh, $username, $pw) {
  	global $db;
<<<<<<< HEAD
<<<<<<< HEAD
  	$sql = "SELECT * FROM User WHERE username = :username AND password = :pw";
=======
  	$sql = "SELECT * FROM users WHERE username = :user AND password = :pw";
>>>>>>> f3fdbea81535fb43b5fc60096ed382c08b6c9c2c
    $stmt = $dbh->prepare($sql);
=======
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = :user AND password = :pw');
>>>>>>> abf7344b44d9eab4092ed0476e40b136e54a45e6
    $stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    try{
    $stmt->execute();
	}catch(PDOException $e){
	return -1;
	}
    return $stmt->fetch();
<<<<<<< HEAD
 }
 
 function existUser($dbh, $username) {
  	global $db;
  	$sql = "SELECT * FROM User WHERE username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    try{
    $stmt->execute();
	}catch(PDOException $e){
	return -1;
	}
    return $stmt->fetch();
 }
=======
 	}
>>>>>>> f3fdbea81535fb43b5fc60096ed382c08b6c9c2c
  
function existUser($dbh, $username) {
  	global $db;
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = :user');
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    $result = $stmt->fetch();
	if (!(count($result) === 0)) {
		return false;
	}
	return true;
}
?>