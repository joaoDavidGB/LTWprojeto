<?php
include_once('connection.php');

function createEvent($name, $dateBegin ,$description, $location, $image){
	global $db;

	$stmt = $db->prepare('SELECT * FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result) > 0) {
		return false;
	}

	$stmt = $db->prepare('INSERT INTO Event(name,dateBegin,description, location, image)
						values(:name, :dateBegin, :description, :location, :image)');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':dateBegin', $dateBegin, PDO::PARAM_STR);
	$stmt->bindParam(':description', $description, PDO::PARAM_STR);
	$stmt->bindParam(':location', $location, PDO::PARAM_STR);
	$stmt->bindParam(':image', $image, PDO::PARAM_STR);

	$stmt->execute();

	return true;
}


function deleteEvent($name){
	global $db;

	$stmt = $db->prepare('SELECT idEvent FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();

	$result = $stmt->fetchAll();

	if (!(count($result) === 1)) {
		return false;
	}

	$idEvent = $result[0]['idEvent'];

	$stmt = $db->prepare('DELETE FROM AttendEvent WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('DELETE FROM Comment WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('SELECT idEvent FROM AdminEvent WHERE idEvent = :idEvent');
	$stmt->bindParam(':idUser', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$result = $stmt->fetchAll();

	$stmt = $db->prepare('DELETE FROM AdminEvent WHERE idUser = :idUser');
	$stmt->bindParam(':idUser', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	foreach($result as $row) {
		$stmt = $db->prepare('DELETE FROM EventType WHERE idEvent = :idEvent');
		$stmt->bindParam(':idEvent', $row['idEvent'], PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $db->prepare('DELETE FROM Event WHERE idEvent = :idEvent');
		$stmt->bindParam(':idEvent', $row['idEvent'], PDO::PARAM_INT);
		$stmt->execute();
	}

	return true;
}

function getAllEvents(){
	global $db;

	$stmt = $db->prepare('SELECT * FROM Event');
    $stmt->execute();
	return $stmt->fetchAll();
}


function getLine($table, $id){
	return $table[$id];
}
?>