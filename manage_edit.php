<?php

  require_once 'db.php';
  session_start();

  if(isset($_POST['id'], $_POST['bigtitle'], $_POST['smalltitle'], $_POST['art-text'], $_POST['author'], $_POST['category'], $_POST['status'])) {

    $sql = 'UPDATE tbArticle SET BigTitle = :big, SmallTitle = :small, ArticleText = :arttext, Status = :status, IdAuthor = :author, IdCategory = :category WHERE Id = :id';
    
    $stml = $conn->prepare($sql);
    $stml->execute([
      ':id' => $_POST['id'], 
      ':big' => $_POST['bigtitle'], 
      ':small' => $_POST['smalltitle'], 
      ':arttext' => $_POST['art-text'], 
      ':status' => $_POST['status'], 
      ':author' => $_POST['author'], 
      ':category' => $_POST['category'],
    ]);

    header('Location: manage_articles.php');
  } else if(isset($_GET['ID'])) {

    $sql = 'SELECT ar.Id as ARID, ar.BigTitle, ar.SmallTitle, ar.ArticleText, ar.Status, ar.IdAuthor as AUID, ar.IdCategory as CAID, ca.Name as caNAME, au.Name as auNAME, au.Surname as auSURN FROM tbArticle as ar
    INNER JOIN tbAuthors as au on au.Id = ar.IdAuthor
    INNER JOIN tbCategories as ca on ca.Id = ar.IdCategory
    WHERE ar.Id = :id';

    $stml = $conn->prepare($sql);
    $stml->execute([
      ':id' => $_GET['ID']
    ]);
    $articles = $stml->fetchAll();
    $article = $articles[0];

    $sql = 'SELECT * FROM tbAuthors';
    $stml = $conn->prepare($sql);
    $stml->execute();
    $authors = $stml->fetchAll();

    $sql = 'SELECT * FROM tbCategories';
    $stml = $conn->prepare($sql);
    $stml->execute();
    $category = $stml->fetchAll();

  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Article</title>
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
                        <h1>Edit Article</h1>
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
                    <input type="hidden" name="id" value="<?= $_GET['ID'] ?>" />

                    <label>
                      Title
                      <input value="<?= $article['BigTitle'] ?>" type="text" name="bigtitle" placeholder="Title..." />
                    </label>

                    <label>
                      Subtitle
                      <input value="<?= $article['SmallTitle'] ?>" type="text" name="smalltitle" placeholder="Subtitle..." />
                    </label>

                    <label>
                      Text
                      <tinymce-editor name="art-text" api-key="no-api-key" height="500" menubar="false" plugins="a11ychecker advlist advcode advtable autolink checklist export
                      lists link image charmap preview anchor searchreplace visualblocks
                      powerpaste fullscreen formatpainter insertdatetime media table help wordcount" toolbar="undo redo | casechange blocks | bold italic backcolor |
                      alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent |
                      removeformat | a11ycheck code table help">
                        <?= $article['ArticleText'] ?>
                      </tinymce-editor>
                    </label>

                    <label>
                      Author
                      <select name="author" required>
                        <option selected value="<?= $article['AUID'] ?>"><?= $article['auNAME'] . ' ' . $article['auSURN'] ?></option>
                        <?php foreach ($authors as $aut): ?>
                        <option value="<?= $aut['Id'] ?>"><?= $aut['Name'] . ' ' . $aut['Surname'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </label>

                    <label>
                      Category
                      <select name="category" required>
                        <option selected value="<?= $article['CAID'] ?>"><?= $article['caNAME'] ?></option>
                        <?php foreach ($category as $cat): ?>
                        <option value="<?= $cat['Id'] ?>"><?= $cat['Name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </label>

                    <label>
                      Status
                      <select name="status" required>
                        <option selected value="<?= $article['Status'] === 0 ? 0 : 1 ?>">
                          <?= $article['Status'] === 0 ? 'Hidden' : 'Online' ?>
                        </option>
                        <option value="<?= $article['Status'] === 0 ? 1 : 0 ?>">
                          <?= $article['Status'] === 0 ? 'Online' : 'Hidden' ?>
                        </option>
                      </select>
                    </label>

                    <button type="submit">Update</button>
                </form>

            </div>
        </div>
    </div>

    <hr>

    <footer>
        <p class="copyright text-muted">Copyright &copy; Simon Adam 2023</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@1/dist/tinymce-webcomponent.min.js"></script>
</body>

</html>