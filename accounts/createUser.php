<?

  if (!isset($_POST['user'])) die('No user');
  if (!isset($_POST['pw']) || trim($_POST['pw']) == '') die('password is mandatory');

  include_once('../database/userFunc.php'); 

  try {
    $user = createUser($_POST['user'], $_POST["pw"]);
    if ($user === false){
      echo "register_false";
    }
    else if ($user === true){
      echo "register_true";
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>