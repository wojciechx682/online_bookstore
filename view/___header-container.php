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
                    <li class="btn from-center"><a href="#">Wyszukiwanie zaawansowane</a>
                        <ul>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>



                </ol>

            </div>
        </div>
    </nav>

</header>