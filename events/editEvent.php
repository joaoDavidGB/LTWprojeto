<?
  include_once('../database/eventFunc.php'); 
  
  $antigoNome = $_POST['antigoNome'];
  $name = $_POST['name'];
  $date = $_POST['date'];
  $timeH = $_POST['timeH'];
  $type = $_POST['type'];
  $local = $_POST['local'];
  $description = $_POST['description'];
  $image = $_POST['image'];

  $idEvent = getEventId($antigoNome);

  try {
    $event = editEvent($idEvent,$name, $date, $timeH, $type, $description, $local, $image);
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