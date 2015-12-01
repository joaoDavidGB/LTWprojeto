<?
  if (!isset($_POST['username'])) die('No username');
  if (!isset($_POST['pw'])) die('No password');
	
  include_once('../database/userFunc.php'); 
  

  try {
    $user = getUser($_POST['username'], $_POST["pw"]);
    if ($user === false){
      echo "login_false";
    }
    else if ($user === true){
      echo "login_true";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>