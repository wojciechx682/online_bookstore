<?php

    // " It is recommended to move the PHP code that checks for session authentication and includes the necessary files to a separate PHP file (e.g., "authenticate-admin.php") and then include it at the top of each admin panel file. This helps in code reusability and reduces redundancy "

    /*session_start();
    include_once "../functions.php";*/

    require_once "start-session.php";

    // sprawdzenie, czy user jest zalogowany, i czy jest to klient (w plikach \user) -->

    if ( ! isset($_SESSION['zalogowany']) ||
           $_SESSION['zalogowany'] !== true ||
           $_SESSION["user-type"] !== "klient" ) {
        // - nie jesteśmy zalogowani,
            // lub
        // - typ usera to nie klient (mimo że jest zalogowany)
        $_SESSION["login-error"] = true;
            header("Location: ___zaloguj.php");
                exit();
    }
?>