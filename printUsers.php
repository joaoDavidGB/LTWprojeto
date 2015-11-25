<?php

  include_once("database/connection.php");

  $stmt = $db->prepare('SELECT * FROM users');
  $stmt->execute();  
  $result = $stmt->fetchAll();
  print_r($result);
  echo '<a href="site.php">Homepage</a>';
?>