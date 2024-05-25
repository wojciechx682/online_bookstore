<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
    require_once "../authenticate-admin.php";

    $categoryId = filter_var($_POST["categoryId"], FILTER_VALIDATE_INT); // validate categoryId (POST);

    if ($categoryId === false) {
        header('Location: categories.php');
            exit();
    }

    query("DELETE FROM categories WHERE categories.id_kategorii='%s'", "", [$categoryId]);

    header('Location: categories.php');
?>

