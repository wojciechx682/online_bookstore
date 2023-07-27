<?php
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

                    <form action="add-book-data.php"
                          method="post"
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
                                    <input type="text"
                                           name="add-book-title" id="add-book-title">
                            </p>
                        </div>

                        <div> <!-- autor - int(11) -->
                            <p>
                                <span>
                                    <label for="add-book-author">
                                        Autor
                                    </label>
                                </span>

                                <select id="add-book-author"
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
                                           name="add-book-release-year" id="add-book-release-year">
                            </p>
                        </div>

                        <div> <!-- cena - float-->
                            <p>
                                <span>
                                    <label for="add-book-price">
                                        Cena
                                    </label>
                                </span>
                                    <input type="number" min="1" max="500" step="0.01"
                                           name="add-book-price" id="add-book-price">
                            </p>
                        </div>

                        <div> <!-- wydawnictwo - int(11) -->
                            <p>
                                <span>
                                    <label for="add-book-publisher">
                                        Wydawnictwo
                                    </label>
                                </span>

                                    <select id="add-book-publisher"
                                            name="add-book-publisher">
                                        <?php
                                            query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM wydawcy AS wd", "createPublisherSelectList", "");
                                        ?>
                                    </select>
                            </p>
                        </div>

                        <hr id="book-details-hr">

                        <label for="add-book-image" class="add-book-image btn-link btn-link-static">
                            Wybierz plik
                        </label>

                        <input
                                style="opacity: 0;"
                                type="file" name="add-book-image" id="add-book-image"> <!-- accept="image/*" -->
                        <!-- accept=".jpg, .jpeg, .png" -->
                        <!-- <button class="update-order-status btn-link btn-link-static">Aktualizuj</button> -->
                        <!-- <input type="file" name="edit-book-image" id="edit-book-image"
                                           class="btn-link btn-link-static"> -->
                        <div class="preview">
                            <p>No files currently selected for upload</p>
                        </div>

                        <hr id="book-details-hr">

                        <div> <!-- opis - varchar(1000) -->
                            <p>
                            <span>
                                <label for="add-book-desc">
                                    Opis
                                </label>
                            </span>
                                <input type="text"
                                       name="add-book-desc" id="add-book-desc">
                            </p>
                        </div>

                        <div> <!-- oprawa - varchar(255) -->
                            <p>
                            <span>
                                <label for="add-book-cover">
                                    Oprawa
                                </label>
                            </span>

                                <select id="add-book-cover"
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
                                <input type="number" min="1" max="1500" step="1"
                                       name="add-book-pages" id="add-book-pages">
                            </p>
                        </div>

                        <div> <!-- Wymiary - varchar(25) -->
                            <p>
                                <span>
                                    <label for="add-book-dims">
                                        Wymiary
                                    </label>
                                </span>
                                    <input type="text"
                                           name="add-book-dims" id="add-book-dims">
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

                                <select id="add-book-category"
                                        name="add-book-category"
                                        onchange="getSubcategories(this)">
                                    <?php
                                        query("SELECT kt.id_kategorii, kt.nazwa FROM kategorie AS kt", "createCategorySelectList", "");
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- podkategoria -->
                            <p>
                                <span>
                                    <label for="add-book-subcategory">
                                        Podkategoria
                                    </label>
                                </span>

                                <!--<select id="add-book-subcategory"-->
                                <select id="book-subcategory"
                                        name="add-book-subcategory">
                                    <?php
                                        query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subkategorie AS subkt", "createSubcategorySelectList", "");
                                    ?>
                                </select>
                            </p>
                        </div>

                        <hr id="book-details-hr">

                        <div>
                            <p>
                                <span>
                                    <label for="add-book-magazine">
                                        Magazyn
                                    </label>
                                </span>

                                <select id="change-magazine" name="change-magazine">

                                    <?php
                                        query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
                                        // id_magazynu	   nazwa
                                        //      1	    magazyn nr 1
                                        //      2	    magazyn nr 2
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- tytuł - varchar(255) -->
                            <p>
                                <span>
                                    <label for="add-book-quantity">
                                        Ilość egzemplarzy
                                    </label>
                                </span>
                                <input type="number" step="1" min="1" max="5000"
                                       name="add-book-quantity" id="add-book-quantity">
                            </p>
                        </div>

                        <!--<input type="hidden" value="" name="edit-book-id" id="edit-book-id">--> <!-- id_ksiązki - int(11) -->

                        <input type="submit" id="input-submit-add-book-data">



                    </form>

                    <div class="result"></div> <!-- (?) -->

                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

        <!-- brauke footer'a w tym miejscu ? -->

    </div> <!-- #main-container -->

    <script src="category.js"></script> <!-- (!) nazwa robocza !!! -->

    <script src="add-book.js"></script> <!-- JS -> AJAX -> add-book-data.php -->

</body>
</html>