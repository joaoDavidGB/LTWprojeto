<?
  include_once('../database/eventFunc.php'); 
  

  try {
    $event = createEvent($_POST['name'], $_POST["date"], $_POST["description"], $_POST["location"], $_POST["image"]);
    if ($event === false){
      echo "failed_to_create_event";
    }
    else if ($event === true){
      echo "success";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>