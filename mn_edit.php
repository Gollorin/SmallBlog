<?php
    $visual = null;
    require_once 'db.php';
    session_start();

    if(isset($_POST['aut_id'])) {
        $sql = 'SELECT * FROM tbAuthors
        WHERE Id = :id';
        
        $stml = $conn->prepare($sql);
        $stml->execute([
        ':id' => $_POST['aut_id'], 
        ]);
        $author = $stml->fetch();

        $tit = $author['Name'] . ' ' . $author['Surname'];

        $visual = true;
    }

    if(isset($_POST['cat_id'])) {
        $sql = 'SELECT * FROM tbCategories
        WHERE Id = :id';
        
        $stml = $conn->prepare($sql);
        $stml->execute([
        ':id' => $_POST['cat_id'], 
        ]);
        $category = $stml->fetch();

        $tit = $category['Name'];
        
        $visual = false;
    }

//    if(isset($_POST['edit_aut'])) {
//        $sql = 'UPDATE tbAuthors SET Name = :name, Surname = :surname
//        WHERE Id = :id';
//
//        $stml = $conn->prepare($sql);
//        $stml->execute([
//        ':id' => $_POST['edit_aut'],
//        ':name' => $_POST['eaut_name'],
//        ':surname' => $_POST['eaut_surn'],
//        ]);
//
//        header('Location: manage_author.php');
//        die();
//    }
//
//    if(isset($_POST['edit_cat'])) {
//        $sql = 'UPDATE tbAuthors SET Name = :name
//        WHERE Id = :id';
//
//        $stml = $conn->prepare($sql);
//        $stml->execute([
//        ':id' => $_POST['edit_aut'],
//        ':name' => $_POST['ecat_name'],
//        ]);
//
//        header('Location: manage_categories.php');
//        die();
//    }
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
                        <?php if($_SESSION['USER']['Role'] === 1): ?>
                        <li>
                            <a href="manage.php">Manage Articles</a>
                        </li>
                        <?php endif ?>
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
                        <h1><?= $tit ?></h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="<?= $visual ? '' : 'display: none' ?>">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

              <form action="mn_update.php" method="post">
                <input type="hidden" name="edit_aut" value="<?= $author['Id'] ?>">
                <input type="text" name="eaut_name" id="" placeholder="Name..." value="<?= $author['Name'] ?>" />
                <input type="text" name="eaut_surn" id="" placeholder="Surname..." value="<?= $author['Surname'] ?>" />
                <button type="submit">Edit</button>
              </form>

            </div>
        </div>
    </div>

    <div class="container" style="<?= $visual === false ? '' : 'display: none' ?>">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

              <form action="mn_update.php" method="post">
                <input type="hidden" name="edit_cat" value="<?= $category['Id'] ?>">
                <input type="text" name="ecat_name" id="" placeholder="Category..." value="<?= $category['Name'] ?>" />
                <button type="submit">Edit</button>
              </form>

            </div>
        </div>
    </div>

    <hr>

    <footer>
        <p class="copyright text-muted">Copyright &copy; Simon Adam 2023</p>
    </footer>
</body>

</html>