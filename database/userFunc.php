<?php
include_once('connection.php');

function createUser($username, $password){
	global $db;

	$stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
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

	$stmt = db->prepare('DELETE FROM users WHERE username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();

	return true;
}

  function getAllUsers() {
  	global $db;
    $stmt = $db->prepare('SELECT * FROM users');
    try{
    $stmt->execute();
	}catch(PDOException $e){
	return -1;
	}
    return $stmt->fetchAll();
  }

  function getUser($username, $pw) {
  	global $db;
  	
  	$sql = "SELECT * FROM users WHERE username = :user AND password = :pw";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    try{
    $stmt->execute();
	}catch(PDOException $e){
	return -1;
	}
    return $stmt->fetch();
 	}
  

?>