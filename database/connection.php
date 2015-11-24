<?php

  $db = new PDO('sqlite:database.db');

  echo 'SUCESS BITCH';
  $stmt = $db->prepare('SELECT * FROM users');
  $stmt->execute();  
  $result = $stmt->fetchAll();
  print_r($result);
?>