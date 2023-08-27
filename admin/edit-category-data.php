<?php

//admin/category.js;

/*session_start();
include_once "../functions.php";*/

// check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
require_once "../authenticate-admin.php";

if (
    isset($_POST["edit-category-name"]) && !empty($_POST['edit-category-name']) &&
    isset($_POST["edit-category-id"]) && !empty($_POST['edit-category-id'])

) {

    // all required fields are SET and NOT EMPTY; Perform the necessary actions or validations here; // For example, update the book data in the database;

    /*echo "<br> success <br><br>";
    echo "<br> tytuł - " . $_POST['edit-book-title'];
    echo "<br> autor (id) - " . $_POST['edit-book-change-author'];
    echo "<br> rok_wydania - " . $_POST['edit-book-release-year'];
    echo "<br> cena - " . $_POST['edit-book-price'] ;
    echo "<br> wydawca (id) - " . $_POST['edit-book-change-publisher'];
    echo "<br> opis - "  . $_POST['edit-book-desc'];
    echo "<br> oprawa - " . $_POST['edit-book-cover'];
    echo "<br> liczba_stron - " .$_POST['edit-book-pages'];
    echo "<br> wymiary - " . $_POST['edit-book-dims'];
    echo "<br> kategoria (id) - " . $_POST['edit-book-category'] ;
    echo "<br> podkategoria (id) - " . $_POST['edit-book-subcategory'] . "<br>";*/

    // back-end validation;

    $categoryName = filter_var($_POST["edit-category-name"], FILTER_SANITIZE_STRING);
    $categoryId = filter_var($_POST["edit-category-id"], FILTER_VALIDATE_INT);
    /*$title = filter_var($_POST['edit-book-title'], FILTER_SANITIZE_STRING);
   $author = filter_var($_POST['edit-book-change-author'], FILTER_VALIDATE_INT);
   $year = filter_var($_POST['edit-book-release-year'], FILTER_VALIDATE_INT);
   $price = filter_var($_POST['edit-book-price'], FILTER_VALIDATE_FLOAT);
   $publisher = filter_var($_POST['edit-book-change-publisher'], FILTER_VALIDATE_INT);
$desc = filter_var($_POST['edit-book-desc'], FILTER_SANITIZE_STRING);
$cover = filter_var($_POST['edit-book-cover'], FILTER_SANITIZE_STRING);
$pages = filter_var($_POST['edit-book-pages'], FILTER_VALIDATE_INT);
$dims = filter_var($_POST['edit-book-dims'], FILTER_SANITIZE_STRING);
$category = filter_var($_POST['edit-book-category'], FILTER_VALIDATE_INT);
$subcategory = filter_var($_POST['edit-book-subcategory'], FILTER_VALIDATE_INT);*/

    /*query("SELECT id_autora FROM autor ORDER BY id_autora DESC LIMIT 1", "get_author_id", "");
    // get highest author-id from db; // $_SESSION["max-author-id"] => "36";
    query("SELECT id_wydawcy FROM wydawcy ORDER BY id_wydawcy DESC LIMIT 1", "get_publisher_id", "");
    // get highest publisher-id from db; // $_SESSION["max-publisher-id"] => "2";
    query("SELECT id_kategorii FROM kategorie ORDER BY id_kategorii DESC LIMIT 1", "get_category_id", "");
    // get highest category-id from db; // $_SESSION["max-category-id"] => "7";
    query("SELECT id_magazynu FROM magazyn ORDER BY id_magazynu DESC LIMIT 1", "get_magazine_id", "");
    // get highest magazine-id from db; // $_SESSION["max-magazine-id"] => "2";*/

    // check if category name is not already taken -->
        unset($_SESSION["category-exists"]);
    query("SELECT kt.nazwa FROM kategorie AS kt WHERE kt.nazwa = '%s'", "verifyCategoryExists", $categoryName); // $_SESSION["categoryNameTaken"] --> true / NULL;

    // Check if values pass the tests;
    if ( empty($categoryName) || empty($categoryId) ) {

        // categoryName - name didnt pass validation;
        echo "<span class='update-failed'>65 Wystąpił problem. Podaj poprawne dane</span>"; exit();

    } elseif ( !empty($_SESSION["category-exists"]) ) {

        echo "<span class='update-failed'>Istnieje już kategoria o takiej nazwie. Spróbuj jeszcze raz</span>"; exit();

    } else {

        // all values are valid; - fields PASSED validation;

        $updateSuccessful = query("UPDATE kategorie SET nazwa='%s' WHERE id_kategorii='%s'", "", [$categoryName, $categoryId]);

        if($updateSuccessful && $_SESSION["update-category-successful"]) {

            echo "<span class='archive-success'>Udało się zaktualizować dane</span>";

        } else {

            echo "<span class='update-failed'>83 Wystąpił problem. Nie udało się zaktualizować danych</span>";
        }

    }


} else {                                           // some required fields are missing or empty; isset(), empty();
    // handle the error or display an error message to the user;
    echo "<span class='update-failed'>91 Wystąpił problem. Nie udało się zaktualizować danych</span>"; exit();  // pola nie były ustawione (nie istniały) - lub były puste;
}




/* if(isset($_FILES['edit-book-image'])) {
    $file = $_FILES['edit-book-image'];
    if (
        isset($file["name"]) && !empty($file["name"]) &&
        isset($file["full_path"]) && !empty($file["full_path"]) &&
        isset($file["type"]) && !empty($file["type"]) &&
        isset($file["tmp_name"]) && !empty($file["tmp_name"]) &&
        $file['error'] === UPLOAD_ERR_OK

    ) {
        echo "<br> success (file uploaded) <br>";
    } else {
        echo "<br> ERROR (file NOT uploaded) <br>";
    }
} */

/*array(1) { ["edit-book-image"]=> array(6) {
                                            ["name"]=> string(7) "111.bmp"
                                            ["full_path"]=> string(7) "111.bmp"
                                            ["type"]=> string(9) "image/bmp"
                                            ["tmp_name"]=> string(24) "C:\xampp\tmp\php8CD9.tmp"
                                            ["error"]=> int(0)
                                            ["size"]=> int(7806006) - bytes
                                          }
         }

Array ( [edit-book-image] => Array ( [name] => 111.bmp [full_path] => 111.bmp [type] => image/bmp [tmp_name] => C:\xampp\tmp\php8CD9.tmp [error] => 0 [size] => 7806006 ) )

$_FILES['field_name'] = [            // name attribute of <input type="file">
    'name' => 'file_name.ext',       // The original name of the file
    'type' => 'file_type',           // The MIME type of the file
    'tmp_name' => 'tmp_file_path',   // The temporary path of the uploaded file on the server
    'error' => 'error_code',         // Error code (0 if no error occurred)
    'size' => 'file_size'            // The size of the file in bytes
];*/
?>
