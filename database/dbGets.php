<?php

  function getAllUsers($dbh) {
    $stmt = $dbh->prepare('SELECT * FROM users');
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getUser($dbh, $username, $pw) {
    $stmt = $dbh->prepare('SELECT * FROM users WHERE username = :user AND password = :pw');
    $stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }
  
  function updatePost($dbh, $id, $title, $introduction, $fulltext) {
    $stmt = $dbh->prepare('UPDATE post SET title = ?, introduction = ?,  fulltext = ? WHERE id = ?');
    $stmt->execute(array($title, $introduction, $fulltext, $id));
  }

?>
