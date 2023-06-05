<?php
    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ../user/___index2.php?login-error");
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
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>



<style>

    body {
        background-color: #003e75 !important;
        background-image: none;
    }

    #center {
        width: 335px;
        height: 150px;
        border: 1px solid white;    font-weight: normal;    padding: 5px 12px;

            text-align: center;
        margin: 0 auto 0 auto;

        position: relative;
    }

    img {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
    }


</style>



<body>



<div id="all-container">

    <?php //require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">



            </div>

        </main>
    </div>

    <!-- <footer>
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