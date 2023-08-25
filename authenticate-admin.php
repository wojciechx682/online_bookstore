<?php

    // " It is recommended to move the PHP code that checks for session authentication and includes the necessary files to a separate PHP file (e.g., "authenticate-admin.php") and then include it at the top of each admin panel file. This helps in code reusability and reduces redundancy "

    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;

    session_start();
    include_once "../functions.php";

    // sprawdzenie, czy user jest zalogowany, i czy jest to admin (w plikach \admin) -->

    if ( ! isset($_SESSION['zalogowany']) ||
           $_SESSION['zalogowany'] !== true ||
           $_SESSION["user-type"] !== "admin" ) {
        // - nie jesteśmy zalogowani,
            // lub
        // - typ usera to nie admin (mimo że jest zalogowany)

        $_SESSION["login-error"] = true;
            header("Location: ../user/___zaloguj.php");
                exit();
    }
?>