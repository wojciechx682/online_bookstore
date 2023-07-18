<?php

    // Uwierzytelnienie administratora, przed dostępem do panelu admina - Czy jest zalogowany ? Czy jest to pracownik ?
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

    <div id="main-container">

        <div id="container">

            <main>

                <?php require "../template/admin/nav.php"; ?>

                <?php require "../template/admin/top-nav.php"; ?>

                <div id="content">



                </div>

            </main>

        </div> <!-- #container -->

        <!-- brauke footer'a w tym miejscu ? -->

    </div> <!-- #main-container -->

</body>

</html>