<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
    require_once "../authenticate-admin.php";

    $bookId = filter_var($_POST["book-id"], FILTER_VALIDATE_INT); // validate book-id and warehouse-id (POST);
    $_SESSION["warehouseId"] = filter_var($_POST["warehouse-id"], FILTER_VALIDATE_INT);

    if ($bookId === false || $_SESSION["warehouseId"] === false) {
        header('Location: books.php');
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
                        <h3 class="section-header">Edytuj książkę</h3>
                    </header>

                    <?php
                        /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                    ?>

                    <!--<hr id="book-details-hr-edit-books">-->

                    <?php

                    $bookData = query("SELECT ks.id_ksiazki, ks.tytul, ks.id_autora, ks.rok_wydania, ks.cena, ks.id_wydawcy, ks.image_url, ks.opis, ks.oprawa, ks.ilosc_stron, ks.wymiary, ks.id_subkategorii, kt.id_kategorii, mgk.id_magazynu, mgk.ilosc_dostepnych_egzemplarzy AS ilosc_egzemplarzy FROM books AS ks, subcategories AS subkt, categories AS kt, warehouse_books AS mgk WHERE ks.id_ksiazki = '%s' AND mgk.id_magazynu = '%s' AND subkt.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = subkt.id_subkategorii AND ks.id_ksiazki = mgk.id_ksiazki", "getBookData", [$bookId, $_SESSION["warehouseId"]]);

                        //echo " book data --> <br><br>";
                        //echo $bookData; exit();

                    ?>

                    <script>

                            //let bookId = '<?php //echo $_POST["book-id"]; ?>'; // walidacja / sanityzacja ?




                        // $_POST value is retrieved from admin\books.php -> "Edytuj" button (input type="submit");

                        // 1 | Symfonia C++ wydanie V | 1 | 2009 | 10 | 2 | Lorem ipsum dolor sit amet, consectetur adipiscing... | twarda | 585	| 411 x 382 x 178 | 1 | 4

                        //bookData = JSON.parse(bookData);
                            let bookData = <?php echo json_encode($bookData); ?>;
                            console.log("\nbookData -> ", bookData);
                            //console.log("\nbookData -> ", bookData);

                    </script>

                        <!-- <div id="books-content"> </div> -->

                    <!-- Edytowanie danych o książce -->

                    <form method="post"
                          action="edit-book-data.php"
                              id="edit-book-data"
                              class="edit-book-data"
                              name="edit-book-data"
                          enctype="multipart/form-data">

                        <div> <!-- tytuł - varchar(255) -->
                            <p>
                                <span>
                                    <label for="edit-book-title">
                                        Tytuł książki
                                    </label>
                                </span>
                                <input type="text" required maxlength="255" size="255" autofocus
                                       name="edit-book-title"
                                       id="edit-book-title">
                            </p>
                        </div>

                        <div> <!-- autor - int(11) -->
                            <p>
                                <span>
                                    <label for="edit-book-change-author">
                                        Autor
                                    </label>
                                </span>

                                <select id="edit-book-change-author" required
                                        name="edit-book-change-author">
                                    <?php
                                        query("SELECT au.id_autora, au.imie, au.nazwisko FROM author AS au", "createAuthorSelectList", "");
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
                                       name="edit-book-release-year" id="edit-book-release-year" required>
                            </p>
                        </div>

                        <div> <!-- cena - float-->
                            <p>
                                <span>
                                    <label for="edit-book-price">
                                        Cena
                                    </label>
                                </span>
                                <input type="number" min="1" max="1000" step="0.01" autocomplete="off"
                                       name="edit-book-price" id="edit-book-price" required>
                            </p>
                        </div>

                        <div> <!-- wydawnictwo - int(11) -->
                            <p>
                                <span>
                                    <label for="edit-book-change-publisher">
                                        Wydawnictwo
                                    </label>
                                </span>

                                <select id="edit-book-change-publisher" required
                                        name="edit-book-change-publisher">
                                    <?php
                                        query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM publishers AS wd", "createPublisherSelectList", "");
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

                                <label for="edit-book-image" class="edit-book-image btn-link btn-link-static">
                                    Wybierz plik
                                </label>

                                <input
                                    style="/*opacity: 0;*/ display: none;"
                                    type="file"
                                        name="edit-book-image"
                                        id="edit-book-image"
                                    accept="image/*">

                                <div class="preview">
                                    <p>Nie wybrano żadnego pliku</p>
                                </div>
                            </p>
                        </div>

                                <!--<label for="edit-book-image" class="edit-book-image btn-link btn-link-static">
                                    Wybierz plik
                                </label>

                            <input
                                    style="/*opacity: 0;*/ display: none;"
                                    type="file"
                                    name="edit-book-image"
                                    id="edit-book-image">

                            <div class="preview">
                                <p>Nie wybrano żadnego pliku</p>
                            </div>-->

                        <hr id="book-details-hr">

                        <div> <!-- opis - varchar(10000) -->
                            <p>
                                <span id="span-book-desc">
                                    <label for="edit-book-desc">
                                        Opis
                                    </label>
                                </span>
                                    <!--<input type="text" required
                                           name="edit-book-desc" id="edit-book-desc">-->

                                    <textarea name="edit-book-desc" id="edit-book-desc"
                                              rows="5"
                                              minlength="10"
                                              maxlength="10000" required></textarea>
                            </p>
                        </div>

                        <div> <!-- oprawa - varchar(255) -->
                            <p>
                                <span>
                                    <label for="edit-book-cover">
                                        Oprawa
                                    </label>
                                </span>

                                <select id="edit-book-cover" required
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
                                       name="edit-book-pages" id="edit-book-pages" required>
                            </p>
                        </div>

                        <div> <!-- Wymiary - varchar(25) -->
                            <p>
                                <span>
                                    <label for="edit-book-dims">
                                        Wymiary
                                    </label>
                                </span>
                                <input type="text" maxlength="15"
                                       name="edit-book-dims" id="edit-book-dims" required>
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

                                <select id="edit-book-category" required
                                        name="edit-book-category"
                                        onchange="getSubcategories(this)">
                                    <?php
                                        query("SELECT kt.id_kategorii, kt.nazwa FROM categories AS kt", "createCategorySelectList", "");
                                        // <option value={id-kategorii} > "28"
                                        // <option value={id-kategorii} > "34"
                                        // <option value={id-kategorii} > "26"
                                    ?>
                                </select>
                            </p>
                        </div>

                        <div> <!-- podkategoria -->
                            <p>
                                <span>
                                    <label for="book-subcategory">
                                        Podkategoria
                                    </label>
                                </span>

                                <!--<select id="edit-book-subcategory"-->
                                <select id="book-subcategory" required
                                        name="edit-book-subcategory">
                                    <?php
                                        query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subcategories AS subkt", "createSubcategorySelectList", "");
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
                                    <label for="edit-book-select-magazine">
                                        Magazyn
                                    </label>
                                </span>
                                <input type="number" disabled readonly id="edit-book-select-magazine-readonly">
                                <input type="hidden" value="" name="edit-book-select-magazine" id="edit-book-select-magazine">



                                <!--<select  id="edit-book-select-magazine" name="edit-book-select-magazine">-->

                                    <?php
                                        //query("SELECT mg.id_magazynu, mg.nazwa FROM magazyn AS mg", "createMagazineSelectList", "");
                                            // id_magazynu	   nazwa
                                            //      1	    magazyn nr 1
                                            //      2	    magazyn nr 2

                                            // <option value={id-magazynu}> "1"
                                            // <option value={id-magazynu}> "2"
                                    ?>
                                <!--</select>-->
                            </p>
                        </div>

                        <div> <!-- 	ilosc_dostepnych_egzemplarzy - varchar(255) -->
                            <p>
                                <span>
                                    <label for="edit-book-quantity">
                                        Ilość egzemplarzy
                                    </label>
                                </span>
                                <input type="number" step="1" min="0" max="5000"
                                       name="edit-book-quantity" id="edit-book-quantity">
                            </p>
                        </div>

                        <input type="hidden" value="" name="edit-book-id" id="edit-book-id"> <!-- id_ksiązki - int(11) -->
                        <input type="hidden" value="" name="edit-book-image_url" id="edit-book-image_url"> <!-- image_url -->

                        <input type="submit" id="input-submit-edit-book-data" value="Edytuj dane">

                    </form>

                    <div class="result edit-book-result"></div>

                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

    </div> <!-- #all-container -->

<script>

    // other fields validation; - in "category.js" file;

    $("#edit-book-title").val(bookData[0]["tytul"]); // Fill form data with book data retrieved from DB;
    $("#edit-book-id").val(bookData[0]["id_ksiazki"]); // used jQ because performance difference is minimal;
    $("#edit-book-change-author").val(bookData[0]["id_autora"]); // Change to the value attribute for <option>;
    $("#edit-book-release-year").val(bookData[0]["rok_wydania"]);
    $("#edit-book-price").val(bookData[0]["cena"]);
    $("#edit-book-change-publisher").val(bookData[0]["id_wydawcy"]);
    $("#edit-book-desc").val(bookData[0]["opis"]);
    $("#edit-book-pages").val(bookData[0]["ilosc_stron"]);
    $("#edit-book-dims").val(bookData[0]["wymiary"]);
    $("#edit-book-category").val(bookData[0]["id_kategorii"]);
    $("#edit-book-subcategory").val(bookData[0]["id_subkategorii"]);
        $("#edit-book-image_url").val(bookData[0]["image_url"]); // ?
    $("#edit-book-select-magazine").val(bookData[0]["id_magazynu"]); // input type hidden
    $("#edit-book-select-magazine-readonly").val(bookData[0]["id_magazynu"]);
    $("#edit-book-quantity").val(bookData[0]["ilosc_egzemplarzy"]);

</script>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="category.js"></script> <!-- (!) nazwa robocza !!! -->
    <script src="validate-file.js"></script> <!-- js input file validation -->

</body>
</html>