<?php

    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;

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
        isset($_POST['add-book-quantity'])
    ) {
        // all required fields are SET and NOT EMPTY;   perform the necessary actions or validations here; // for example, add the book data in the database;
        // back-end validation;
        $maxAuthorId = query("SELECT id_autora FROM author ORDER BY id_autora DESC LIMIT 1", "getAuthorId", ""); // get highest author-id from db;

        query("SELECT id_wydawcy FROM publishers ORDER BY id_wydawcy DESC LIMIT 1", "getPublisherId", ""); // get highest publisher-id from db;
        // $_SESSION["max-publisher-id"] => "5";

        query("SELECT id_kategorii FROM categories ORDER BY id_kategorii DESC LIMIT 1", "getCategoryId", ""); // get highest category-id from db;
        // $_SESSION["max-category-id"] => "7";

        query("SELECT id_magazynu FROM warehouse ORDER BY id_magazynu DESC LIMIT 1", "getMagazineId", ""); // get highest magazine-id from db;
        // $_SESSION["max-magazine-id"] => "2";

        $title = filter_var($_POST['add-book-title'], FILTER_SANITIZE_STRING);

        $author = filter_var($_POST['add-book-author'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,           // minimum allowed value;
                'max_range' => $maxAuthorId // maximum allowed value;
            ]
        ]);
        // check if there is really author with that id ;

        $authorExists = query("SELECT id_autora FROM author WHERE id_autora = '%s'", "verifyAuthorExists", $author);
        // sprawdzenie, czy ten autor istnieje w bd; check if there is any author with given POST id; jeśli num_rows > 0 -> zwróci true;

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
        query("SELECT id_wydawcy FROM publishers WHERE id_wydawcy = '%s'", "verifyPublisherExists", $publisher);

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
        $categoryExists = query("SELECT id_kategorii FROM categories WHERE id_kategorii = '%s'", "verifyCategoryExists", $category);

        $subcategory = filter_var($_POST['add-book-subcategory'], FILTER_VALIDATE_INT);

        $magazine = filter_var($_POST['add-book-select-magazine'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-magazine-id"] // maximum allowed value;
            ]
        ]);

        // check if there is really warehouse with that id ;
        $_SESSION['warehouse-exists'] = false;
        query("SELECT id_magazynu FROM warehouse WHERE id_magazynu = '%s'", "verifyWarehouseExists", $magazine);

        $quantity = filter_var($_POST['add-book-quantity'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 0,    // minimum allowed value;
                'max_range' => 5000  // maximum allowed value;
            ]
        ]);

        if (
                $title === false || $title !== $_POST['add-book-title'] || strlen($title) > 255 || // check if values pass the tests;
                $author === false || empty($authorExists) ||
                $year === false || $year < 1900 || $year > 2023 ||
                $price === false || $price < 1 || $price > 500 ||
                $publisher === false || $_SESSION['publisher-exists'] === false ||
                $pages === false || $pages < 1 || $pages > 1500 ||
                $cover === false || $cover !== $_POST['add-book-cover'] ||
                $desc === false || $desc !== $_POST['add-book-desc'] || strlen($desc) < 10 || strlen($desc) > 100000 ||
                $dims === false || $dims !== $_POST['add-book-dims'] || strlen($dims) > 15 ||
                $category === false || empty($categoryExists) ||
                $subcategory === false ||
                $magazine === false || $_SESSION['warehouse-exists'] === false ||
                $quantity === false
        ) {

            echo "<br><hr><br>";

            if($title === false || $title !== $_POST['add-book-title'] || strlen($title) > 255) {
                echo "<br> title === false " . $title;
                echo "<br> title, POST[title] -->" . $title . ", " . $_POST['add-book-title'];
                echo "<br> strlen(title) --> " . strlen($title);
            }
            if($author === false || empty($authorExists)) {
                echo "<br> author --> " . $author;
                echo "<br> empty(authorExists) --> " . empty($authorExists);
            }
            if($year === false || $year < 1900 || $year > 2023) {
                echo "<br> year --> " . $year;
            }
            if($price === false || $price < 1 || $price > 500) {
                echo "<br> price --> " . $price;
            }
            if($publisher === false || $_SESSION['publisher-exists'] === false) {
                echo "<br> publisher --> " . $publisher;
                echo "<br> SESSION[publisher-exists] --> " . $_SESSION['publisher-exists'];
            }
            if($pages === false || $pages < 1 || $pages > 1500) {
                echo "<br> pages --> " . $pages;
            }
            if($cover === false || $cover !== $_POST['add-book-cover']) {
                echo "<br> cover --> " . $cover;
                echo "<br> POST[add-book-cover] --> " . $_POST['add-book-cover'];
            }
            if($desc === false || $desc !== $_POST['add-book-desc'] || strlen($desc) < 10 || strlen($desc) > 100000) {
                echo "<br> desc --> " . $desc;
                echo "<br> POST[edit-book-desc] --> " . $_POST['edit-book-desc'];
                echo "<br> strlen(desc) --> " . strlen($desc);
            }
            if($dims === false || $dims !== $_POST['add-book-dims'] || strlen($dims) > 15) {
                echo "<br> dims --> " . $dims;
                echo "<br> POST[add-book-dims] --> " . $_POST['add-book-dims'];
                echo "<br> strlen(dims) --> " . strlen($dims);
            }
            if($category === false || empty($categoryExists)) {
                echo "<br> category --> " . $category;
                echo "<br> empty(categoryExists) --> " . empty($categoryExists);
            }
            if($subcategory === false) {
                echo "<br> subcategory --> " . $subcategory;
            }
            if($magazine === false || $_SESSION['warehouse-exists'] === false) {
                echo "<br> magazine --> " . $magazine;
                echo "<br> SESSION[warehouse-exists] --> " . $_SESSION["warehouse-exists"];
            }
            if($quantity === false) {
                echo "<br> quantity --> " . $quantity;
            }

            echo "<br><hr><br>";


            echo "<span class='update-failed'>1 Wystąpił problem. Podaj poprawne dane</span>"; exit();
        } else { // all values are valid; - fields PASSED validation;
                // perform the necessary actions or validations here;
                // for example, add the book data in the database;
            if(!validateFile("add-book-image")) {
                //echo "<br>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz<br>";
                echo "<span class='update-failed'>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz</span>"; exit();
            } else {
                $bookData = [$author, $title, $price, $year, $desc, ucfirst($cover), $publisher, $_FILES["add-book-image"]["name"], $pages, $dims, "nowa", $subcategory];
                query("INSERT INTO books (id_ksiazki, id_autora, tytul, cena, rok_wydania, opis, oprawa, id_wydawcy, image_url, ilosc_stron, wymiary, stan, id_subkategorii) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_book_id", $bookData);
                // $_SESSION["last-book-id"];
                $warehouse = [$magazine, $_SESSION["last-book-id"], $quantity];
                query("INSERT INTO warehouse_books (id_magazynu, id_ksiazki, ilosc_dostepnych_egzemplarzy) VALUES ('%s', '%s', '%s')", "addBookIntoWarehouse", $warehouse);
                // $_SESSION["add-book-successful"];
            }

            // Array ( [add-book-image] => Array (
            //                                     [name] => csymfoni_wyd_V.png            - original name of the file (on client machine)
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
                // [size] => 0 ))
        }

    } else { // some required fields are missing or empty; isset(), empty();
             // handle the error or display an error message to the user;
        echo "<span class='update-failed'>Wystąpił problem. Dodanie nowej książki nie powiodło się</span>"; exit();  // pola nie były ustawione (nie istniały) - lub były puste;
    }

    if (isset($_SESSION["add-book-successful"]) && $_SESSION["add-book-successful"] === true) { // function addBookIntoWarehouse
        unset($_SESSION["add-book-successful"], $_SESSION["last-book-id"]);

        echo "<span class='archive-success'>Udało się dodać nowe dane</span>";
    } else {
        echo "<span class='update-failed'>Wystąpił problem. Dodanie nowej książki nie powiodło się</span>";
    }
?>
