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

<style>
    /* (~) temporary ! */

    #all-container {
        border: 1px solid red !important;
    }

    #container {
        border: 1px solid purple;
    }

    #content {
            font-weight: normal !important;
        border: 1px solid #14ffab;
    }

    /* -------------------------------------------------------- */

    /*form#edit-book-data div {
        border: 1px solid lightgreen;
    }*/
    form#edit-book-data div p span {
        display: inline-block;
        min-width: 125px;

        border: 1px solid lightblue;
    }

</style>

<body>

<div id="all-container">

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <div id="admin-books-header-container">

                    <h3 class="section-header section-header-books">Edytuj książkę</h3>

                </div>

                <hr id="book-details-hr-edit-books">

                <div id="books-content">
                    <!-- (?) -->
                </div>

                <!-- Edytowanie danych o książce -->

                <form action="edit-book-data.php" method="post" id="edit-book-data" class="edit-book-data" name="edit-book-data"
                      enctype="multipart/form-data">

                    <!-- form       (!) label           fieldset + legend      -->

                    <!-- input      text
                                password
                                number                      -> step=""
                                search
                                checkbox                    checked
                                radio                       selected
                                tel                         disabled    required
                                email
                                date                        placeholder
                                month
                                week
                                time                        submit
                                color                       button
                                                            -->
                    <!-- <select>   size=""
                         <select multiple>     <textarea>
                                    <button>   submit       -->

                    <!-- ------------------------------------------------------------------------------------------- -->

                    <!--<label>
                        tytuł <input type="text" name="book-title">
                    </label>-->

                    <div> <!-- tytuł - varchar(255) -->
                        <p>
                            <span>
                                <label for="edit-book-title">
                                    Tytuł książki
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-title" id="edit-book-title" value="test">
                        </p>
                    </div>

                    <div> <!-- autor - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-change-author">
                                    Autor
                                </label>
                            </span>

                            <select id="edit-book-change-author"
                                    name="edit-book-change-author">
                                <?php
                                    query("SELECT au.id_autora, au.imie, au.nazwisko FROM autor AS au", "createAuthorSelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <div> <!-- rok_wydania - year(4) -->
                        <p>
                            <span>
                                <label for="edit-book-release-year">
                                    Rok wydania
                                </label>
                            </span>
                            <input type="number" min="1900" max="2023"
                                   name="edit-book-release-year" id="edit-book-release-year" value="1999">
                        </p>
                    </div>

                    <div> <!-- cena - float-->
                        <p>
                            <span>
                                <label for="edit-book-price">
                                    Cena
                                </label>
                            </span>
                            <input type="number" min="1" max="500" step="0.01"
                                   name="edit-book-price" id="edit-book-price" value="85">
                        </p>
                    </div>

                    <div> <!-- wydawnictwo - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-change-publisher">
                                    Wydawnictwo
                                </label>
                            </span>

                            <select id="edit-book-change-publisher"
                                    name="edit-book-change-publisher">
                                <?php
                                    query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM wydawcy AS wd", "createPublisherSelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <hr id="book-details-hr">

                        <!-- image_url -->

                        Zdjęcie książki <br><br>

                        <input type="file" name="edit-book-image" id="edit-book-image">

                        <!-- Walidacja + Sanityzacja -->

                    <hr id="book-details-hr">

                    <div> <!-- opis - varchar(1000) -->
                        <p>
                            <span>
                                <label for="edit-book-desc">
                                    Opis
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-desc" id="edit-book-desc" value="test">
                        </p>
                    </div>

                    <div> <!-- oprawa - varchar(255) -->
                        <p>
                            <span>
                                <label for="edit-book-cover">
                                    Oprawa
                                </label>
                            </span>

                            <select id="edit-book-cover"
                                    name="edit-book-cover">
                                <option value="twarda">Twarda</option>
                                <option value="miekka">Miękka</option>
                            </select>
                        </p>
                    </div>

                    <div> <!-- ilość_stron - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-pages">
                                    Ilość stron
                                </label>
                            </span>
                            <input type="number" min="1" max="1500" step="1"
                                   name="edit-book-pages" id="edit-book-pages" value="450">
                        </p>
                    </div>

                    <div> <!-- Wymiary - varchar(25) -->
                        <p>
                            <span>
                                <label for="edit-book-dims">
                                    Wymiary (!) JS -> Validation
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-dims" id="edit-book-dims" value="test">
                        </p>
                    </div>

                    <hr id="book-details-hr">

                    <div> <!-- kategoria - (to pole nie istnieje w tablie książki) -->
                        <p>
                            <span>
                                <label for="edit-book-category">
                                    Kategoria
                                </label>
                            </span>

                            <select id="edit-book-category"
                                    name="edit-book-category">
                                <?php
                                    query("SELECT kt.id_kategorii, kt.nazwa FROM kategorie AS kt", "createCategorySelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <div> <!-- podkategoria -->
                        <p>
                            <span>
                                <label for="edit-book-subcategory">
                                    Kategoria
                                </label>
                            </span>

                            <select id="edit-book-subcategory"
                                    name="edit-book-subcategory">
                                <?php
                                query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subkategorie AS subkt", "createSubcategorySelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <input type="submit">

                </form>

            </div> <!-- #content -->

        </main>
    </div> <!-- #container -->

</div> <!-- #all-container -->

</body>
</html>