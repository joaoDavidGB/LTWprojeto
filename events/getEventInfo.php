<?
  if (!isset($_POST['id'])) die('No id');
	
  include_once('../database/eventFunc.php'); 
  
  $table = getAllEvents();
  $line = getLine($table, $_POST['id']);
  echo json_encode($line);
?>