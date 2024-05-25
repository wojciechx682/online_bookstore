<?php

//admin/category.js;

require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;

if (
    isset($_POST["edit-category-name"]) && !empty($_POST['edit-category-name']) &&
    isset($_POST["edit-category-id"]) && !empty($_POST['edit-category-id'])

) {

    // all required fields are SET and NOT EMPTY; Perform the necessary actions or validations here; // For example, update the book data in the database;



    // back-end validation;

    $categoryName = filter_var($_POST["edit-category-name"], FILTER_SANITIZE_STRING);
    $categoryId = filter_var($_POST["edit-category-id"], FILTER_VALIDATE_INT);


    // check if category name is not already taken -->
        //unset($_SESSION["category-exists"]);
    $categoryExists = query("SELECT kt.nazwa FROM categories AS kt WHERE kt.nazwa = '%s'", "verifyCategoryExists", $categoryName); // $_SESSION["categoryNameTaken"] --> true / NULL;

    // Check if values pass the tests;
    if ( empty($categoryName) || empty($categoryId) ) {

        // categoryName - name didnt pass validation;
        echo "<span class='update-failed'>65 Wystąpił problem. Podaj poprawne dane</span>"; exit();

    } elseif ( !empty($categoryExists) ) {

        echo "<span class='update-failed'>Istnieje już kategoria o takiej nazwie. Spróbuj jeszcze raz</span>"; exit();

    } else {

        // all values are valid; - fields PASSED validation;

        $updateSuccessful = query("UPDATE categories SET nazwa='%s' WHERE id_kategorii='%s'", "", [$categoryName, $categoryId]);

        if($updateSuccessful) {

            echo "<span class='archive-success'>Udało się zaktualizować dane</span>";

        } else {

            echo "<span class='update-failed'>83 Wystąpił problem. Nie udało się zaktualizować danych</span>";
        }

    }


} else {                                           // some required fields are missing or empty; isset(), empty();
    // handle the error or display an error message to the user;
    echo "<span class='update-failed'>91 Wystąpił problem. Nie udało się zaktualizować danych</span>"; exit();  // pola nie były ustawione (nie istniały) - lub były puste;
}

?>
