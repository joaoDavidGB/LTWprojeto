<?
  include_once('../database/userFunc.php'); 
  
  $username = $_POST['username'];
  $pw = $_POST['pw'];
  $pw2 = $_POST['pw2'];



  try {
    $user = getUser($username, $pw);
    if(!$user){
      echo 'wrong_password';
    }
    else{
      deleteUser($username);
      echo 'RIP';
    }



  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>