<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
    require_once "../authenticate-admin.php";

    $categoryId = filter_var($_POST["category-id"], FILTER_VALIDATE_INT); // validate category-id (POST);
    $categoryName = filter_var($_POST["category-name"], FILTER_SANITIZE_STRING); // validate category-id (POST);


    // check if that category exists (id);
        //unset($_SESSION["category-exists"]);
    $categoryExists = query("SELECT kt.nazwa FROM categories AS kt WHERE kt.id_kategorii = '%s' AND kt.nazwa = '%s'", "verifyCategoryExists", [$categoryId, $categoryName]); // $_SESSION["category-exists"] --> true / null;

    if (empty($categoryId) || empty($categoryExists)) {

        $_SESSION["application-error"] = true;

        unset($_POST);
            header('Location: categories.php', true, 303);
                exit();
    }

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

                        <!--<div id="admin-books-header-container">
                            <h3 class="section-header section-header-books">Edytuj książkę</h3>
                        </div>-->

                    <header>
                        <h3 class="section-header">Edytuj kategorię</h3>
                    </header>


                    <!-- Zmiana nazwy kategorii -->

                    <form method="post"
                          action="edit-category.php"
                              id="edit-category"
                              class="edit-category"
                              name="edit-category">


                        <div> <!-- tytuł - varchar(255) -->
                            <p>
                                <span>
                                    <label for="edit-category-name">
                                        Nazwa kategorii
                                    </label>
                                </span>
                                <input type="text" required maxlength="100" size="100" autofocus
                                       name="edit-category-name"
                                       id="edit-category-name"
                                       value="<?= $categoryName; ?>" >
                            </p>
                        </div>

                        <input type="hidden" value="<?= $categoryId; ?>" name="edit-category-id" id="edit-category-id"> <!-- id_kategorii - int(11) -->

                        <input type="submit" id="input-submit-edit-category" value="Edytuj dane">

                    </form>

                    <div class="result edit-book-result"></div>

                </div>

            </main>

        </div>

    </div>


<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="edit-category.js"></script> <!-- (!) nazwa robocza !!! -->


</body>
</html>