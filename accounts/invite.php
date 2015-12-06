<?
  include_once('../database/userFunc.php'); 
  include_once('../database/eventFunc.php'); 
  
  $name = $_POST['name'];
  $evento = $_POST['evento']; 

  $idEvent = getEventId($evento);
  if (!existUser($name)){
    echo "user_not_exist";
    return false;
  }
  $idUser = getUserID($name);

  try {
    $invite = invite($idUser, $idEvent);
    if ($invite === false){
      echo "fail";
    }
    else if ($invite === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>