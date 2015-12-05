<?
  if (!isset($_POST['id'])) die('No id');
	
  include_once('../database/eventFunc.php'); 
  session_start();
    
  //recebe todas as informções do evento presentes na table Event
  $table = getAllEvents();
  $line = getEventfromID($_POST['id']);
  

  //verifica quem é o admin do evento.
  $line['host'] = getEventAdmin($line['name'])['username'];
  if ($line['host'] == $_SESSION['username']){
  	$line['host'] = "Delete Event";
  }
  else{
  	$line['host'] = "host: ".$line['host'];
  }

  //inclui todos os comentários em $line['ArrayCom']
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

  $line['type'] = getEventType($line['name']);
  $line['attend'] = Attend($line['name']);
  $line['people'] = getUsersAttendingEvent($line['name']);
  $line['Npeople'] = count($line['people']);


  echo json_encode($line);
?>