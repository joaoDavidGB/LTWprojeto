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

	$stmt = $db->prepare('SELECT * FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result) > 0) {
		return false;
	}

	$stmt = db->prepare('DELETE FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	
	$stmt->execute();
	
	return true;
?>