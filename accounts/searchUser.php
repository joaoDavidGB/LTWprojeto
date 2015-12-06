<?
  include_once('../database/userFunc.php'); 
  
  $oldname = $_POST['antigoNome'];
  $username = $_POST['username'];
  $pw = $_POST['pw'];
  $npw = $_POST['npw'];
  $npw2 = $_POST['npw2'];



  try {
    if ($oldname != $username){
      $user = existUser($username);
      if ($user === true){
        echo "username_in_use";
      }
      else{
        if (getUser($oldname, $pw)){
          $user = editUser($oldname, $username, $pw);
          echo "name_changed";
          session_start();
          $_SESSION['username'] = $username;
        }
        else{
          echo "wrong_password";
        }
      }
    }
    else if ($pw == "" || $npw == "" ||$npw2 == ""){
      echo "fill_all_pw";
    }
    else if ($npw != $npw2){
      echo "passwords_not_match";
    }
    else{
      $user = getUser($oldname, $pw);
      if(!$user)
        echo "wrong_password";
      else{
        $user = editUser($oldname, $oldname, $npw);
        echo 'password_changed';
      }
    }



  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>