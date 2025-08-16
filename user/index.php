<?php

    require_once "../start-session.php";

    function sanitizeAndValidateInput($inputType, $inputName, $filterType) {
        // do rozbudowy w przyszłości - można dodać kolejny parametr (pierwszy) jako funkcję która ma zostać wywołana do filtracji (np filter_var lub filter_input) - wtedy by to była funkcja typu callback
        return filter_input($inputType, $inputName, $filterType);
    }
    function validateSearchNavTitle() {
        /*  Sanityzuje i waliduje pole 'input-search-nav' wysyłane metodą POST.
            - Jeśli dane są poprawne, zapisuje je do $_SESSION["input-search-nav"]
            - Jeśli są puste lub zmienione przez filtrację, ustawia $_SESSION["application-error"]
            i usuwa dane z $_SESSION oraz $_POST
            Przeznaczenie: lewy pasek wyszukiwania tytułu książki */
        $title = sanitizeAndValidateInput(INPUT_POST, "input-search-nav", FILTER_SANITIZE_STRING);
        $_SESSION["input-search-nav"] = $title;
        if (empty($title) || ($_SESSION["input-search-nav"] !== $_POST["input-search-nav"])) {
            $_SESSION["application-error"] = true;
            unset($_POST, $title, $_SESSION["input-search-nav"]);
        }
    }
    function validateCategory() {

        if ($_POST["category"] != "Wszystkie") { // "Informatyka", "Dla dzieci", ...

            $category = sanitizeAndValidateInput(INPUT_POST, "category", FILTER_SANITIZE_STRING);
            $_SESSION["category"] = $category;

            $categoryExists = query("SELECT nazwa FROM categories WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["category"]); // --> returns true - if category exists;

            if (empty($category) || ($_SESSION["category"] !== $_POST["category"]) || empty($categoryExists)) {

                $_SESSION["application-error"] = true;
                unset($_POST, $category, $_SESSION["category"], $_SESSION["subcategory"], $categoryExists, $subcategoryExists);

            } else { // validation OK (passed tests)

                if (isset($_POST["subcategory"])) {

                    $subcategory = sanitizeAndValidateInput(INPUT_POST, "subcategory", FILTER_SANITIZE_STRING);
                    $_SESSION["subcategory"] = $subcategory;
                    $subcategoryExists = query("SELECT nazwa FROM subcategories WHERE nazwa = '%s'", "verifySubcategoryExists", $_SESSION["subcategory"]); // --> returns true - if subcaterogy exists;

                    if (empty($subcategory) || ($_SESSION["subcategory"] !== $_POST["subcategory"]) || empty($subcategoryExists)) {

                        $_SESSION["application-error"] = true;
                        unset($_POST, $category, $subcategory, $_SESSION["category"], $_SESSION["subcategory"], $categoryExists, $subcategoryExists);
                    }

                } else {
                    unset($_SESSION["subcategory"]);
                }
            }

        } else {
            $_SESSION["category"] = "Wszystkie";
            unset($_SESSION["subcategory"], $categoryExists, $subcategoryExists);
        }
    }
    function validateMainInputSearch() {
        $searchValue = sanitizeAndValidateInput(INPUT_POST, "input-search", FILTER_SANITIZE_STRING);
        $_SESSION["input-search"] = $searchValue;
        $_SESSION["category"] = "Wszystkie";

        if (empty($searchValue) || ($_SESSION["input-search"] !== $_POST["input-search"])) {
            $_SESSION["application-error"] = true;
            unset($_POST, $searchValue, $_SESSION["input-search"], $_SESSION["category"], $_SESSION["subcategory"]);

        } else {
            unset($_SESSION["subcategory"]);
        }
    }

    function validateAdvancedSearch() {
        $valid = true; // validation flag
        $category = sanitizeAndValidateInput(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
        $_SESSION["adv-search-category"] = $category;
        $_SESSION["category"] = $category;
        unset($_SESSION["subcategory"]);

        if (empty($category) || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"]) || strlen($category)>100) {
            $valid = false;
        } else {
            // validation OK (passed)
            if ($_SESSION["adv-search-category"] != "Wszystkie") {

                $categoryExists = query("SELECT nazwa FROM categories WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["adv-search-category"]);

                if (empty($categoryExists)) {
                    unset($categoryExists);
                    $valid = false;
                }
            }
        }
        $_SESSION["adv-search-query"] = "SELECT
                                ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                kt.nazwa, sb.id_kategorii,
                                au.imie, au.nazwisko,
                                SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                            FROM
                                books AS ks
                            JOIN
                                author AS au ON ks.id_autora = au.id_autora
                            JOIN
                                subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                            JOIN
                                categories AS kt ON sb.id_kategorii = kt.id_kategorii
                            LEFT JOIN
                                warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                            ";

        if (!empty($_POST["adv-search-title"])) {

            $title = sanitizeAndValidateInput(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
            $_SESSION["adv-search-title"] = $title;

            if (empty($title) || ($_SESSION["adv-search-title"] !== $_POST["adv-search-title"]) || strlen($title)>255 ) {
                $valid = false;
            }
        }

        if (!empty($_POST["adv-search-author"])) {

            $maxAuthorId = query("SELECT MAX(id_autora) AS id_autora FROM author", "getAuthorId", "");
            $author = sanitizeAndValidateInput(INPUT_POST, "adv-search-author", FILTER_SANITIZE_NUMBER_INT);

            $_SESSION["adv-search-author"] = filter_var($author, FILTER_VALIDATE_INT, [
                    'options' => [
                        'min_range' => 1,
                        'max_range' => $maxAuthorId
                    ]
                ]
            );
            $authorExists = query("SELECT id_autora FROM author WHERE id_autora = '%s'", "verifyAuthorExists", $_SESSION["adv-search-author"]); // --> returns true - if author exists;

            if (empty($author) || empty($_SESSION["adv-search-author"]) || ($_SESSION["adv-search-author"] != $_POST["adv-search-author"]) || empty($authorExists)) {
                $valid = false;
            }

            unset($author, $_SESSION["max-author-id"], $authorExists);
        }

        if (!empty($_POST["year-min"])) {

            $year_min = sanitizeAndValidateInput(INPUT_POST, "year-min", FILTER_SANITIZE_NUMBER_INT);

            $_SESSION["year-min"] = filter_var($year_min, FILTER_VALIDATE_INT, [
                    'options' => [
                        'min_range' => 1900,
                        'max_range' => 2023
                    ]
                ]
            );

            if ($year_min === false || $_SESSION["year-min"] === false) {
                $valid = false;
            }
        }

        if (!empty($_POST['year-max'])) {

            $year_max = sanitizeAndValidateInput(INPUT_POST, "year-max", FILTER_SANITIZE_NUMBER_INT);

            $_SESSION["year-max"] = filter_var($year_max, FILTER_VALIDATE_INT, [
                    'options' => [
                        'min_range' => 1900,
                        'max_range' => 2023
                    ]
                ]
            );

            if ($year_max === false || $_SESSION["year-max"] === false) {
                $valid = false;
            }

            if ($_SESSION["year-min"] > $_SESSION["year-max"]) {
                $valid = false;
            }
        }

        if ($valid === false) {

            $_SESSION["application-error"] = true;
            unset($_POST, $category, $_SESSION["adv-search-category"], $_SESSION["category"], $_SESSION["category-exists"], $title, $_SESSION["adv-search-title"], $author, $_SESSION["adv-search-author"], $_SESSION["max-author-id"], $_SESSION["author-exists"], $_SESSION["adv-search-query"], $year_min, $year_max, $_SESSION["year-min"], $_SESSION["year-max"]);

        } else {

            $where = [];
            $values = [];

            if (!empty($_SESSION["adv-search-title"])) {
                $where[] = "ks.tytul LIKE '%%%s%%'";
                $values[] = $_SESSION["adv-search-title"];
            }

            if ($_SESSION["adv-search-category"] != "Wszystkie") {
                $where[] = "kt.nazwa = '%s'";
                $values[] = $_SESSION["adv-search-category"];
            }

            if (!empty($_SESSION["adv-search-author"])) {
                $where[] = "ks.id_autora = '%s'";
                $values[] = $_SESSION["adv-search-author"];
            }

            if (!empty($_SESSION["year-min"])) {
                $where[] = "ks.rok_wydania >= '%s'";
                $values[] = $_SESSION["year-min"];
            }

            if (!empty($_SESSION["year-max"])) {
                $where[] = "ks.rok_wydania <= '%s'";
                $values[] = $_SESSION["year-max"];
            }

            if (!empty($where)) {
                $_SESSION["adv-search-query"] .= " WHERE " . implode(" AND ", $where) . " GROUP BY ks.id_ksiazki ";
                $_SESSION["adv-search-values"] = $values;
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["input-search-nav"])) { // title of the book from left nav-bar

            validateSearchNavTitle();

        } elseif (isset($_POST["category"])) { // name of the category from main top nav-bar list

            validateCategory();

        } elseif (isset($_POST["input-search"])) { // main search (top-left)

            validateMainInputSearch();

        } elseif (isset($_POST["adv-search-title"]) && isset($_POST["adv-search-category"]) && isset($_POST["adv-search-author"]) && isset($_POST["year-min"]) && isset($_POST["year-max"])) {

            validateAdvancedSearch();

        }

        header('Location: ' . $_SERVER["REQUEST_URI"], true, 303);
            exit();
    }

    if (empty($_SESSION["category"])) {

        $_SESSION["category"] = "Wszystkie";
    }

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/header-container.php"; ?>

        <div id="container">

            <main>

                <aside id="book-filters">

                    <div id="nav" class="nav-visible">

                        <?= "<h3>".$_SESSION["category"]; ?>

                        <?= isset($_SESSION["subcategory"]) ? " / " . $_SESSION["subcategory"] . "</h3>" : ""; ?>

                        <h3>
                            <label for="sortBy">Sortowanie</label>
                        </h3>

                        <select id="sortBy">
                            <option data-sort="price" data-order="asc">ceny rosnąco</option>
                            <option data-sort="price" data-order="desc">ceny malejąco</option>
                            <option data-sort="title" data-order="asc">nazwy A-Z</option>
                            <option data-sort="title" data-order="desc">nazwy Z-A</option>
                            <option data-sort="year" data-order="asc">Najstarszych</option>
                            <option data-sort="year" data-order="desc">Najnowszych</option>
                        </select>

                        <h3>
                            <label for="value-min">Cena</label>
                        </h3>

                        <div id="price-range">
                                <label>
                                    <span>
                                        Min
                                    </span>
                                        <input type="number" id="min-price" step="1" min="5">
                                </label>
                            <label>
                                <span>
                                    Max
                                </span>
                                    <input type="number" id="max-price" step="1" max="150">
                            </label>

                            <div id="price-slider"> </div>
                        </div>

                        <div id="input-search-nav-div">

                            <label for="input-search-nav">
                                <h3>Tytyuł</h3>
                            </label>

                            <form method="post">
                                    <input type="search" name="input-search-nav" id="input-search-nav" placeholder="Tytuł książki">
                                <button type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </form>

                        </div>

                        <h3>
                            <label for="all-authors">Autorzy</label>
                        </h3>

                        <ul id="ul-authors">
                            <?php
                                //query("SELECT DISTINCT imie, nazwisko, id_autora FROM author ORDER BY imie", "getAuthors", "");

                                if ($_SESSION["category"] != "Wszystkie") {
                                    query("SELECT au.id_autora, au.imie, au.nazwisko, COUNT(bk.id_autora) AS ilosc_ksiazek
                                                 FROM author AS au, books AS bk, subcategories AS sb, categories AS kt
                                                 WHERE au.id_autora = bk.id_autora AND bk.id_subkategorii = sb.id_subkategorii AND sb.id_kategorii = kt.id_kategorii AND kt.nazwa = '%s'
                                                 GROUP BY au.id_autora", "getAuthors", $_SESSION["category"]);
                                } else {
                                    query("SELECT au.id_autora, au.imie, au.nazwisko, COUNT(bk.id_autora) AS ilosc_ksiazek
                                                 FROM author AS au, books AS bk, subcategories AS sb, categories AS kt
                                                 WHERE au.id_autora = bk.id_autora AND bk.id_subkategorii = sb.id_subkategorii AND sb.id_kategorii = kt.id_kategorii
                                                 GROUP BY au.id_autora", "getAuthors", $_SESSION["category"]);
                                }
                            ?>
                        </ul>

                        <button id="filter-authors">Zastosuj</button>

                        <h3>Status</h3>

                        <ul id="ul-book-status-list">
                            <li>
                                <label>
                                    <input type="checkbox" name="available" class="book-status-checkbox" value="dostępna">dostępna
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="not-available" class="book-status-checkbox" value="niedostępna">niedostępna
                                </label>
                            </li>
                        </ul>

                        <button id="filter-book-status">Zastosuj</button>

                    </div>

                </aside>

                <div id="content">

                    <div id="content-books">

                        <?php

                            if (isset($_SESSION["input-search"])) {

                                $searchValue = $_SESSION["input-search"];

                                unset($_SESSION["input-search"]);

                                query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                              kt.nazwa, sb.id_kategorii, 
                                              au.imie, au.nazwisko,
                                              SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                        FROM 
                                              books AS ks
                                        JOIN 
                                              author AS au ON ks.id_autora = au.id_autora
                                        JOIN 
                                              subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                        JOIN 
                                              categories AS kt ON sb.id_kategorii = kt.id_kategorii
                                        LEFT JOIN 
                                              warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                                        WHERE ks.tytul LIKE '%%%s%%' 
                                        GROUP BY ks.id_ksiazki", "getBooks", $searchValue);
                            }

                            elseif (isset($_SESSION["input-search-nav"])) {

                                $searchValue = $_SESSION["input-search-nav"];

                                unset($_SESSION["input-search-nav"]);

                                $values = [$searchValue];

                                $query = "SELECT
                                            ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                            kt.nazwa, sb.id_kategorii, sb.nazwa,
                                            au.imie, au.nazwisko,
                                            SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                        FROM 
                                            books AS ks
                                        JOIN 
                                            author AS au ON ks.id_autora = au.id_autora
                                        JOIN 
                                            subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                        JOIN 
                                            categories AS kt ON sb.id_kategorii = kt.id_kategorii
                                        LEFT JOIN 
                                            warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                                        WHERE ks.tytul LIKE '%%%s%%'";

                                if ($_SESSION["category"] !== "Wszystkie") {

                                    $where = [];
                                    $where[] = " AND kt.nazwa LIKE '%%%s%%'";
                                    $values[] = $_SESSION["category"];

                                    if (isset($_SESSION["subcategory"])) {
                                        $where[] = " AND sb.nazwa LIKE '%%%s%%'";
                                        $values[] = $_SESSION['subcategory'];
                                    }
                                }

                                if (!empty($where)) {

                                    $query .= implode("", $where);
                                }

                                $query .= " GROUP BY ks.id_ksiazki";

                                query($query, "getBooks", $values);
                            }

                            elseif (isset($_SESSION["adv-search-query"])) {

                                query($_SESSION["adv-search-query"], "getBooks", $_SESSION["adv-search-values"]);

                                unset($_SESSION["adv-search-query"], $_SESSION["adv-search-values"], $_SESSION["adv-search-title"], $_SESSION["adv-search-category"], $_SESSION["adv-search-author"], $_SESSION["year-min"], $_SESSION["year-max"]);
                            }
                            else {
                                    if (isset($_SESSION["no-results"]) && !empty($_SESSION["no-results"])) {
                                        echo '<span class="main-page-search-result-error">' . $_SESSION["no-results"] . '</span>';
                                        unset($_SESSION["no-results"]);
                                    }
                                    else {
                                        if (isset($_SESSION["subcategory"])) {
                                            displayBooksWithSubcategory($_SESSION["category"], $_SESSION["subcategory"]);
                                        } else {
                                            displayBooks($_SESSION["category"]);
                                        }
                                    }
                            }
                        ?>

                    </div>

                </div>

            </main>

        </div>

        <?php require "../view/footer.php"; ?>

    </div>

    <?php require "../view/app-error-window.php"; ?>

</body>
</html>