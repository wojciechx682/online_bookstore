<?php
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

                <div id="admin-books-header-container"> <!-- "książki" + lista <select> z wyborem magazynu -->

                    <h3 class="section-header section-header-books">Książki</h3>

<form id="change-magazine-form" action="change-magazine.php" method="post">

    <select id="change-magazine" name="change-magazine">

        <!-- js manage "change" event for <select> list, and then sends the <form>; -->

        <?php
            query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
        ?>

    </select>

</form>

                </div> <!-- #admin-books-header-container -->

                <hr id="book-details-hr-books">

                <?php require "../view/admin/books-header.php"; // table header ?>

                <div id="books-content"></div> <!-- here are inserted rows with information about books; - change-magazine.js - change-magazine.php - data from server; -->

            </div> <!-- #content -->

        </main>

    </div> <!-- #container -->

    <script src="change-magazine.js"></script> <!-- handle AJAX request -->

</div>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

</body>
</html>