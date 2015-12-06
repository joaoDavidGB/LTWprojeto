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
      session_start();
      $_SESSION['username'] = $_POST['username'];
      echo "login_true";
    }
    else{
      echo "ok";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>