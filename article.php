<?php

  require_once 'db.php';
  session_start();

  if(isset($_GET['ID']))

  $sql = 'SELECT ar.BigTitle, ar.SmallTitle, ar.ArticleText, ar.CreateAt, ar.Status, au.Id as AUID, au.Name as auNAME, au.Surname as auSURN, ca.Id as CAID, ca.Name as caNAME FROM tbArticle as ar
  INNER JOIN tbAuthors as au on au.Id = ar.IdAuthor
  INNER JOIN tbCategories as ca on ca.Id = ar.IdCategory
  WHERE ar.Id = :id';

  $stml = $conn->prepare($sql);
  $stml->execute([
    ':id' => $_GET['ID'],
  ]);
  $article = $stml->fetch();

  if(!$article) {
    header('location: index.php');
    die();
  }

  if($article['Status'] === 0) {
    header('location: index.php');
    die();
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PHP News</title>
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
                        <h1 id="titlos"><?= $article['BigTitle'] ?></h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

              <p class="post-meta">Posted by <a href="author.php?Author=<?= $article['AUID'] ?>"><?= $article['auNAME'] . ' ' . $article['auSURN'] ?></a> on <?= $article['CreateAt'] ?></p>

              <p class="post-meta">Category <a href="categories.php?Category=<?= $article['CAID'] ?>"><?= $article['caNAME'] ?></a></p>

              <div class="post-preview">
                  <h3 class="post-subtitle">
                      <?= $article['SmallTitle'] ?>
                  </h3>
                  <article>
                      <?= $article['ArticleText'] ?>
                  </article>
              </div>
              <hr>

            </div>
        </div>
    </div>

    <hr>

    <footer>
        <p class="copyright text-muted">Copyright &copy; Simon Adam 2023</p>
    </footer>
</body>

</html>