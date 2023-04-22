<!-- ___header-container.php -->


<header>

    <div id="n-header">

        <div id="n-top-header">

            <!-- top-header -->
            <div id="header-title"> Księgarnia internetowa </div>
            <div id="btn-parent">
               <!-- <div class="btn from-center">Zaloguj</div>-->

                <?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) { echo '
                <a href="___account.php">
                    <div class="btn from-center">Moje konto</div>
                </a>';} else { echo '<a href="___zaloguj.php"><div class="btn from-center">Zaloguj</div></a>';} ?>

                <a href="___zarejestruj.php">
                    <div class="btn from-center">Zarejestruj</div> <!-- zmienić aby było to przejście do rejestracji (hiperłącze) -->
                </a>

                <div id="div-cart-header">
                    <a class="top-nav-right" href="___koszyk.php" >Koszyk
                    </a>
                </div>
                <!-- <div style="height: 25px; width: 25px; margin: 0 auto 0 auto; border: 1px dashed red;"> if you want to have content in center -->
            </div>

            <!-- header -->

        </div>

        <div id="div-search">
            <form id="search-form" action="___index2.php" method="get" >
                <input type="search" name="input-search" id="input-search" > <!-- placeholder="tytuł książki" -->

                <input type="submit" value=" ">

                <!--<img id="search-arrow" src="../assets/arrow.png" alt="advanced filtering">--> <!-- advanced search -->
            </form>
        </div>


        <!--<div id="div-logo">
            <img id="main-logo" src="../assets/logo4.png" alt="logo">
        </div>-->

        <!--<div id="div-cart">-->
        <div class="div-cart">
            <a class="top-nav-right" href="___koszyk.php">Koszyk
                <?php
                if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) {
                    query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION['id']);
                    echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")";
                }
                ?>
            </a>
        </div>

    </div>


    <!-- advanced search (!) -->


    <nav id="main-nav">
        <div id="n-top-nav">

            <div id="n-top-nav-content">

                <ol>
                    <li class="btn from-center">
                        <a href="___index2.php">Strona główna</a>
                        <div id="test-div"></div>
                    </li>
                    <li class="btn from-center"><a href="___kategorie.php">Kategorie</a>
                        <ul>
                            <?php
                            query("SELECT DISTINCT nazwa FROM kategorie ORDER BY nazwa ASC", "get_categories", "");
                            ?>
                        </ul>
                    </li>
                    <li class="btn from-center"><span id="search-arrow">Wyszukiwanie zaawansowane</span>
                        <ul>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>
                </ol>

                <!-- advanced search -->



            </div>
        </div>
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
                                        <label for="adv-search-year">
                                            Rok wydania
                                        </label>
                                    </span>


                    <label>
                        od <input type="number" id="year-min" name="year-min">
                    </label>
                    <label>
                        do <input type="number" id="year-max" name="year-max">
                    </label>
                    <div id="adv-search-year-slider"></div>
                </div>
                </p>
            </div>

            <input type="submit" value="Szukaj">

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

</header>