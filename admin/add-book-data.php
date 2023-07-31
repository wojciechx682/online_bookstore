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
        isset($_POST['add-book-select-magazine']) && !empty($_POST['dd-book-select-magazine']) &&
        isset($_POST['add-book-quantity']) && !empty($_POST['add-book-quantity'])
    ) {
        // All required fields are set and not empty; Perform the necessary actions or validations here; // For example, add the book data in the database;

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

        // get highest author-id from db;
        query("SELECT id_autora FROM autor ORDER BY id_autora DESC LIMIT 1", "get_author_id", "");
        // $_SESSION["max-author-id"] => "35";

        // get highest publisher-id from db;
        query("SELECT id_wydawcy FROM wydawcy ORDER BY id_wydawcy DESC LIMIT 1", "get_publisher_id", "");
        // $_SESSION["max-publisher-id"] => "5";

        // get highest category-id from db;
        query("SELECT id_kategorii FROM kategorie ORDER BY id_kategorii DESC LIMIT 1", "get_category_id", "");
        // $_SESSION["max-category-id"] => "7";

        // get highest magazine-id from db;
        query("SELECT id_magazynu FROM magazyn ORDER BY id_magazynu DESC LIMIT 1", "get_magazine_id", "");
        // $_SESSION["max-magazine-id"] => "2";

            $title = filter_var($_POST['add-book-title'], FILTER_SANITIZE_STRING);
            $author = filter_var($_POST['add-book-author'], FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,                          // minimum allowed value;
                    'max_range' => $_SESSION["max-author-id"]  // maximum allowed value;
                ]
            ]);
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
        $subcategory = filter_var($_POST['add-book-subcategory'], FILTER_VALIDATE_INT);
        $magazine = filter_var($_POST['add-book-select-magazine'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,                           // minimum allowed value;
                'max_range' => $_SESSION["max-magazine-id"] // maximum allowed value;
            ]
        ]);
        $quantity = filter_var($_POST['add-book-quantity'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1,    // minimum allowed value;
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
            $title !== $_POST['add-book-title'] || strlen($title) > 255 ||
            $author === false ||
            $year === false ||
            $price === false ||
            $publisher === false ||
            $pages === false ||
            $cover !== $_POST['add-book-cover'] ||
            $desc !== $_POST['add-book-desc'] || strlen($desc) < 10 || strlen($desc) > 1000 ||
            $dims !== $_POST['add-book-dims'] || strlen($dims) < 5 || strlen($dims) > 15 ||
            $category === false ||
            $subcategory === false ||
            $magazine === false ||
            $quantity === false

        ) {
            echo "<br>POST Error: Invalid or missing values<br>"; // fields didn't pass validation;

        } else {                                          // all values are valid; - fields PASSED validation;
                                                          // perform the necessary actions or validations here;
                                                          // for example, update the book data in the database;

            $file = $_FILES['edit-book-image'];           // validate file;

            if (
                isset($file["name"]) && !empty($file["name"]) &&
                isset($file["full_path"]) && !empty($file["full_path"]) &&
                isset($file["type"]) && !empty($file["type"]) &&
                isset($file["tmp_name"]) && !empty($file["tmp_name"]) &&
                $file['error'] === UPLOAD_ERR_OK
            ) {
                // file exists - has been sent;

                $filename = $file["name"];
                $tmpPath = $file["tmp_name"];
                $destPath = "../assets/books/" . $filename;

                // file validation and sanitization;

                // source of the code (try {} catch - block) --> https://www.php.net/manual/en/features.file-upload.php;

                try {
                    // Undefined | Multiple Files | $_FILES Corruption Attack
                    // If this request falls under any of them, treat it invalid.
                    if (
                        !isset($_FILES['edit-book-image']['error']) ||
                        is_array($_FILES['edit-book-image']['error'])
                    ) {
                        throw new RuntimeException('Invalid parameters');
                    }

                    // Check $_FILES['upfile']['error'] value.
                    switch ($_FILES['edit-book-image']['error']) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new RuntimeException('No file sent.');
                        case UPLOAD_ERR_INI_SIZE:  // file exceeds the upload_max_filesize directive in php.ini.
                        case UPLOAD_ERR_FORM_SIZE: //  file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form
                            throw new RuntimeException('Exceeded filesize limit.');
                        default:
                            throw new RuntimeException('Unknown errors.');
                    }

                    // You should also check filesize here.
                    if ($_FILES['edit-book-image']['size'] > 5000000) { // 5 MB
                        throw new RuntimeException('Exceeded filesize limit.');
                    }

                    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE;
                    // Check MIME Type by yourself.
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    if (false === $ext = array_search(
                            $finfo->file($_FILES['edit-book-image']['tmp_name']),
                            array(
                                'jpg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                            ),
                            true
                        )) {
                        throw new RuntimeException('Invalid file format.');
                    }

                    // You should name it uniquely.
                    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                    // On this example, obtain safe unique name from its binary data.
                    /*if (!move_uploaded_file($_FILES['upfile']['tmp_name'],
                                            sprintf('./uploads/%s.%s', sha1_file($_FILES['upfile']['tmp_name']), // ?
                            $ext
                        )
                    )) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }*/

                                    /*if (!move_uploaded_file($tmpPath, $destPath)) {  // A CO Z SANITYZACJĄ NAZWY PLIKU (?)
                                        echo '<br>File uploaded successfully.';
                                    } else {
                                        echo '<br>Error moving uploaded file.';
                                    }*/

                    if (!move_uploaded_file($tmpPath, $destPath)) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }

                    //echo 'File is uploaded successfully.';

                    query("UPDATE ksiazki SET tytul='%s', id_autora='%s', rok_wydania='%s', cena='%s', id_wydawcy='%s', image_url='%s', opis='%s', oprawa='%s', ilosc_stron='%s', wymiary='%s', id_subkategorii='%s' WHERE ksiazki.id_ksiazki='%s'", "updateBookData", [$title, $author, $year, $price, $publisher, $filename, $desc, $cover, $pages, $dims, $subcategory, $bookId]);

                } catch (RuntimeException $e) {

                    echo $e->getMessage();

                }

            } else {                                   // file was not send (not uploaded);
                                                       // error code (0 if no error occurred);
                echo 'Error uploading file. (file NOT uploaded) - Error code: ' . $file['error'];
                                                       // https://www.php.net/manual/en/features.file-upload.errors.php;
            }
        }
    } else {                                           // some required fields are missing or empty; isset(), empty();
                                                       // handle the error or display an error message to the user;
        echo "error - data were NOT set in $ _ POST";  // pola nie były ustawione (nie istniały) - lub były puste;
    }

    if( isset($_SESSION["update-book-successful"]) && $_SESSION["update-book-successful"] === false ) {
        unset($_SESSION["update-book-successful"]);
        echo "<span class='archive-success'>Udało się zmienić zaktualizować dane</span>";
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
