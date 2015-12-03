<?
  if (!isset($_POST['id'])) die('No id');
	
  include_once('../database/eventFunc.php'); 
  session_start();
  
  $table = getAllEvents();
  $line = getLine($table, $_POST['id']);
  $line['host'] = getEventAdmin($line['name'])['username'];
  if ($line['host'] == $_SESSION['username']){
  	$line['host'] = "Delete Event";
  }
  else{
  	$line['host'] = "host: ".$line['host'];
  }
  echo json_encode($line);
?>