    <div id="header-container">

        <!-- <div id="header_content"> -->

        <div id="sticky">

            <div id="top-header">

                <div id="top-header-content">

                    <div id="header-title">

                        Księgarnia internetowa

                    </div>

                    <!-- <div id="div_register">

                        <a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>

                    </div> -->

                    <!-- <div id="div_log_in">

                        <a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

                    </div> -->

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

                    <!-- <a href="index.php">Strona główna</a> -->

                    <div id="div-search">

                        <form action="index.php" method="get">

                            <input type="search" name="input-search">

                            <input type="submit" value="Szukaj">

                        </form>

                    </div>

                    <div id="div-logo">

                        <img src="logo.png" width="100px">

                    </div>

                    <div id="div-cart">

                        <a class="top-nav-right" href="koszyk.php">Koszyk

                            <?php
                            if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true"))
                            {
                                echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")";
                            }
                            ?>
                        </a>

                    </div>

                    <div style="clear: both;"></div>

                </div>

            </div>

        </div>

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
                            query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // top_nav - wypis kategorii - wewnątrz listy rozwijanej ul
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

    </div>