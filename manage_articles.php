<?php

  require_once 'db.php';
  session_start();

  if(isset($_SESSION['USER'])) {
    if($_SESSION['USER']['Role'] === 0) {



        $sql = 'SELECT ar.Id as ARID, ar.BigTitle, ar.SmallTitle, ar.Status, ar.CreateAt, au.Id as AUID, au.Name, au.Surname FROM tbArticle as ar
        INNER JOIN tbAuthors as au on au.Id = ar.IdAuthor
        WHERE au.Id = :id
        ORDER BY BigTitle';

        $stml = $conn->prepare($sql);
        $stml->execute([
            ':id' => $_SESSION['USER']['Id'],
        ]);
        $articles = $stml->fetchAll();



        
    } else {



        $sql = 'SELECT ar.Id as ARID, ar.BigTitle, ar.SmallTitle, ar.Status, ar.CreateAt, au.Id as AUID, au.Name, au.Surname FROM tbArticle as ar
        INNER JOIN tbAuthors as au on au.Id = ar.IdAuthor
        ORDER BY BigTitle';

        $stml = $conn->prepare($sql);
        $stml->execute();
        $articles = $stml->fetchAll();

    }
  } else {
    header('Location: index.php');
    die();
  }
                   
  
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Articles</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./clean-blog.css">
</head>

<body>

    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">News</a>
                    </li>
                    <li>
                        <a href="categories.php">Category</a>
                    </li>
                    <li>
                        <a href="author.php">Authors</a>
                    </li>
                    <?php if(isset($_SESSION['USER'])): ?>
                        <li>
                            <a href="manage.php">Manage Articles</a>
                        </li>
                    <?php endif ?>

                    <?php if(isset($_SESSION['USER'])): ?>
                        <li>
                          <a href="add_article.php">Add Article</a>
                        </li>
                    <?php endif ?>

                    <li class="login">
                        <?php if(isset($_SESSION['USER'])): ?>
                            <a href="login/profile.php"><?= $_SESSION['USER']['Email'] ?></a>
                        <?php endif ?>

                        <?php if(isset($_SESSION['USER'])): ?>
                            <a href="./login/logout.php">Logout</a>
                        <?php else: ?>
                            <a href="./login/login.php">Register / Login</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Manage Articles</h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

                <?php foreach ($articles as $art): ?>
                <div class="post-preview">

                    <a href="article.php?ID=<?= $art['ARID'] ?>">
                        <h2 class="post-title">
                            <?= $art['BigTitle'] ?>
                        </h2>
                        <h3 class="post-subtitle">
                            <?= $art['SmallTitle'] ?>
                        </h3>
                    </a>

                    <p class="post-meta">Posted by <a href="author.php?Author=<?= $art['AUID'] ?>"><?= $art['Name'] . ' ' . $art['Surname'] ?></a> on <?= $art['CreateAt'] ?></p>

                    <p class="post-meta"><?= $art['Status'] === 0 ? 'Hidden' : 'Online' ?></p>
                     
                    <div class="action-cont">
                      <a class="myBtn" href="manage_edit.php?ID=<?= $art['ARID'] ?>">Edit</a>
                      <a class="myBtn" href="manage_delete.php?ID=<?= $art['ARID'] ?>">Delete</a>
                      <a class="myBtn" href="manage_status.php?ID=<?= $art['ARID'] ?>">Publish</a>
                    </div>
                </div>
                <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <hr>

    <footer>
        <p class="copyright text-muted">Copyright &copy; Simon Adam 2023</p>
    </footer>
</body>

</html>