<?php

    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error"); // (?)
        exit();
    }

    /* if(isset($_GET["login-error"])) {
        echo '
                    <script>
                        alert("Musisz być zaloowany !")
                        let url = new URL(window.location.href);
                        url.searchParams.delete("login-error");
                        window.location.href = url.toString();
                    </script>
                 ';
    } */

    /*if((isset($_GET['kategoria'])) && (!empty($_GET['kategoria'])))
    {
        $_SESSION["kategoria"] = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]); // sanityzacja danych wprowadzonych od użytkownika; $kategoria = <script>alert("hahaha");</script>;
    }
    elseif((isset($_SESSION['kategoria'])) && (!empty($_SESSION['kategoria'])) && isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]))
    {
        $_SESSION["kategoria"] = htmlentities($_SESSION['kategoria'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    }
    if((isset($_POST["adv-search-category"])))
    {
        $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    }
    if(isset($_SESSION["kategoria"]) && isset($_GET["input-search"]))
    {
        $_SESSION["kategoria"] = "Wszystkie";
    }*/
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

<?php
    /*echo "<div style='margin-left: 18px;'><br> hi admin <br></div>";
    echo "<div style='margin-left: 18px !important; margin-bottom: 15px; color: #002fad; font-weight: bold;'><i>";
            echo var_dump($_SESSION);
            echo "</i></div>";*/
?>

<div id="all-container">

    <?php //require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <div id="content">

            </div>

            <?php
                //query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia", "get_orders", "");
            ?>

        </main>
    </div>

    <!--<footer>
        <div id="footer">
            <script src="../scripts/set-theme.js"></script>
            <pre>
                <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer> -->

    <?php //require "../view/___footer.php"; ?>

</div>

</body>
</html>