<?
  include_once('../database/eventFunc.php'); 
  
  $evento = $_POST['antigoTitulo']; 

  $idEvent = getEventId($evento);
  echo $idEvent;
?>