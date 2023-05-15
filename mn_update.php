<?php

require_once 'db.php';



if(isset($_POST['edit_aut'])) {
    $sql = 'UPDATE tbAuthors SET Name = :name, Surname = :surname
        WHERE Id = :id';

    $stml = $conn->prepare($sql);
    $stml->execute([
        ':id' => $_POST['edit_aut'],
        ':name' => $_POST['eaut_name'],
        ':surname' => $_POST['eaut_surn'],
    ]);

    header('Location: manage_author.php');
    die();
}

if(isset($_POST['edit_cat'])) {
    $sql = 'UPDATE tbCategories SET Name = :name
        WHERE Id = :id';

    $stml = $conn->prepare($sql);
    $stml->execute([
        ':id' => $_POST['edit_cat'],
        ':name' => $_POST['ecat_name'],
    ]);

    header('Location: manage_category.php');
    die();
}

header('Location: index.php');
die();

?>