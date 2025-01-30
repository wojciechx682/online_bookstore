<?php
    // check if user is logged-in, and user-type is "client" - if not, redirect to login page;
    require_once "start-session.php";

    if ( !isset($_SESSION['zalogowany']) ||
         !isset($_SESSION['id']) ||
           $_SESSION['zalogowany'] !== true ||
           $_SESSION["user-type"] !== "klient" ) {
        // - nie jesteśmy zalogowani,
            // lub
        // - typ usera to nie klient (mimo że jest zalogowany)
        $_SESSION["login-error"] = true;
            header("Location: zaloguj.php");
                exit();
    }
