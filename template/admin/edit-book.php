<form action="edit-book-data.php" method="post" id="edit-book-data" class="edit-book-data" name="edit-book-data"
      enctype="multipart/form-data">

    <div> <!-- tytuł - varchar(255) -->
        <p>
                            <span>
                                <label for="edit-book-title">
                                    Tytuł książki
                                </label>
                            </span>
            <input type="text"
                   name="edit-book-title" id="edit-book-title" value="%s">
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
                   name="edit-book-release-year" id="edit-book-release-year" value="%s">
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
                    query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM publishers AS wd", "createPublisherSelectList", "");
                ?>
            </select>
        </p>
    </div>

    <hr id="book-details-hr">

    <input type="file" name="edit-book-image" id="edit-book-image">

    <div class="preview">
        <p>No files currently selected for upload</p>
    </div>

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
                   name="edit-book-desc" id="edit-book-desc" value="%s">
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
                   name="edit-book-pages" id="edit-book-pages" value="%s">
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
                   name="edit-book-dims" id="edit-book-dims" value="%s">
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
                    name="edit-book-category"
                    onchange="getSubcategories(this)">
                <?php
                    query("SELECT kt.id_kategorii, kt.nazwa FROM categories AS kt", "createCategorySelectList", "");
                ?>
            </select>
        </p>
    </div>

    <div> <!-- podkategoria -->
        <p>
                            <span>
                                <label for="edit-book-subcategory">
                                    Podkategoria
                                </label>
                            </span>

            <select id="edit-book-subcategory"
                    name="edit-book-subcategory">
                <?php
                    query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subcategories AS subkt", "createSubcategorySelectList", "");
                ?>
            </select>
        </p>
    </div>

    <input type="submit">

</form>

<div class="result">

</div>
