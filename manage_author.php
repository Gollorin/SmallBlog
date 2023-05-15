<?php
    $hlaska = false;
  require_once 'db.php';
  session_start();

    if(isset($_POST['aut_name'], $_POST['aut_surn'])) {
        $sql = 'INSERT INTO tbAuthors (Name, Surname) VALUES (:name, :surname)';
        
        $stml = $conn->prepare($sql);
        $stml->execute([
        ':name' => $_POST['aut_name'], 
        ':surname' => $_POST['aut_surn'], 
        ]);
        
        header('Location: manage_author.php');
        die();
    }

    if(isset($_POST['aut_del'])) {

        $sql = 'SELECT * FROM tbArticle
        WHERE IdAuthor = :id';

        $stml = $conn->prepare($sql);
        $stml->execute([
            ':id' => $_POST['aut_del'],
        ]);
        $authors = $stml->fetchAll();

        if(count($authors) > 0) {
            $hlaska = true;
            // chyba pri reload
            // die('Nelze smazat!');
        } else {
            $sql = 'DELETE FROM tbAuthors WHERE Id = :id';

            $stml = $conn->prepare($sql);
            $stml->execute([
                ':id' => $_POST['aut_del'],
            ]);
        
            header('Location: manage_author.php');
            die();
        }
    }

    $sql = 'SELECT * FROM tbAuthors
    ORDER BY Name';

    $stml = $conn->prepare($sql);
    $stml->execute();
    $authors = $stml->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Categories</title>
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
                        <h1>Manage Authors</h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div style="display: flex; justify-content: center; color: red">
        <h1 style="<?= $hlaska ? '' : 'display: none;' ?> ">Nejde smazat!</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

              <form action="" method="post">
                <input type="text" name="aut_name" id="" placeholder="Name...">
                <input type="text" name="aut_surn" id="" placeholder="Surname...">
                <button type="submit">Add</button>
              </form>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

                <?php foreach ($authors as $aut): ?>
                <div class="post-preview" style="display: flex; justify-content: space-between">
                        <h2 class="post-title">
                            <?= $aut['Name'] . ' ' . $aut['Surname'] ?>
                        </h2>
                        <div>
                            <form action="mn_edit.php" method="post">
                                <input type="hidden" name="aut_id" value="<?= $aut['Id']?>">
                                <button type="submit">Edit</button>
                            </form>
                            <form action="" method="post">
                                <input type="hidden" name="aut_del" value="<?= $aut['Id']?>">
                                <button type="submit">Delete</button>
                            </form>
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