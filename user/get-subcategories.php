<?php

    session_start();

    echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
    echo "GET ->"; print_r($_GET); echo "<hr><br>";
    echo "SESSION ->"; print_r($_SESSION); echo "<hr>";

?>