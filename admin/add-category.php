<?php
// check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
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

                <header>
                    <h3 class="section-header">Edytuj kategorię</h3>
                </header>

                <!-- Zmiana nazwy kategorii -->

                <form method="post"
                      action="add-category.php"
                      id="add-category"
                      class="edit-category"
                      name="edit-category">


                    <div> <!-- tytuł - varchar(255) -->
                        <p>
                                <span style="margin-right: 15px;">
                                    <label for="edit-category-name">
                                        Nazwa kategorii
                                    </label>
                                </span>
                            <input type="text" required maxlength="100" size="100" autofocus
                                   name="add-category-name"
                                   id="edit-category-name"
                                   value="" >
                        </p>
                    </div>

                    <input type="submit" id="input-submit-edit-category" value="Dodaj kategorię">

                </form>

                <div class="result edit-book-result"></div>

            </div> <!-- #content -->

        </main>

    </div> <!-- #container -->

</div> <!-- #all-container -->

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="add-category.js"></script> <!-- (!) nazwa robocza !!! -->


</body>
</html>