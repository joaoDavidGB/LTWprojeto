<?
  if (!isset($_POST['username'])) die('No username');
  if (!isset($_POST['pw'])) die('No password');

  include_once('../database/dbGets.php');  

  try {
     $dbh = new PDO('sqlite:../database/database.db');
     $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
     die($e->getMessage());
  }

  try {
    $user = getUser($dbh, $_POST['username'], $_POST["pw"]);
    if ($user === false) die("No such user or invalid password");
    var_dump($user);
    echo '<a href="../site.php">Homepage</a>';
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>
