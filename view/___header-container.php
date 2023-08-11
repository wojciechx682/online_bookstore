
    <!-- ___header-container.php -->

    <header>

        <div id="n-header">

            <div id="n-top-header">

                <div id="header-title"> Księgarnia internetowa </div> <!-- top-header -->

                <div id="btn-parent">
                    <!-- <div class="btn from-center">Zaloguj</div> -->
                    <?php if( isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == "true" ) { echo '
                        <a href="___account.php">
                            <div class="btn from-center">Moje konto</div>
                        </a>';}
                          else { echo '<a href="___zaloguj.php"><div class="btn from-center">Zaloguj</div></a>';} ?>

                    <a href="___zarejestruj.php">
                        <div class="btn from-center">Zarejestruj</div>
                    </a>

                    <!--<div id="div-cart-header">-->
                        <!-- <a class="top-nav-right" href="___koszyk.php" >Koszyk</a> -->
                        <a class="top-nav-right" href="___koszyk.php">
                            <div class="btn from-center">
                                Koszyk
                                <?php
                                    if( isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == "true" ) {
                                        query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION['id']);
                                        echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")"; // "3"
                                    }
                                ?>
                            </div>
                        </a>
                    <!--</div>-->

                </div> <!-- #btn-parent -->

            </div> <!-- #n-top-header -->

            <div id="div-search">
                    <!--<form id="search-form" action="___index2.php" method="get" >-->
                <form id="search-form" action="___index2.php" method="post" > <!-- -> POST -->
                    <input type="search" name="input-search" id="input-search" placeholder="Tytuł książki">
                        <!-- placeholder="tytuł książki" -->
                    <input type="submit" value=" ">
                        <!--<img id="search-arrow" src="../assets/arrow.png" alt="advanced filtering">--> <!-- advanced search -->
                </form>
            </div>

            <!--<div id="div-logo">
                <img id="main-logo" src="../assets/logo4.png" alt="logo">
            </div>-->

                <!--<div id="div-cart">-->
            <!--<div class="div-cart">-->
            <a class="top-nav-right" href="___koszyk.php">
                <div class="btn from-center btn-cart-main">
                    Koszyk
                        <?php
                            if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == "true") {
                                query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION['id']);
                                echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")"; // "3"
                            }
                        ?>
                </div>
            </a>
            <!--</div>-->

        </div> <!-- #n-header -->

        <nav id="main-nav">

            <div id="n-top-nav">

                <div id="n-top-nav-content">

                    <ol>
                        <li class="btn from-center">
                            <a href="___index2.php">Strona główna</a>
                        </li>
                        <li class="btn from-center">
                                <!--<a href="___kategorie.php">Kategorie</a>-->
                            <a href="#" id="a-categories-top-nav">Kategorie</a>
                            <ul id="categories-list">
                                <?php
                                    query("SELECT DISTINCT nazwa FROM kategorie ORDER BY nazwa ASC", "get_categories", ""); // wyświetla listę kategorii; wypisuje elementy listy <li> - wewnątrz <ul>

                                    /*<ul>
                                        <li>
                                            <form method="post" action="___index2.php">
                                                <input type="hidden" name="kategoria" value="Wszystkie">
                                                <button class="submit-book-form" type="submit">Wszystkie</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action="___index2.php">
                                                <input type="hidden" name="kategoria" value="Dla dzieci">
                                                <button class="submit-book-form" type="submit">Dla dzieci</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action="___index2.php">
                                                <input type="hidden" name="kategoria" value="Fantastyka">
                                                <button class="submit-book-form" type="submit">Fantastyka</button>
                                            </form>
                                        </li>
                                        // ...
                                        // ...
                                    </ul>*/
                                ?>
                            </ul>

                            <ul id="second-list">
                                <!--<li>
                                    <form method="post" action="___index2.php">
                                        <input type="hidden" name="kategoria" value="Wszystkie">
                                        <button class="submit-book-form" type="submit">Wszystkie</button>
                                    </form>
                                </li>
                                <li>
                                    <form method="post" action="___index2.php">
                                        <input type="hidden" name="kategoria" value="Dla dzieci">
                                        <button class="submit-book-form" type="submit">Dla dzieci</button>
                                    </form>
                                </li>-->
                            </ul>

                        </li>

                        <!-- advanced search (!) -->

                        <li class="btn from-center">
                            <span id="search-arrow">Wyszukiwanie zaawansowane</span>
                            <!--<ul>
                                <li><a href="#">...</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">...</a></li>
                            </ul>-->
                        </li>
                    </ol>

                </div> <!-- #n-top-nav-content -->
            </div> <!-- #n-top-nav -->
        </nav>

        <div id="advanced-search" class="advanced-search-invisible">

            <!-- animacja płynnego przejścia menu
                 https://www.kirupa.com/html5/creating_a_smooth_sliding_menu.htm# -->

            <form method="post" action="___index2.php" id="advanced-search-form">

                <div>
                    <p>
                        <span class="adv-search">
                            <label for="adv-search-title">
                                Tytuł
                            </label>
                        </span>
                            <input type="text" name="adv-search-title" id="adv-search-title">
                    </p>
                </div>

                <div>
                    <p>
                        <span class="adv-search">
                            <label for="adv-search-category">
                                Kategoria
                            </label>
                        </span>
                            <select id="adv-search-category" name="adv-search-category">
                                <?php
                                    query("SELECT DISTINCT nazwa FROM kategorie ORDER BY nazwa ASC", "get_categories_adv_search", ""); // <option value="...">...</option>-->
                                ?>
                            </select>
                    </p>
                </div>

                <div>
                    <p>
                        <span class="adv-search">
                            <label for="adv-search-author">
                                Autor
                            </label>
                        </span>
                            <select id="adv-search-author" name="adv-search-author">
                                <option value=""></option>
                                    <?php
                                        query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor ORDER BY nazwisko ASC", "get_authors_adv_search", "");
                                    ?>
                            </select>
                    </p>
                </div>

                <div>
                    <p>
                        <div id="year-range">
                            <span class="adv-search">
                                <label for="year-min">
                                    Rok wydania
                                </label>
                            </span>
                                <label>
                                    od <input type="number" id="year-min" name="year-min">
                                </label>
                            <label>
                                do <input type="number" id="year-max" name="year-max">
                            </label>
                                <div id="adv-search-year-slider"></div> <!-- jQuery NoUISlider -->
                        </div>
                    </p>
                </div>

                <input type="submit" value="Szukaj">

                <!--<span id="advanced-search-error">
                    display error message from JS HERE
                </span>

                <script>
                    const form = document.getElementById("advanced-search-form");
                    const input = document.getElementById("adv-search-author");
                    const errorMessage = document.getElementById("advanced-search-error");

                    form.addEventListener("submit", function (event) {
                        if (!isNumeric(input.value) && input.value) {
                            event.preventDefault();
                            errorMessage.innerText = "Podaj poprawne dane";
                        }
                    });
                    function isNumeric(value) {
                        return /^\d+$/.test(value);
                    }
                </script>-->

            </form>

        </div> <!-- #advanced-search -->

    </header>
