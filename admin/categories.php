<?php
    require_once "../authenticate-admin.php"; // Uwierzytelnienie administratora, przed dostępem do panelu admina - Czy jest zalogowany ? Czy jest to pracownik ?
                                              // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
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

                <?php /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr>"*/ ?>

                <header>
                    <h3 class="section-header categories-header">Kategorie</h3>

                    <a href="add-category.php">
                        <button class="add-book-button btn-link btn-link-static">
                            Dodaj
                        </button>
                    </a>
                </header>

                <div style="clear: both;"></div>

                <div class="categories-hr"></div>

                <?php
                    query("SELECT kt.id_kategorii, kt.nazwa FROM categories AS kt", "getCategoriesAdmin", "");
                ?>

            </div>

        </main>

    </div>

</div>

<?php require "../view/app-error-window.php"; ?>

</body>

</html>