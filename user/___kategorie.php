<?php

    // user/index.php?kategoria=Wszystkie

session_start();

include_once "../functions.php";

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>




<div id="all-container">

<!-- header -->

    <?php require "../view/___header-container.php"; ?>

<!-- end header -->

<div id="container">

    <main>

        <aside id="book-filters">       <!-- nav -->
            <div id="nav" class="nav-visible">
                <h3>Wszystkie</h3>

                <h3>Sortowanie</h3>

                <select id="sortuj_wg">
                    <option value="1">ceny rosnąco</option>
                    <option value="2">ceny malejąco</option>
                    <option value="3">nazwy A-Z</option>
                    <option value="4">nazwy Z-A</option>
                    <option value="5">Najnowszych</option>
                    <option value="6">Najstarszych</option>
                </select>

                <button id="sort_button" onclick="sortBooks()">Sortuj</button>



                <h3>Cena</h3>

                <div id="price-range">
                    <label>

                        <span>
                            Min:
                        </span>
                        <input type="number" id="value-min">
                    </label>
                    <label>
                        <span>
                            Max:
                        </span>
                        <input type="number" id="value-max">
                    </label>
                    <div id="slider"></div>
                </div>



                <!-- search by title in that category -->

                <div id="input-search-nav">
                    <h3>Tytyuł</h3>
                    <!-- (szukaj tytułu w tej kategorii) -->
                    <!-- <div id="div-search">-->
                    <form action="index.php" method="get">
                        <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                        <input type="submit" value="Szukaj">
                    </form>
                </div>



                <?php
                    query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", ""); // lista <ul> autorów
                ?>

                <button id="filter-authors">Zastosuj</button>

            </div> <!-- #nav -->
        </aside>


            <!-- if isset ( kategoria ) ... -->

            <div id="content">              <!-- content (books) -->

                <!--  echo '<script> displayNav(); </script>'; -->



                <div id="content-books">

                    <!-- (!) /template/content-books.php    -->

                    <!-- template used on main page (index.php) to display books -->
                    <!--<div class="book" id="book1">
                        <div class="book-cover">
                            <a href="../user/book.php?book=36">
                                <img src="../assets/books/CSS_Nieoficjalny_podręcznik.png" alt="CSS. Nieoficjalny podręcznik" title="CSS. Nieoficjalny podręcznik">
                            </a>
                        </div>
                        <div class="book-info">
                            <a href="../user/book.php?book=36">
                                <h3 class="book-title">CSS. Nieoficjalny podręcznik</h3>
                            </a>
                            <div class="book-price">25.55</div>
                            <div class="book-year">2017</div>
                            <div class="book-author">Jan Nowak</div>
                            <div class="book-rating">4.28</div>

                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="id_ksiazki" value="36">
                                <input type="hidden" name="koszyk_ilosc" class="koszyk_ilosc"  value="1">
                                <button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>
                            </form>
                        </div>
                    </div> --><!-- template/content-books -->

                    <?php displayBooks($_SESSION['kategoria']); ?>

                </div>




            </div>

        <!-- -->

    </main>

</div>



    <!--<footer>
        <div id="footer">
            <script src="../scripts/set-theme.js"></script>

            <pre>
                <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer>-->

    <?php require "../view/___footer.php"; ?>






</div>






</body>
</html>