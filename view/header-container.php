
    <header>

        <div id="n-header">

            <div id="n-top-header">

                <div id="header-title"> Księgarnia internetowa </div>

                <div id="btn-parent">

                    <?php if (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true) {

                              echo '<a href="account.php">
                                  <div class="btn from-center">Moje konto</div>
                              </a>';
                          }
                          else {
                              echo '<a href="___zaloguj.php">
                                   <div class="btn from-center">Zaloguj</div>
                              </a>';
                          }
                    ?>

                    <a href="___zarejestruj.php">
                        <div class="btn from-center">Zarejestruj</div>
                    </a>

                    <a class="top-nav-right" href="___koszyk.php">
                        <div class="btn from-center">
                            Koszyk
                                <?php
                                    if (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true) {
                                        query("SELECT SUM(ilosc) AS suma FROM shopping_cart WHERE id_klienta='%s'", "countCartQuantity", $_SESSION["id"]);
                                        echo "(".$_SESSION["koszyk_ilosc_ksiazek"].")";
                                    }
                                ?>
                        </div>
                    </a>

                </div>

            </div>

            <div id="div-search">
                <form id="search-form" method="post" action="index.php">

                    <input type="search" name="input-search" id="input-search" placeholder="Tytuł książki">

                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>

                </form>
            </div>

            <a class="top-nav-right" href="___koszyk.php">
                <div class="btn from-center btn-cart-main">
                    Koszyk
                        <?php
                            if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
                                query("SELECT SUM(ilosc) AS suma FROM shopping_cart WHERE id_klienta='%s'", "countCartQuantity", $_SESSION['id']);
                                echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")";
                            }
                        ?>
                </div>
            </a>

        </div>

        <nav id="main-nav">

            <div id="n-top-nav">

                <div id="n-top-nav-content">

                    <ol>
                        <li class="btn from-center">
                            <a href="index.php">Strona główna</a>
                        </li>
                        <li class="btn from-center">
                            <a href="#" id="a-categories-top-nav">Kategorie</a>

                            <ul id="categories-list">
                                <?php
                                    query("SELECT DISTINCT nazwa FROM categories ORDER BY nazwa", "getCategories", "");
                                ?>
                            </ul>

                            <ul id="subcategories-list">

                            </ul>

                        </li>

                        <li class="btn from-center">
                            <span id="search-arrow">Wyszukiwanie zaawansowane</span>
                        </li>

                    </ol>

                </div>

            </div>

            <div id="advanced-search" class="advanced-search-invisible">

                <form method="post" action="index.php" id="advanced-search-form">

                    <div>
                        <p>
                            <span class="adv-search">
                                <label for="adv-search-title">
                                    Tytuł
                                </label>
                            </span>
                                <input type="text" name="adv-search-title" id="adv-search-title" maxlength="255">
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
                                    query("SELECT DISTINCT nazwa FROM categories ORDER BY nazwa", "getCategoriesAdvSearch", "");
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
                                <?php
                                    query("SELECT DISTINCT imie, nazwisko, id_autora FROM author ORDER BY imie", "getAuthorsAdvSearch", "");
                                ?>

                            </select>
                        </p>
                    </div>

                    <div>

                        <div id="year-range">

                            <span class="adv-search">
                                <label for="year-min">Rok wydania</label>
                            </span>
                                <label>
                                    od <input type="number" id="year-min" name="year-min">
                                </label>
                            <label>
                                do <input type="number" id="year-max" name="year-max">
                            </label>

                            <div id="adv-search-year-slider"></div>

                        </div>

                    </div>

                    <input type="submit" value="Szukaj">

                </form>

            </div>

        </nav>

    </header>
