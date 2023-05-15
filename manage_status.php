<?php

  require_once 'db.php';

  if(isset($_GET['ID'])) {

    $sql = 'UPDATE tbArticle SET Status = 1 WHERE Id = :id';

    $stml = $conn->prepare($sql);
    $stml->execute([
      ':id' => $_GET['ID'],
    ]);
    
  }

  header('Location: manage_articles.php')
?>