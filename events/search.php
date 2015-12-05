<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $exist = existEvent($_POST['name']);
    if ($exist === false){
      echo "fail";
    }
    else if ($exist === true){
      $idEvent = getEventId($_POST['name']);
      if ($idEvent == -1){
        echo "fail";
      }
      else
        echo $idEvent;
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>