<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
    require_once "../authenticate-admin.php";

    $bookId = filter_var($_POST["book-id"], FILTER_VALIDATE_INT); // validate book-id and warehouse-id (POST);
    $_SESSION["warehouseId"] = filter_var($_POST["warehouse-id"], FILTER_VALIDATE_INT);

    if ($bookId === false || $_SESSION["warehouseId"] === false) {
        header('Location: books.php');
            exit();
    }

    query("DELETE FROM books WHERE books.id_ksiazki='%s'", "", [$bookId]);

    query("DELETE FROM warehouse_books WHERE warehouse_books.id_ksiazki='%s' AND warehouse_books.id_magazynu='%s'", "", [$bookId, $_SESSION["warehouseId"]]);

    header('Location: books.php');

?>

