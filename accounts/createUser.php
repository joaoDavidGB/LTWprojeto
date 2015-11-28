<?

  if (!isset($_POST['user'])) die('No user');
  if (!isset($_POST['pw']) || trim($_POST['pw']) == '') die('password is mandatory');

  try {
     $dbh = new PDO('sqlite:../database/database.db');
     $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
     die($e->getMessage());
  }

  try {
    $stmt = $dbh->prepare('INSERT INTO users(username, password) VALUES(:username, :pw)');
    $stmt->bindParam(':username', $_POST['user'], PDO::PARAM_STR);
    $stmt->bindParam(':pw', $_POST['pw'], PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  echo 'Username: '.$_POST['user'].' / pass: '.$_POST['pw'].'<br>';

?>