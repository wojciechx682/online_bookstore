<?php

    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error"); // (?)
        exit();
    }
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
                <?php
                    query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia", "get_orders", "");
                ?>
            </div>



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