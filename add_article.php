<?php

  require_once 'db.php';
  session_start();

  if(isset($_POST['bigtitle'], $_POST['smalltitle'], $_POST['art-text'], $_POST['author'], $_POST['category'])) {

    $sql = 'INSERT INTO tbArticle (BigTitle, SmallTitle, ArticleText, Status, IdAuthor, IdCategory) VALUES (:big, :small, :arttext, 0 ,:author, :category)';
    
    $stml = $conn->prepare($sql);
    $stml->execute([
      ':big' => $_POST['bigtitle'], 
      ':small' => $_POST['smalltitle'], 
      ':arttext' => $_POST['art-text'], 
      ':author' => $_POST['author'], 
      ':category' => $_POST['category'],
    ]);

    header('Location: manage_articles.php');
  }

  $sql = 'SELECT * FROM tbAuthors';
  $stml = $conn->prepare($sql);
  $stml->execute();
  $authors = $stml->fetchAll();
// var_dump($authors);

  $sql = 'SELECT * FROM tbCategories';
  $stml = $conn->prepare($sql);
  $stml->execute();
  $category = $stml->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>New Article</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./clean-blog.css">
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@1/dist/tinymce-webcomponent.min.js"></script>

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
                        <h1>New Article</h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

               <form method="post" action="">
                    <label>
                      Title
                      <input type="text" name="bigtitle" placeholder="Title..." />
                    </label>

                    <label>
                      Subtitle
                      <input type="text" name="smalltitle" placeholder="Subtitle..." />
                    </label>

                    <label>
                      Text
                      <tinymce-editor name="art-text" api-key="no-api-key" height="500" menubar="false" plugins="a11ychecker advlist advcode advtable autolink checklist export
                      lists link image charmap preview anchor searchreplace visualblocks
                      powerpaste fullscreen formatpainter insertdatetime media table help wordcount" toolbar="undo redo | casechange blocks | bold italic backcolor |
                      alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent |
                      removeformat | a11ycheck code table help">
                        Text Editor...
                      </tinymce-editor>
                    </label>

                    <?php if(isset($_SESSION['USER'])): ?>
                      <?php if($_SESSION['USER']['Role'] === 1): ?>
                        <label>
                          Author
                          <select name="author" required>
                            <option selected disabled>Select author</option>
                            <?php foreach ($authors as $aut): ?>
                            <option value="<?= $aut['Id'] ?>"><?= $aut['Name'] . ' ' . $aut['Surname'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </label>
                      <?php endif; ?>
                    <?php else: ?>
                      <input type="hidden" name="author" value="<?= $_SESSION['USER']['Id'] ?>">
                    <?php endif; ?>

                    <label>
                      Category
                      <select name="category" required>
                        <option selected disabled>Select category</option>
                        <?php foreach ($category as $cat): ?>
                        <option value="<?= $cat['Id'] ?>"><?= $cat['Name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </label>

                    <button type="submit">Add</button>
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