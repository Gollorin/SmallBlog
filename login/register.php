<?php

  require_once '../db.php';
  session_start();

  if(isset($_POST['email'], $_POST['password'])) {
    $sql = 'INSERT INTO tbAuthors SET Email = :email, Password = :password, Name = :name, Surname = :surname, Role = 0';

    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stml = $conn->prepare($sql);
    $stml->execute([
      ':email' => $_POST['email'],
      ':password' => $passwordHash,
      ':name' => $_POST['name'],
      ':surname' => $_POST['surname'],
    ]);

    header('Location: login.php');
    die();
  }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <link rel="stylesheet" href="../clean-blog.css">
</head>

<body>

    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="../index.php">News</a>
                    </li>
                    <li>
                        <a href="../categories.php">Category</a>
                    </li>
                    <li>
                        <a href="../author.php">Authors</a>
                    </li>
                    <?php if(isset($_SESSION['USER'])): ?>
                        <?php if($_SESSION['USER']['Role'] === 1): ?>
                        <li>
                            <a href="../manage.php">Manage Articles</a>
                        </li>
                        <?php endif ?>
                    <?php endif ?>
                    
                    <?php if(isset($_SESSION['USER'])): ?>
                        <li>
                          <a href="../add_article.php">Add Article</a>
                        </li>
                    <?php endif ?>
                    
                    <li class="login">
                        <?php if(isset($_SESSION['USER'])): ?>
                            <a href="profile.php"><?= $_SESSION['USER']['Email'] ?></a>
                        <?php endif ?>

                        <?php if(isset($_SESSION['USER'])): ?>
                            <a href="logout.php">Logout</a>
                        <?php else: ?>
                            <a href="login.php">Register / Login</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="intro-header" style="background-image: url('../img/home-bg.jpg')">
      <div class="site-heading">
          <h1>Register</h1>
          <hr class="small">
      </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

              <form action="" method="post">

                <div class="form-name">
                  <label>
                    Name
                    <input type="text" name="name" placeholder="Name..." required>        
                  </label>

                  <label>
                    Surname
                    <input type="text" name="surname" placeholder="Surname..." required>        
                  </label>
                </div>

                <label>
                    Email
                    <input type="email" name="email" placeholder="Email..." required>        
                </label>

                <label>
                  Password
                  <input type="password" name="password" placeholder="Password..." required>        
                </label>

                <a href="login.php">I have account!!!</a>

                <button type="submit">Register</button>
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