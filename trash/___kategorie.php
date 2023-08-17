<?php

    // user/index.php?kategoria=Wszystkie

    /*session_start();
    include_once "../functions.php";*/

/*require_once "../start-session.php";

    if( ! isset($_SESSION["kategoria"])  ) {

        $_SESSION["kategoria"] = "Wszystkie";
    }*/

?>

<!--<!DOCTYPE HTML>
<html lang="pl">

<?php /*require "../view/___head.php"; */?>

<body>

    <div id="main-container">

        <?php /*require "../view/___header-container.php"; */?>

        <div id="container">

            <main>

                <aside id="book-filters">

                    <div id="nav" class="nav-visible">

                        <?/*= "<h3>".$_SESSION["kategoria"]."</h3>"; */?>

                        <h3>Sortowanie</h3>

                        <select id="sortuj_wg">
                            <option value="1">ceny rosnąco</option>
                            <option value="2">ceny malejąco</option>
                            <option value="3">nazwy A-Z</option>
                            <option value="4">nazwy Z-A</option>
                            <option value="5">Najnowszych</option>
                            <option value="6">Najstarszych</option>
                        </select>

                        <h3>Cena</h3>

                        <div id="price-range">
                            <label>
                                <span>
                                    Min
                                </span>
                                <input type="number" id="value-min">
                            </label>
                            <label>
                                <span>
                                    Max
                                </span>
                                <input type="number" id="value-max">
                            </label>
                            <div id="slider"></div>
                        </div>

                        <div id="input-search-nav-div">
                            <label for="input-search-nav">
                                <h3>Tytyuł</h3>
                            </label>
                            <form action="../user/index.php" method="get">
                                <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                                <input type="submit" value="">
                            </form>
                        </div>

                        <?php
/*                            //query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", "");
                        */?>

                        <button id="filter-authors">Zastosuj</button>

                    </div>

                </aside>

                <?php /*displayBooks($_SESSION['kategoria']); */?>

            </main>

        </div>

            <?php /*require "../view/___footer.php"; */?>

    </div>

<script>
    // save selected sorting option after page reload;
    var selectElement = document.getElementById("sortuj_wg");
    selectElement.addEventListener("change", function() {
        var selectedValue = selectElement.value;
        localStorage.setItem("selectedValue", selectedValue);
    });
    window.addEventListener("load", function() {
        var selectedValue = localStorage.getItem("selectedValue");
        if (selectedValue && selectElement) {
            selectElement.value = selectedValue;
            sortBooks();
        }
    });
</script>

</body>
</html>-->