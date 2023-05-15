<?php

  require_once 'db.php';

  if(isset($_GET['ID'])) {

    $sql = 'DELETE FROM tbArticle WHERE Id = :id';

    $stml = $conn->prepare($sql);
    $stml->execute([
      ':id' => $_GET['ID'],
    ]);
    
  }

  header('Location: manage_articles.php')
?>