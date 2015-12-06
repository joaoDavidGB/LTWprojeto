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

	$password = generateHash($password);

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

function editUser($oldname, $username, $password){
	global $db;
	$password = generateHash($password);
	$stmt = $db->prepare('UPDATE User SET username = :username, password = :password WHERE username = :name');
	$stmt->bindParam(':name', $oldname, PDO::PARAM_STR);
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();

	return $stmt;

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

  function getUser($username, $pw) {
  	global $db;


    $stmt = $db->prepare('SELECT password FROM User WHERE username = :user');
    
	$stmt->bindParam(':user', $username, PDO::PARAM_STR);
	$stmt->execute();

	$result = $stmt->fetchAll();
	if (!(count($result) === 1)) {
		return false;
	}

	if(!(verify($pw,$result[0]['password'])))
		return false;

	return true;
 }
 
function existUser($username) {
  	global $db;
    $stmt = $db->prepare('SELECT * FROM User WHERE username = :user');
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
	$stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ((count($result) === 0)) {
		return false;
	}
	return true;
}

function generateHash($password) {
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($password, $salt);
    }
}

function verify($password, $hashedPassword) {
    return crypt($password, $hashedPassword) == $hashedPassword;
}



?>