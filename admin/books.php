<?php
    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ../user/___index2.php?login-error");
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

<div id="all-container">

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <div id="admin-books-header-container"> <!-- "Książki" + lista <select> z wyborem magazynu -->

                    <h3 class="section-header section-header-books">Książki</h3>

                    <form id="change-magazine-form" action="change-magazine.php" method="post">
                        <select id="change-magazine" name="change-magazine"> <!-- js manage "change" event for <select> list, and then sends the <form>; -->
                            <?php
                                query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
                            ?>
                        </select>
                    </form>

                </div>

                <hr id="book-details-hr-books">

                <?php require "../view/admin/books-header.php"; // table header ?>

                <div id="books-content"></div> <!-- here are inserted rows with information about books; -->

            </div> <!-- #content -->

        </main>

    </div> <!-- #container -->

    <script src="change-magazine.js"></script> <!-- handle AJAX request -->

</div>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

</body>
</html>