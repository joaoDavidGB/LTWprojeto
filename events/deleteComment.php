<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $c = deleteComment($_POST['id']);
    if ($c === false){
      echo "fail";
    }
    else if ($c === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>