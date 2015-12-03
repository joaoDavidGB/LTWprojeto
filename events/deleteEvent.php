<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $event = deleteEvent($_POST['name']);
    if ($event === false){
      echo "failed_to_delete_event";
    }
    else if ($event === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>