<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $event = addComment($_POST['eventName'], $_POST['comment']);
    if ($event === false){
      echo "failed_to_add_comment";
    }
    else if ($event === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>