<?php
    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
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

                <div id="admin-books-header-container">

                    <h3 class="section-header section-header-books">Książki</h3>

                    <form id="change-magazine-form" action="change-magazine.php" method="post">

                        <select id="change-magazine" name="change-magazine">

                            <?php
                                query("SELECT mg.id_magazynu, mg.nazwa FROM warehouse AS mg", "createMagazineSelectList", "");
                                // id_magazynu	   nazwa
                                //      1	    magazyn nr 1
                                //      2	    magazyn nr 2
                            ?>

                        </select>

                    </form>

                </div>

                <hr id="book-details-hr-books">

                <div id="admin-search-books-div">

                    <form id="admin-search-books-form" action="change-magazine.php" method="post">

                        <span>Szukaj:</span><input type="search" name="admin-search-books-input" id="admin-search-books-input"> 
                        <input type="hidden" name="change-magazine" value="">

                    </form>

                    <a href="add-book.php">
                        <button class="add-book-button btn-link btn-link-static">
                            Dodaj
                        </button>
                   </a>

                </div>

                <div style="clear:both;"></div>

                <?php require "../view/admin/books-header.php"; // table header ?>

                <div id="books-content"> </div>

            </div> <!-- #content -->

        </main>

    </div> <!-- #container -->

    <script src="change-magazine.js"></script> <!-- handle AJAX request -->
    <script src="search-books.js"></script> <!-- handle AJAX request -->

</div>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<?php require "../view/app-error-window.php"; ?>

</body>
</html>