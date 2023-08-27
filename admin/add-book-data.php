<?php

//admin/category.js;

/*session_start();
include_once "../functions.php";*/

// check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
require_once "../authenticate-admin.php";

    if (
        isset($_POST['add-book-title']) && !empty($_POST['add-book-title']) &&
        isset($_POST['add-book-author']) && !empty($_POST['add-book-author']) &&
        isset($_POST['add-book-release-year']) && !empty($_POST['add-book-release-year']) &&
        isset($_POST['add-book-price']) && !empty($_POST['add-book-price']) &&
        isset($_POST['add-book-publisher']) && !empty($_POST['add-book-publisher']) &&
            isset($_FILES['add-book-image']) &&
        isset($_POST['add-book-desc']) && !empty($_POST['add-book-desc']) &&
        isset($_POST['add-book-cover']) && !empty($_POST['add-book-cover']) &&
        isset($_POST['add-book-pages']) && !empty($_POST['add-book-pages']) &&
        isset($_POST['add-book-dims']) && !empty($_POST['add-book-dims']) &&
        isset($_POST['add-book-category']) && !empty($_POST['add-book-category']) &&
        isset($_POST['add-book-subcategory']) && !empty($_POST['add-book-subcategory']) &&
        isset($_POST['add-book-select-magazine']) && !empty($_POST['add-book-select-magazine']) &&
        isset($_POST['add-book-quantity']) /*&& !empty($_POST['add-book-quantity'])*/
    ) {
        // all required fields are SET and NOT EMPTY;   perform the necessary actions or validations here; // for example, add the book data in the database;

                /* echo "<br> success <br><br>";
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
                echo "<br> podkategoria (id) - " . $_POST['edit-book-subcategory'] . "<br>"; */

        // back-end validation;

        query("SELECT id_autora FROM autor ORDER BY id_autora DESC LIMIT 1", "getAuthorId", ""); // get highest author-id from db;
            // $_SESSION["max-author-id"] => "35";

        query("SELECT id_wydawcy FROM wydawcy ORDER BY id_wydawcy DESC LIMIT 1", "getPublisherId", ""); // get highest publisher-id from db;
            // $_SESSION["max-publisher-id"] => "5";

        query("SELECT id_kategorii FROM kategorie ORDER BY id_kategorii DESC LIMIT 1", "getCategoryId", ""); // get highest category-id from db;
            // $_SESSION["max-category-id"] => "7";

        query("SELECT id_magazynu FROM magazyn ORDER BY id_magazynu DESC LIMIT 1", "getMagazineId", ""); // get highest magazine-id from db;
            // $_SESSION["max-magazine-id"] => "2";

            $title = filter_var($_POST['add-book-title'], FILTER_SANITIZE_STRING);
            $author = filter_var($_POST['add-book-author'], FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,                          // minimum allowed value;
                    'max_range' => $_SESSION["max-author-id"]  // maximum allowed value;
                ]
            ]);
            // check if there is really author with that id ;
            $_SESSION['author-exists'] = false;
            query("SELECT id_autora FROM autor WHERE id_autora = '%s'", "verifyAuthorExists", $author);
                // sprawdzenie, czy ten autor istnieje w bd ; check if there is any author with given POST id; jeśli num_rows > 0 -> przestawi // $_SESSION['author-exists'] -> na true ;
            $year = filter_var($_POST['add-book-release-year'], FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1900, // minimum allowed value;
                    'max_range' => 2023  // maximum allowed value;
                ]
            ]);
            $price = filter_var($_POST['add-book-price'], FILTER_VALIDATE_FLOAT, [
                'options' => [
                    'min_range' => 1,    // minimum allowed value;
                    'max_range' => 1000  // maximum allowed value;
                ]
            ]);
            $publisher = filter_var($_POST['add-book-publisher'], FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,                             // minimum allowed value;
                    'max_range' => $_SESSION["max-publisher-id"]  // maximum allowed value;
                ]
            ]);

            // check if there is really publisher with that id ;
                $_SESSION['publisher-exists'] = false;
            query("SELECT id_wydawcy FROM wydawcy WHERE id_wydawcy = '%s'", "verifyPublisherExists", $publisher);

            $desc = filter_var($_POST['add-book-desc'], FILTER_SANITIZE_STRING);
            $cover = filter_var($_POST['add-book-cover'], FILTER_SANITIZE_STRING);
            $pages = filter_var($_POST['add-book-pages'], FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,    // minimum allowed value;
                    'max_range' => 1500  // maximum allowed value;
                ]
            ]);
            $dims = filter_var($_POST['add-book-dims'], FILTER_SANITIZE_STRING);
        $category = filter_var($_POST['add-book-category'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-category-id"] // maximum allowed value;
            ]
        ]);

        // check if there is really category with that id ;
        $_SESSION['category-exists'] = false;
        query("SELECT id_kategorii FROM kategorie WHERE id_kategorii = '%s'", "verifyCategoryExists", $category);
        // $_SESSION['category-exists'] = true;

        $subcategory = filter_var($_POST['add-book-subcategory'], FILTER_VALIDATE_INT);
        $magazine = filter_var($_POST['add-book-select-magazine'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-magazine-id"] // maximum allowed value;
            ]
        ]);
        // check if there is really warehouse with that id ;
        $_SESSION['warehouse-exists'] = false;
        query("SELECT id_magazynu FROM magazyn WHERE id_magazynu = '%s'", "verifyWarehouseExists", $magazine);

        $quantity = filter_var($_POST['add-book-quantity'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 0,    // minimum allowed value;
                'max_range' => 5000  // maximum allowed value;
            ]
        ]);

        /* check -->
            $title !== $_POST['edit-book-title']
            $author === false (+ sprawdzenie czy istnieje taki autor - takie ID ?)
            $year === false || < 1900 || > 2023
            $price === false || < 1 || > 1000
            $publisher === false
            $pages === false
            $cover !== $_POST['edit-book-cover']
            $desc !== $_POST['...']
            $cover - the same as above with proper name in POST
            $dims  - the same as above with proper name in POST
            $category === false
            $subcategory === false;
        */


        if (
            $title === false || $title !== $_POST['add-book-title'] || strlen($title) > 255 || // check if values pass the tests;
            $author === false || $_SESSION['author-exists'] === false ||
            $year === false || $year < 1900 || $year > 2023 ||
            $price === false || $price < 1 || $price > 500 ||
            $publisher === false || $_SESSION['publisher-exists'] === false ||
            $pages === false || $pages < 1 || $pages > 1500 ||
            $cover === false || $cover !== $_POST['add-book-cover'] ||
            $desc === false || $desc !== $_POST['add-book-desc'] || strlen($desc) < 10 || strlen($desc) > 1000 ||
            $dims === false || $dims !== $_POST['add-book-dims'] || strlen($dims) > 15 ||
            $category === false || $_SESSION['category-exists'] === false ||
            $subcategory === false ||
            $magazine === false || $_SESSION['warehouse-exists'] === false ||
            $quantity === false
        ) {
                //echo "<br>POST Error: Invalid or missing values<br> (Values didnt pass validation!)"; // fields didn't pass validation;
            //echo "<span class='update-failed'>Wystąpił problem. Dodanie nowej książki nie powiodło się</span>"; exit();
            echo "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>"; exit();

        } else { // all values are valid; - fields PASSED validation;
                                                          // perform the necessary actions or validations here;
                                                          // for example, add the book data in the database;

            if(!validateFile("add-book-image")) {
                //echo "<br>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz<br>";
                echo "<span class='update-failed'>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz</span>"; exit();
            } else {
                $bookData = [$author, $title, $price, $year, $desc, ucfirst($cover), $publisher, $_FILES["add-book-image"]["name"], $pages, $dims, "nowa", $subcategory];
                query("INSERT INTO ksiazki (id_ksiazki, id_autora, tytul, cena, rok_wydania, opis, oprawa, id_wydawcy, image_url, ilosc_stron, wymiary, stan, id_subkategorii) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_book_id", $bookData); // $_SESSION["last-book-id"];

                $warehouse = [$magazine, $_SESSION["last-book-id"], $quantity];
                query("INSERT INTO magazyn_ksiazki (id_magazynu, id_ksiazki, ilosc_dostepnych_egzemplarzy) VALUES ('%s', '%s', '%s')", "addBookIntoWarehouse", $warehouse); // $_SESSION["add-book-successful"];
            }

            //exit();

            // Array ( [add-book-image] => Array (
            //                                      [name] => csymfoni_wyd_V.png            - original name of the file (on client machine)
            //                                     [full_path] => csymfoni_wyd_V.png
            //                                     [type] => image/png                     - MIME type
            //                                     [tmp_name] => C:\xampp\tmp\php39AB.tmp  - tymczasowa nazwa pliku pod którą był on przechowywany na serwerze
            //                                                                               (pliki będą domyślnie przechowywane w domyślnym katalogu tymczasowym serwera)
            //                                                                               (chyba że w dyrektywie upload_tmp_dir w pliku php.ini podano inną lokalizację)
            //                                          (Domyślny katalog serwera można zmienić, ustawiając zmienną środowiskową TMPDIR w środowisku, w którym działa PHP.)
            //                                      [error] => 0                            - kod błędu -> https://www.php.net/manual/en/features.file-upload.errors.php
            //                                      [size] => 70238                         - rozmiar w bajtach [B]
            //                                   )
            //        )

            // $_FILES['file_input_name'] = array(
            //    'name' => 'file_name.ext',       // Original name of the uploaded file
            //    'type' => 'file/mimetype',       // MIME type of the file
            //    'tmp_name' => '/tmp/phpabc123',  // Temporary path on the server where the file is stored
            //    'error' => 0,                    // Error code (0 means no error)
            //    'size' => 123456                 // Size of the file in bytes
            //);

            // ✓ 1. Validate TYPE of file
            //    --> Check if the uploaded file's MIME type matches the expected file types.
            //    $_FILES['file_input_name']['type']

            // ✓ 2. File Size Validation
            //    --> Ensure that the file size does not exceed the maximum allowed size
            //    $_FILES['file_input_name']['size']

            // ✓  3. File Error Handling -->
            //    $_FILES['file_input_name']['error'] - check that value to see if any errors occurred.
            //    0 - means no error
            //    (!!!) value OTHER THAN 0 - means that error occurred;

            // ✓ 4. Sanitization -
            //    sanitize NAME OF FILE !


            // whem <form> was sent without uploading the file -->
                // Array ( [add-book-image] => Array (
                // [name] =>
                // [full_path] =>
                // [type] =>
                // [tmp_name] =>
                // [error] => 4
                // [size] => 0 ) )
        }

    } else {                                           // some required fields are missing or empty; isset(), empty();
                                                       // handle the error or display an error message to the user;
        echo "<span class='update-failed'>Wystąpił problem. Dodanie nowej książki nie powiodło się</span>"; exit();  // pola nie były ustawione (nie istniały) - lub były puste;
    }

    if( isset($_SESSION["add-book-successful"]) && $_SESSION["add-book-successful"] === true ) {
        unset($_SESSION["add-book-successful"], $_SESSION["last-book-id"]);

        echo "<span class='archive-success'>Udało się dodać nowe dane</span>";
    } else { // false ;
        echo "<span class='update-failed'>Wystąpił problem. Dodanie nowej książki nie powiodło się</span>";
    }


/*if( isset($_SESSION["update-book-successful"]) && $_SESSION["update-book-successful"] === false ) {
    unset($_SESSION["update-book-successful"]);
    echo "<span class='archive-success'>Udało się zmienić zaktualizować dane</span>";
} else {                                           // ture ;
    echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić danych</span>";
}*/



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
