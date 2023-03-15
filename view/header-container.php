
    <header>
        <div id="header-container">
            <div id="sticky">
                <div id="top-header">
                    <div id="top-header-content">
                        <div id="header-title">
                            Księgarnia internetowa
                        </div>
                        <ol>
                            <li>
                                <a href="zarejestruj.php">Zarejestruj</a>
                            </li>
                            <li>
                                <?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) { echo '<a href="account.php">Moje konto</a>';} else { echo '<a href="zaloguj.php">Zaloguj</a>';} ?>
                            </li>
                        </ol>
                    </div>
                </div>

                <div id="header">
                    <div id="header-content">
                        <div id="div-search">
                            <form action="index.php" method="get">
                                <input type="search" name="input-search" id="input-search" placeholder="tytuł książki">
                                <input type="submit" value="Szukaj">

                                <img id="search-arrow" src="../assets/arrow.png" alt="advanced filtering"> <!-- advanced search -->

                            </form>
                        </div>
                        <div id="div-logo">
                            <img id="main-logo" src="../assets/logo.png" alt="logo">
                        </div>
                        <div id="div-cart">
                            <a class="top-nav-right" href="koszyk.php">Koszyk
                                <?php
                                if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) {
                                    query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION['id']);
                                    echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")";
                                }
                                ?>
                            </a>
                        </div>



                    </div>

                    <div id="advanced-search" class="advanced-search-invisible">

                        <!-- animacja płynnego przejścia menu
                             https://www.kirupa.com/html5/creating_a_smooth_sliding_menu.htm# -->

                        <form method="post" action="index.php" id="advanced-search-form">
                            <div>
                                <p>
                                    <span class="adv-search">
                                        <label for="adv-search-title">
                                            Tytuł
                                        </label>
                                    </span>
                                    <input type="text" name="adv-search-title" id="adv-search-title"> <!-- id="dostawa_kurier_dpd" value="Kurier DPD" -->
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
                                            query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories_adv_search", ""); // <option value="...">...</option>-->
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
                                    <span class="adv-search">
                                        <label for="adv-search-year">
                                            Rok wydania
                                        </label>
                                    </span>
                                    <div id="year-range">
                                        <label>
                                            od: <input type="number" id="year-min" name="year-min">
                                        </label>
                                        <label>
                                            do: <input type="number" id="year-max" name="year-max">
                                        </label>
                                        <div id="adv-search-year-slider"></div>
                                    </div>
                                </p>
                            </div>

                            <br><input type="submit" value="Szukaj">

                            <span id="advanced-search-error">

                                <!-- display error message from JS HERE -> -->

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
                            </script>

                        </form>



                    </div>

                </div>
            </div>
        </div>
    </header>

    <nav id="main-nav">
        <div id="top-nav">
            <div id="top-nav-content">
                <ol>
                    <li>
                        <a href="index.php">Strona główna</a>
                        <div id="test-div"></div>
                    </li>
                    <li><a href="#">Kategorie</a>
                        <ul>
                            <?php
                                query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", "");
                            ?>
                        </ul>
                    </li>
                    <li><a href="#">...</a>
                        <ul>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>
                    <li><a href="#">...</a>
                        <ul>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>
                    <li><a href="#">...</a>
                        <ul>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>
                    <li><a href="#">...</a></li>
                </ol>
            </div>
        </div>
    </nav>
