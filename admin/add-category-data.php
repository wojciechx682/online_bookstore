<?php

    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;

    if (
        isset($_POST["add-category-name"]) && !empty($_POST['add-category-name'])
    ) {

        $categoryName = filter_var($_POST["add-category-name"], FILTER_SANITIZE_STRING);

        //$categoryExists = query("SELECT kt.nazwa FROM categories AS kt WHERE kt.nazwa = '%s'", "verifyCategoryExists", $categoryName); // $_SESSION["categoryNameTaken"] --> true / NULL;

        // Check if values pass the tests;
        if ( empty($categoryName) ) {

            // categoryName - name didnt pass validation;
            echo "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>"; exit();

        } /*elseif ( !empty($categoryExists) ) {

            echo "<span class='update-failed'>Istnieje już kategoria o takiej nazwie. Spróbuj jeszcze raz</span>"; exit();

        }*/ else {

            // all values are valid; - fields PASSED validation;

            $updateSuccessful = query("INSERT INTO categories (id_kategorii, nazwa) VALUES (NULL, '%s')", "", [$categoryName]);

            if($updateSuccessful) {

                echo "<span class='archive-success'>Udało się dodać nową kategorię</span>";

            } else {

                echo "<span class='update-failed'>Wystąpił problem. Nie udało się zaktualizować danych</span>";
            }

        }


    } else {                                           // some required fields are missing or empty; isset(), empty();
        // handle the error or display an error message to the user;
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zaktualizować danych</span>";
        exit();  // pola nie były ustawione (nie istniały) - lub były puste;
    }

?>
