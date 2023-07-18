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
        isset($_POST['edit-book-subcategory']) && !empty($_POST['edit-book-subcategory'])
    ) {
        // All required fields are set and not empty; Perform the necessary actions or validations here; // For example, update the book data in the database;

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

                $bookId = filter_var($_POST['edit-book-id'], FILTER_VALIDATE_INT);
            $title = filter_var($_POST['edit-book-title'], FILTER_SANITIZE_STRING);
            $author = filter_var($_POST['edit-book-change-author'], FILTER_VALIDATE_INT);
            $year = filter_var($_POST['edit-book-release-year'], FILTER_VALIDATE_INT);
            $price = filter_var($_POST['edit-book-price'], FILTER_VALIDATE_FLOAT);
            $publisher = filter_var($_POST['edit-book-change-publisher'], FILTER_VALIDATE_INT);
        $desc = filter_var($_POST['edit-book-desc'], FILTER_SANITIZE_STRING);
        $cover = filter_var($_POST['edit-book-cover'], FILTER_SANITIZE_STRING);
        $pages = filter_var($_POST['edit-book-pages'], FILTER_VALIDATE_INT);
        $dims = filter_var($_POST['edit-book-dims'], FILTER_SANITIZE_STRING);
        $category = filter_var($_POST['edit-book-category'], FILTER_VALIDATE_INT);
        $subcategory = filter_var($_POST['edit-book-subcategory'], FILTER_VALIDATE_INT);

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
            $title !== $_POST['edit-book-title'] ||
            $author === false ||
            $year === false || $year < 1900 || $year > 2023 ||
            $price === false || $price < 1 || $price > 500 ||
            $publisher === false ||
            $pages === false || $pages < 1 ||
            $cover !== $_POST['edit-book-cover'] ||
            $desc !== $_POST['edit-book-desc'] ||
            $dims !== $_POST['edit-book-dims'] ||
            $category === false ||
            $subcategory === false
        ) {

            echo "POST Error: Invalid or missing values"; // fieldnt didn't pass validation;

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
                                                ["size"]=> int(7806006)
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
