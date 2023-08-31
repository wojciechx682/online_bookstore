<?php

    session_start();
    include_once "../functions.php";

    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
    echo "GET ->"; print_r($_GET); echo "<hr><br>";
    echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

    //query("SELECT sb.id_subkategorii, sb.nazwa, sb.id_kategorii FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii AND sb.id_kategorii = '%s'", "getSubcategories", $category_id);

    if( $_SERVER['REQUEST_METHOD'] === "GET" ) {
        query("SELECT sb.id_subkategorii, sb.nazwa, kt.nazwa AS id_kategorii FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii", "getSubcategories", "");
    }



?>