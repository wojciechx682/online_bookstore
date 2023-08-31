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
                        <h3 class="section-header">Dodaj książkę</h3>
                    </header>

                    <!-- Dodanie nowej książki do magazynu -->

                    <!-- usunąć atrybuty value z inputów -->

                    <form method="post"
                          action="add-book-data.php"
                              id="add-book-data"
                              class="add-book-data"
                              name="add-book-data"
                          enctype="multipart/form-data">

                        <div> <!-- tytuł - varchar(255) -->
                            <p>
                                <span>
                                    <label for="add-book-title">
                                        Tytuł książki
                                    </label>
                                </span>
                                <input type="text" required maxlength="255" size="255" autofocus
                                   value="Symfonia C++"
                                       name="add-book-title" id="add-book-title"> <!-- value - usunąć ten atrybut ! -->
                            </p>
                        </div>

                        <div> <!-- autor - int(11) -->
                            <p>
                                <span>
                                    <label for="add-book-author">
                                        Autor
                                    </label>
                                </span>

                                <select id="add-book-author" required
                                        name="add-book-author">
                                    <?php
                                        query("SELECT au.id_autora, au.imie, au.nazwisko FROM autor AS au", "createAuthorSelectList", "");
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- rok_wydania - year(4) -->
                            <p>
                                <span>
                                    <label for="add-book-release-year">
                                        Rok wydania
                                    </label>
                                </span>
                                <input type="number" min="1900" max="2023"
                                       name="add-book-release-year" id="add-book-release-year" required
                                       value="2015">
                            </p>
                        </div>

                        <div> <!-- cena - float-->
                            <p>
                                <span>
                                    <label for="add-book-price">
                                        Cena
                                    </label>
                                </span>
                                <input type="number" min="1" max="1000" step="0.01" autocomplete="off"
                                       name="add-book-price" id="add-book-price" required
                                       value="65.55">
                            </p>
                        </div>

                        <div> <!-- wydawnictwo - int(11) -->
                            <p>
                                <span>
                                    <label for="add-book-publisher">
                                        Wydawnictwo
                                    </label>
                                </span>

                                <select id="add-book-publisher" required
                                        name="add-book-publisher">
                                    <?php
                                        query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM wydawcy AS wd", "createPublisherSelectList", "");
                                    ?>
                                </select>
                            </p>
                        </div>

                        <hr id="book-details-hr">

                        <div>
                            <p>
                                <span>
                                    <label>     <!-- for="add-book-image" -->
                                        Zdjęcie książki
                                    </label>
                                </span>

                                <label for="add-book-image" class="add-book-image btn-link btn-link-static">
                                    Wybierz plik
                                </label>

                                <input
                                    style="/*opacity: 0;*/ display: none;"
                                    type="file"
                                        name="add-book-image"
                                        id="add-book-image"
                                    accept="image/*">

                                <div class="preview">
                                    <p>Nie wybrano żadnego pliku</p>
                                </div>
                            </p>
                        </div>

                            <!--<label for="add-book-image" class="add-book-image btn-link btn-link-static">
                                Wybierz plik
                            </label>-->

                        <!--<input
                                style="/*opacity: 0;*/ display: none;"
                                type="file"
                                name="add-book-image"
                                id="add-book-image"
                                accept="image/*">

                        <div class="preview">
                            <p>No files currently selected for upload</p>
                        </div>-->

                        <hr id="book-details-hr">

                        <div> <!-- opis - varchar(1000) -->
                            <p>
                                <span id="span-book-desc">
                                    <label for="add-book-desc">
                                        Opis
                                    </label>
                                </span>
                                    <!--<input type="text" required
                                       name="add-book-desc" id="add-book-desc">-->

                                <textarea name="add-book-desc" id="add-book-desc"
                                          rows="5"
                                          minlength="10" maxlength="1000" required></textarea>
                            </p>
                        </div>

                        <div> <!-- oprawa - varchar(255) -->
                            <p>
                                <span>
                                    <label for="add-book-cover">
                                        Oprawa
                                    </label>
                                </span>

                                <select id="add-book-cover" required
                                        name="add-book-cover">
                                    <option value="twarda">Twarda</option>
                                    <option value="miekka">Miękka</option>
                                </select>
                            </p>
                        </div>

                        <div> <!-- ilość_stron - int(11) -->
                            <p>
                                <span>
                                    <label for="add-book-pages">
                                        Ilość stron
                                    </label>
                                </span>
                                <input type="number" min="1" max="1500" step="1" value="425"
                                           name="add-book-pages" id="add-book-pages" required>
                            </p>
                        </div>

                        <div> <!-- Wymiary - varchar(25) -->
                            <p>
                                <span>
                                    <label for="add-book-dims">
                                        Wymiary
                                    </label>
                                </span>
                                    <input type="text" maxlength="15" value="125 x 730 x 310"
                                           name="add-book-dims" id="add-book-dims" required>
                            </p>
                        </div>

                        <hr id="book-details-hr">

                        <div> <!-- kategoria - (to pole nie istnieje w tablie książki) -->
                            <p>
                                <span>
                                    <label for="add-book-category">
                                        Kategoria
                                    </label>
                                </span>

                                <select id="add-book-category" required
                                        name="add-book-category"
                                        onchange="getSubcategories(this)">
                                    <?php
                                        query("SELECT kt.id_kategorii, kt.nazwa FROM kategorie AS kt", "createCategorySelectList", "");
                                        // <option value={id-kategorii}> "28"
                                        // <option value={id-kategorii}> "34"
                                        // <option value={id-kategorii}> "26"
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- podkategoria int(11)-->
                            <p>
                                <span>
                                    <label for="book-subcategory">
                                        Podkategoria
                                    </label>
                                </span>

                                <!--<select id="add-book-subcategory"-->
                                <select id="book-subcategory" required
                                        name="add-book-subcategory">
                                    <?php
                                        query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subkategorie AS subkt", "createSubcategorySelectList", "");

                                        // <option value={id-PODkategorii} > "28"
                                        // <option value={id-PODkategorii} > "34"
                                        // <option value={id-PODkategorii} > "26"
                                    ?>
                                </select>
                            </p>
                        </div>

                        <hr id="book-details-hr">

                        <div>
                            <p>
                                <span>
                                    <label for="add-book-select-magazine">
                                        Magazyn
                                    </label>
                                </span>

                                <select id="add-book-select-magazine" name="add-book-select-magazine">

                                    <?php
                                        query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
                                        // id_magazynu	   nazwa
                                        //      1	    magazyn nr 1
                                        //      2	    magazyn nr 2

                                        // <option value={id-magazynu}> "1"
                                        // <option value={id-magazynu}> "2"
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- 	ilosc_dostepnych_egzemplarzy - varchar(255) -->
                            <p>
                                <span>
                                    <label for="add-book-quantity">
                                        Ilość egzemplarzy
                                    </label>
                                </span>
                                <input type="number" step="1" min="0" max="5000" value="125"
                                       name="add-book-quantity" id="add-book-quantity">
                            </p>
                        </div>

                        <!--<input type="hidden" value="" name="edit-book-id" id="edit-book-id">--> <!-- id_ksiązki - int(11) -->

                        <input type="submit" id="input-submit-add-book-data">

                    </form>

                    <div class="result add-book-result"></div> <!-- response message from server -->

                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

        <!-- brauke footer'a w tym miejscu ? -->

    </div> <!-- #main-container -->

        <img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

    <script src="category.js"></script> <!-- (!) nazwa robocza !!! -->

    <script src="add-book.js"></script> <!-- JS -> AJAX -> add-book-data.php -->
        <script src="validate-file.js"></script> <!-- js input file validation -->

    <script>
        document.querySelector('textarea').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
    </script>



</body>
</html>