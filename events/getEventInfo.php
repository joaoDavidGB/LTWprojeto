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

  $tableCom = getCommentsFromEvent($line['name']);
  $maxCom = sizeof($tableCom);
  $line['tableCom'] = $tableCom;
  $line['maxCom'] = $maxCom;
  $line['ArrayCom'] = array();
  for($j = 0; $j < $maxCom; $j++){
    $lineCom = getLine($tableCom, $j);
    $comUser = getUsername($lineCom['idUser']);
    array_push($line['ArrayCom'], $comUser['username'], $lineCom['commentary']);
  }


  echo json_encode($line);
?>