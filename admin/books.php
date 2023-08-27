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

<!--<div id="div-search-books-admin">
    <form id="search-books-form-admin" action="books.php" method="post" >
        <input type="search" name="input-search" id="input-search-books-admin" >
        <input type="submit" value=" ">
    </form>
</div>-->

                <?php
                    echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr>";
                ?>


                <form id="change-magazine-form" action="change-magazine.php" method="post"> <!-- list <select> z wyborem magazynu -->

                    <select id="change-magazine" name="change-magazine">

                        <!-- js manage "change" event for <select> list, and then sends the <form>; -->

                        <?php
                            query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
                            // id_magazynu	   nazwa
                            //      1	    magazyn nr 1
                            //      2	    magazyn nr 2
                        ?>

                    </select>

                </form>

                </div> <!-- #admin-books-header-container -->

                <hr id="book-details-hr-books">

                <div id="admin-search-books-div">
                    <form id="admin-search-books-form" action="change-magazine.php" method="post">
                        <span>Szukaj:</span><input type="search" name="admin-search-books-input" id="admin-search-books-input"> <!-- placeholder="tytuł książki" -->
                        <input type="hidden" name="change-magazine" value="">

                        <!--<input type="submit" value=" ">-->
                    </form>

                    <!--<button class="add-book-button btn-link btn-link-static">
                        <a href="add-book.php">
                            Dodaj
                        </a>
                    </button>-->

                    <a href="add-book.php">
                        <button class="add-book-button btn-link btn-link-static">
                            Dodaj
                        </button>
                   </a>


                </div>

                <div style="clear:both;"></div>


                <!-- <div id="div-search">
                    <form id="search-form" action="---.php" method="post">
                        <input type="search" name="input-search" id="input-search">

                        <input type="submit" value=" ">
                    </form>
                </div> -->

                <?php require "../view/admin/books-header.php"; // table header ?>

                <div id="books-content"></div> <!-- here are inserted rows with information about books; - change-magazine.js - change-magazine.php - data from server; -->



            </div> <!-- #content -->

        </main>

    </div> <!-- #container -->

    <script src="change-magazine.js"></script> <!-- handle AJAX request -->
    <script src="search-books.js"></script> <!-- handle AJAX request -->

</div>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script>
    // sortowanie tabeli -->


</script>

</body>
</html>