<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $event = stopAttend($_POST['name']);
    if ($event === false){
      echo "fail";
    }
    else if ($event === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>