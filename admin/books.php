<?php
session_start();
include_once "../functions.php";

if(!(isset($_SESSION['zalogowany']))) {
    header("Location: ../user/___index2.php?login-error");
    exit();
}

/* if(isset($_GET["login-error"])) {
    echo '
                <script>
                    alert("Musisz być zaloowany !")
                    let url = new URL(window.location.href);
                    url.searchParams.delete("login-error");
                    window.location.href = url.toString();
                </script>
             ';
} */
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

<div id="all-container">

    <?php //require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <h3 class="section-header section-header-books">Książki</h3>

                <!-- <div style="clear: both;"></div> -->

                <form id="change-magazine-form" action="change-magazine.php" method="post">
                    <select id="change-magazine" name="change-magazine"> <!-- js manage "change" event for <select> list, and then sends the <form>; -->
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <!--<input type="submit" value="wyślij">-->
                </form>

<!-- SELECT mg.id_magazynu, mg.nazwa, mg.kraj, mg.wojewodztwo, mg.miejscowosc, mg.ulica, mg.kod_pocztowy, mg.kod_miejscowosc
FROM magazyn AS mg

<option> elementy - powinny być generowane dynamicznie na podstawie BD i danych o magazynach

query() -> function -> template(?)
                       echo "<option ...> ...</> ";
-->


                <hr id="book-details-hr">

                <?php require "../view/admin/books-header.php"; // table header ?>

                <?php
                query("SELECT ks.id_ksiazki, ks.tytul, ks.cena,
                                    kt.nazwa AS nazwa_kategorii, mgk.ilosc_dostepnych_egzemplarzy, au.imie, au.nazwisko, mg.nazwa AS nazwa_magazynu
                                    FROM ksiazki AS ks, subkategorie AS sbk, kategorie AS kt, autor AS au, magazyn_ksiazki AS mgk, magazyn AS mg
                                    WHERE ks.id_subkategorii = sbk.id_subkategorii AND sbk.id_kategorii = kt.id_kategorii AND ks.id_autora = au.id_autora AND mgk.id_ksiazki = ks.id_ksiazki AND mgk.id_magazynu = mg.id_magazynu", "get_all_books", ""); // content of the table;
                ?>

            </div>

        </main>
    </div>

    <!-- <footer>
        <div id="footer">
            <script src="../scripts/set-theme.js"></script>
            <pre>
                <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer> -->

    <?php //require "../view/___footer.php"; ?>

    <script src="change-magazine.js"></script>

    <script>
        // send <form> after changing selected <option> element in <select> list;

        /*let selectList = document.getElementById("change-magazine");
        let magazineForm = document.getElementById("change-magazine-form");

        selectList.addEventListener("change", function() { // This code will execute when the selected option changes
            magazineForm.submit(); // submit the form after changing selected <option> element, the form will be first processed in "change-magazine.js" file that will send AJAX request to "change-magazine.php" file;
        });*/

    </script>



</div>

</body>
</html>