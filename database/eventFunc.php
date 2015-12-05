<?php
include_once('connection.php');

function createEvent($name, $dateBegin, $time, $type, $description, $location, $image){
	global $db;
	session_start();

	$stmt = $db->prepare('SELECT * FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($result) > 0) {
		return false;
	}

	$stmt = $db->prepare('INSERT INTO Event(name,dateBegin,time,description, location, image)
						values(:name, :dateBegin, :time, :description, :location, :image)');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':dateBegin', $dateBegin, PDO::PARAM_STR);
	$stmt->bindParam(':time', $time, PDO::PARAM_STR);
	$stmt->bindParam(':description', $description, PDO::PARAM_STR);
	$stmt->bindParam(':location', $location, PDO::PARAM_STR);
	$stmt->bindParam(':image', $image, PDO::PARAM_STR);

	$stmt->execute();

	$stmt = $db->prepare('SELECT * FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();
	$idEvent = $idEvent['idEvent'];

	$stmt = $db->prepare('SELECT * FROM User where username = :username');
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->execute();
	$idUser = $stmt->fetch();
	$idUser = $idUser['idUser'];
	
	$stmt = $db->prepare('INSERT INTO EventType(idEvent,type) VALUES (:idEvent,:type)');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->bindParam(':type', $type, PDO::PARAM_STR);
	$stmt->execute();

	$stmt = $db->prepare('INSERT INTO AdminEvent(idUser,idEvent) VALUES (:idUser,:idEvent)');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('INSERT INTO AttendEvent(idUser,idEvent) VALUES (:idUser,:idEvent)');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	return true;
}


function deleteEvent($name){
	global $db;

	$stmt = $db->prepare('SELECT idEvent FROM Event where name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();

	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!(count($result) === 1)) {
		return false;
	}

	$idEvent = $result[0]['idEvent'];



	$stmt = $db->prepare('DELETE FROM AttendEvent WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('DELETE FROM Comment WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('DELETE FROM AdminEvent WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	
	$stmt = $db->prepare('DELETE FROM EventType WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $db->prepare('DELETE FROM Event WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent',$idEvent, PDO::PARAM_INT);
	$stmt->execute();
	

	return true;
}

function getAllEvents(){
	global $db;

	$stmt = $db->prepare('SELECT * FROM Event');
    $stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getLine($table, $id){
	return $table[$id];
}

function existEvent($name) {
  	global $db;
    $stmt = $db->prepare('SELECT * FROM Event WHERE name = :name');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

	if ((count($result) === 0)) {
		return false;
	}
	return true;
}

function getCommentsFromEvent($name){
	global $db;

	if(!(existEvent($name))){
		return -1;
	}

	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch();
	$idEvent = $result['idEvent'];

	$stmt = $db->prepare('SELECT * FROM Comment WHERE idEvent = :id');
	$stmt->bindParam(':id', $idEvent, PDO::PARAM_INT);
    $stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getEventAdmin($name){
	global $db;

	if(!(existEvent($name)))
		return -1;

	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch();
	$result = $result['idEvent'];

	$stmt = $db->prepare('SELECT idUser FROM AdminEvent WHERE idEvent = :id');
	$stmt->bindParam(':id', $result, PDO::PARAM_INT);
    $stmt->execute();
	$result = $stmt->fetch();
	$result = $result['idUser'];

	$stmt = $db->prepare('SELECT * FROM User WHERE idUser = :id');
	$stmt->bindParam(':id', $result, PDO::PARAM_INT);
    $stmt->execute();
	return $stmt->fetch();
}

function getCommentUser($idComment){
	global $db;

	$stmt = $db->prepare('SELECT idUser FROM Comment WHERE idComment = :idComment');
	$stmt->bindParam(':idComment', $idComment, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetch();

	if(!(count($result)===1))
		return false;

	$stmt = $db->prepare('SELECT * FROM User WHERE idUser = :id');
	$stmt->bindParam(':id', $result, PDO::PARAM_INT);
    $stmt->execute();
	return $stmt->fetch();
}


function getUsersAttendingEvent($name){
	global $db;

	if(!(existEvent($name)))
		return -1;


	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch();

	$stmt = $db->prepare('SELECT User.* FROM AttendEvent,User WHERE idEvent = :id,User.idUser=AttendEvent.idUser');
	$stmt->bindParam(':id', $result, PDO::PARAM_INT);
    $stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(count($result)<1)
		return false;

	return $result;
}

function getEventsAttendedByUser($username){
	global $db;


	$stmt = $db->prepare('SELECT idUser FROM User WHERE username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(!(count($result)===1))
		return false;

	$idUser = $result[0]['idUser'];

	$stmt = $db->prepare('SELECT Event.* FROM AttendEvent, Event WHERE idUser = :id');
	$stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
	$stmt->execute();
	return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function willAttend($name){
	global $db;


	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();

	if(!(count($result))===1){
		return false;
	}



	$stmt = $db->prepare('SELECT idUser FROM User where username = :username');
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->execute();
	$idUser = $stmt->fetch();

	$stmt = $db->prepare('INSERT INTO AttendEvent(idUser,idEvent) VALUES (:idUser,:idEvent)');
	$stmt->bindParam(':idUser', idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

return true;
}


function stopAttend($name){
	global $db;


	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();

	if(!(count($result))===1){
		return false;
	}


	$stmt = $db->prepare('SELECT idUser FROM User where username = :username');
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->execute();
	$idUser = $stmt->fetch();


	$stmt = $db->prepare('DELETE * FROM AttendEvent WHERE idEvent = :idEvent AND idUser = :idUser');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();

return true;
}

function addComment($name, $commentary){
	global $db;

	$stmt = $db->prepare('SELECT * FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();
	$idEvent = $idEvent['idEvent'];
	if($idEvent == null)
		return false;

	session_start();
	$stmt = $db->prepare('SELECT * FROM User where username = :username');
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->execute();
	$idUser = $stmt->fetch();
	$idUser = $idUser['idUser'];
	if($idUser == null)
		return false;

	$stmt = $db->prepare('INSERT INTO Comment(idUser,idEvent, commentary) VALUES (:idUser,:idEvent,:commentary)');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->bindParam(':commentary', $commentary, PDO::PARAM_STR);

	$stmt->execute();
	if(!$stmt){
		return false;
	}

	return true;
}

function deleteComment($name, $idComment){

	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();

	if(!(count($result))===1){
		return false;
	}

	$stmt = $db->prepare('SELECT idUser FROM User where username = :username');
	$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
	$stmt->execute();
	$idUser = $stmt->fetch();

	$stmt = $db->prepare('DELETE FROM Comment WHERE idEvent = :idEvent AND idUser = :idUser AND idComment = :idComment');
	$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->bindParam(':idComment', $idComment, PDO::PARAM_INT);
	$stmt->execute();
}


function getUsername($idUser){
	global $db;
    $stmt = $db->prepare('SELECT username FROM User WHERE idUser = :idUser');
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
	$stmt->execute();
    return $stmt->fetch();
}


function getEventType($name){
	global $db;

	$stmt = $db->prepare('SELECT idEvent FROM Event WHERE name = :name');
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$idEvent = $stmt->fetch();

	if(!(count($idEvent))===1){
		return false;
	}

	$stmt = $db->prepare('SELECT type FROM EventType WHERE idEvent = :idEvent');
	$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
	$stmt->execute();
    $result = $stmt->fetch();
    return $result['type'];

}

?>