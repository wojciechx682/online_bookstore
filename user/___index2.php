<?php

session_start();

include_once "../functions.php";

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<style>
    #test {
        margin: 0;
        padding: 0 40px 0 0;
        float:right;
        text-align: right;

       /* position: relative;
        top: 80px;*/
    }

    pre {
        font-family: Verdana, sans-serif;
        /*font-family: initial;*/
    }
</style>


<body>




<div id="all-container">


    <!-- header -->

    <?php require "../view/___header-container.php"; ?>

    <!-- end header -->

<div id="container">
    <main>

    </main>
</div>



    <!--<footer>
        <div id="footer">
            <script src="../scripts/set-theme.js"></script>


            <pre>
                <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>

        </div>
    </footer>-->

    <?php require "../view/___footer.php"; ?>






</div>






</body>
</html>