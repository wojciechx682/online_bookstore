<?php

//admin/category.js;

/*session_start();
include_once "../functions.php";*/

// check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
require_once "../authenticate-admin.php";

    if (
        isset($_POST['edit-book-id']) && !empty($_POST['edit-book-id']) &&
        isset($_POST['edit-book-title']) && !empty($_POST['edit-book-title']) &&
        isset($_POST['edit-book-change-author']) && !empty($_POST['edit-book-change-author']) &&
        isset($_POST['edit-book-release-year']) && !empty($_POST['edit-book-release-year']) &&
        isset($_POST['edit-book-price']) && !empty($_POST['edit-book-price']) &&
        isset($_POST['edit-book-change-publisher']) && !empty($_POST['edit-book-change-publisher']) &&
        isset($_FILES['edit-book-image']) &&
        isset($_POST['edit-book-desc']) && !empty($_POST['edit-book-desc']) &&
        isset($_POST['edit-book-cover']) && !empty($_POST['edit-book-cover']) &&
        isset($_POST['edit-book-pages']) && !empty($_POST['edit-book-pages']) &&
        isset($_POST['edit-book-dims']) && !empty($_POST['edit-book-dims']) &&
        isset($_POST['edit-book-category']) && !empty($_POST['edit-book-category']) &&
        isset($_POST['edit-book-subcategory']) && !empty($_POST['edit-book-subcategory']) &&
        isset($_POST['edit-book-select-magazine']) && !empty($_POST['edit-book-select-magazine']) &&
        isset($_POST['edit-book-quantity']) /*&& !empty($_POST['edit-book-quantity'])*/
    ) {

        // all required fields are SET and NOT EMPTY; Perform the necessary actions or validations here; // For example, update the book data in the database;

                echo "<br> success <br><br>";
                echo "<br> success <br><br>";
                    echo "<br> id ksiazki " . $_POST['edit-book-id'];
                    echo "<br> autor (id) - " . $_POST['edit-book-change-author'];
                    echo "<br> rok_wydania - " . $_POST['edit-book-release-year'];
                    echo "<br> cena - " . $_POST['edit-book-price'] ;
                    echo "<br> wydawca (id) - " . $_POST['edit-book-change-publisher'];
                    echo "<br> opis - "  . $_POST['edit-book-desc'];
                    echo "<br> oprawa - " . $_POST['edit-book-cover'];
                    echo "<br> liczba_stron - " .$_POST['edit-book-pages'];
                    echo "<br> wymiary - " . $_POST['edit-book-dims'];
                echo "<br> kategoria (id) - " . $_POST['edit-book-category'] ;
                echo "<br> podkategoria (id) - " . $_POST['edit-book-subcategory'];
                echo "<br> podkategoria (id) - " . $_POST['edit-book-subcategory'];
                echo "<br> ilosc - " . $_POST['edit-book-quantity'];

        // back-end validation;

       $bookId = filter_var($_POST['edit-book-id'], FILTER_VALIDATE_INT);
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

        $maxAuthorId = query("SELECT id_autora FROM author ORDER BY id_autora DESC LIMIT 1", "getAuthorId", "");
        // get highest author-id from db; // $_SESSION["max-author-id"] => "36";
        query("SELECT id_wydawcy FROM publishers ORDER BY id_wydawcy DESC LIMIT 1", "getPublisherId", "");
        // get highest publisher-id from db; // $_SESSION["max-publisher-id"] => "2";
        query("SELECT id_kategorii FROM categories ORDER BY id_kategorii DESC LIMIT 1", "getCategoryId", "");
        // get highest category-id from db; // $_SESSION["max-category-id"] => "7";
        query("SELECT id_magazynu FROM warehouse ORDER BY id_magazynu DESC LIMIT 1", "getMagazineId", "");
        // get highest magazine-id from db; // $_SESSION["max-magazine-id"] => "2";



        $title = filter_var($_POST['edit-book-title'], FILTER_SANITIZE_STRING);
        $author = filter_var($_POST['edit-book-change-author'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                          // minimum allowed value;
                'max_range' => $maxAuthorId                // maximum allowed value;
            ]
        ]);
        // check if there is really author with that id ;
        //$_SESSION['author-exists'] = false;
        $authorExists = query("SELECT id_autora FROM author WHERE id_autora = '%s'", "verifyAuthorExists", $author);
            // sprawdzenie, czy ten autor istnieje w bd ; check if there is any author with given POST id; jeśli num_rows > 0 -> przestawi // $_SESSION['author-exists'] -> na true ;
        $year = filter_var($_POST['edit-book-release-year'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1900, // minimum allowed value;
                'max_range' => 2023  // maximum allowed value;
            ]
        ]);
        $price = filter_var($_POST['edit-book-price'], FILTER_VALIDATE_FLOAT, [
            'options' => [
                'min_range' => 1,    // minimum allowed value;
                'max_range' => 1000  // maximum allowed value;
            ]
        ]);
        $publisher = filter_var($_POST['edit-book-change-publisher'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                             // minimum allowed value;
                'max_range' => $_SESSION["max-publisher-id"]  // maximum allowed value;
            ]
        ]);

        // check if there is really publisher with that id ;
            $_SESSION['publisher-exists'] = false;
        query("SELECT id_wydawcy FROM publishers WHERE id_wydawcy = '%s'", "verifyPublisherExists", $publisher);

        $desc = filter_var($_POST['edit-book-desc'], FILTER_SANITIZE_STRING);
        $cover = filter_var($_POST['edit-book-cover'], FILTER_SANITIZE_STRING);
        $pages = filter_var($_POST['edit-book-pages'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,    // minimum allowed value;
                'max_range' => 1500  // maximum allowed value;
            ]
        ]);
        $dims = filter_var($_POST['edit-book-dims'], FILTER_SANITIZE_STRING);
        $category = filter_var($_POST['edit-book-category'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-category-id"] // maximum allowed value;
            ]
        ]);

        // check if there is really category with that id ;
        //$_SESSION['category-exists'] = false;

        $categoryExists = query("SELECT id_kategorii FROM categories WHERE id_kategorii = '%s'", "verifyCategoryExists", $category);
        // $_SESSION['category-exists'] = true;

        $subcategory = filter_var($_POST['edit-book-subcategory'], FILTER_VALIDATE_INT);
        $magazine = filter_var($_POST['edit-book-select-magazine'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-magazine-id"] // maximum allowed value;
            ]
        ]);
        $quantity = filter_var($_POST['edit-book-quantity'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 0,    // minimum allowed value;
                'max_range' => 5000  // maximum allowed value;
            ]
        ]);

        /* check -->
            $title !== $_POST['edit-book-title']
            $author === false (+ sprawdzenie czy istnieje taki autor - takie ID ?)
            $year === false || < 1900 || > 2023
            $price === false || < 1 || > 500
            $publisher === false
            $pages === false
            $cover !== $_POST['edit-book-cover']
            $desc !== $_POST['...']
            $cover - the same as above with proper name in POST
            $dims  - the same as above with proper name in POST
            $category === false
            $subcategory === false;
        */

        // Check if values pass the tests;
        if (
            $bookId === false ||
            $title === false || $title !== $_POST['edit-book-title'] || strlen($title) > 255 ||
            $author === false || empty($authorExists) ||
            $year === false || $year < 1900 || $year > 2023 ||
            $price === false || $price < 1 || $price > 500 ||
            $publisher === false || $_SESSION['publisher-exists'] === false ||
            $pages === false || $pages < 1 || $pages > 1500 ||
            $cover === false || $cover !== $_POST['edit-book-cover'] ||
            $desc === false || $desc !== $_POST['edit-book-desc'] || strlen($desc) < 10 || strlen($desc) > 1000 ||
            $dims === false || $dims !== $_POST['edit-book-dims'] || strlen($dims) > 15 ||
            $category === false || empty($categoryExists) ||
            $subcategory === false ||
            $magazine === false || $magazine !== $_SESSION["warehouseId"] ||
            $quantity === false
        ) {

            echo "<br><hr><br>";
                echo "<br> bookId-> " . $bookId;
                echo "<br> title-> " . $title;
                echo "<br> author-> " . $author;
                echo "<br> year -> " . $year;
                echo "<br> price -> " . $price;
                echo "<br> publisher -> " . $publisher;
                echo "<br> pages -> " . $pages;
                echo "<br> cover -> " . $cover;
                echo "<br> desc -> " . $desc;
                echo "<br> dims -> " . $dims;
                echo "<br> category -> " . $category;
                echo "<br> subcategory -> " . $subcategory;
                echo "<br> magazine -> " . $magazine;
                echo "<br> quantity -> " . $quantity;

                if($quantity === false) {
                    echo "<br> quantity -> FALSE";
                } else {
                    echo "<br> quantity -> TRUE";
                }
            echo "<br><hr><br>";


            //echo "POST Error: Invalid or missing values"; // fieldnt didn't pass validation;
            echo "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>"; exit();

        } else {                                          // all values are valid; - fields PASSED validation;
                                                          // perform the necessary actions or validations here;
                                                          // for example, update the book data in the database;


            if(!validateFile("edit-book-image")) {
                //echo "<br>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz<br>";
                echo "<span class='update-failed'>Wystąpił problem z przesłaniem pliku. Spróbuj jeszcze raz</span>"; exit();
            } else {

                query("UPDATE books SET tytul='%s', id_autora='%s', rok_wydania='%s', cena='%s', id_wydawcy='%s', image_url='%s', opis='%s', oprawa='%s', ilosc_stron='%s', wymiary='%s', id_subkategorii='%s' WHERE books.id_ksiazki='%s'", "updateBookData", [$title, $author, $year, $price, $publisher, $_FILES["edit-book-image"]["name"], $desc, $cover, $pages, $dims, $subcategory, $bookId]);

                query("UPDATE warehouse_books SET ilosc_dostepnych_egzemplarzy='%s' WHERE warehouse_books.id_ksiazki='%s' AND warehouse_books.id_magazynu='%s'", "updateBookData", [$quantity, $bookId, $magazine]);

                // update book-quantity (in-stock) in warehouse;

                /*if($_SESSION["update-book-successful"] === false) { // jeśli udało się zrealizować powyższe zapytanie (update książki);

                    unset($_SESSION["update-book-successful"]);

                    echo "<br>216<br>";

                    query("UPDATE magazyn_ksiazki SET ilosc_dostepnych_egzemplarzy='%s' WHERE magazyn_ksiazki.id_ksiazki='%s' AND magazyn_ksiazki.id_magazynu='%s'", "updateBookData", [$quantity, $bookId, $magazine]);

                    echo "<br>220<br>";

                    echo "<br><br>"; echo "<hr><br><br>";
                        var_dump($_SESSION["update-book-successful"]);
                    echo "<br><br>"; echo "<hr><br><br>";
                }*/
            }
        }

    } else {                                           // some required fields are missing or empty; isset(), empty();
                                                       // handle the error or display an error message to the user;
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zaktualizować danych</span>"; exit();  // pola nie były ustawione (nie istniały) - lub były puste;
    }

    if( isset($_SESSION["update-book-successful"]) && ($_SESSION["update-book-successful"] == false) ) {
        unset($_SESSION["update-book-successful"]);
        echo "<span class='archive-success'>Udało się zaktualizować dane</span>";
    } else {                                           // ture ;
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić danych</span>";
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
