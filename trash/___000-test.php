<?php
session_start();
include_once "../functions.php";

//	sprawdź połączenie z BD
//	$value = array();
//	array_push($value, "1");
//	query("", "", ""); // w przypadku błędu połączenia z BD, wyświetli komunikat rzuconego wyjątku.
//	należy dodać to do każdej podstrony, która korzysta z połączenia z BD
//	echo $_SESSION['login'] . '<br>';
//	if(isset($_SESSION['zalogowany']))
//	{
//		    //echo '<br>'.$_SESSION['account_error'];
//		unset($_SESSION['account_error']);
//		    //exit();
//	}
//	if(isset($_SESSION['blad'])) {
//		echo $_SESSION['blad'];
//		exit();
//	}

if(isset($_GET["login-error"])) {
    echo '
                    <script>
                        alert("Musisz być zaloowany !")
                        let url = new URL(window.location.href);
                        url.searchParams.delete("login-error");
                        window.location.href = url.toString();
                    </script>
                 ';
}

// (?) można lepiej zapisać -->

if( isset($_GET['kategoria']) && !empty($_GET['kategoria']) )
{

    echo '<script>console.log("\n38\n")</script>';

    // to się spełni, jeśli następiło wejście pod dowolna kategorię --> index.php?kategoria=Horror;
    // chnage special characters to their HTML entities representation, and then the strip_tags() function is used to remove any HTML tags from the input. This helps prevent potential security vulnerabilities such as cross-site scripting (XSS) attacks;
    /*echo "<script>console.log('37');</script>";*/
    $_SESSION["kategoria"] = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8");
    $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    // filter input ? filter var ?
    // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert();</script>;
}
/*elseif(isset($_SESSION['kategoria']) && !empty($_SESSION['kategoria']) && isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]))
{
    // to się spełni, jeśli wsześniej następiło wejście pod dowolna kategorię --> index.php?kategoria=Wszystkie;
    // ORAZ           wprowadzono tytuł z input-search-nav;
            //echo "<script>console.log('43');</script>";
    $_SESSION["kategoria"] = htmlentities($_SESSION['kategoria'], ENT_QUOTES, "UTF-8");
    $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert();</script>;
}*/
elseif(!isset($_GET["kategoria"]))
{
    echo '<script>console.log("\n59 - kategoria nie była w parametrze GET\n")</script>';

    $_SESSION["kategoria"] = "Wszystkie";
}

// od teraz kategoria jest ZAWSZE ustawiona;

if(isset($_POST["adv-search-category"]))
{
    // to się spełni, jeśli nastąpił submit z wyszukiwania-zaawansowanego;
    /*echo "<script>console.log('49');</script>";*/
    $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
    $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert("hahaha");</script>;
}

if(isset($_GET["input-search"]))
{
    echo "<script>console.log('\n77\n');</script>";
    $_SESSION["kategoria"] = "Wszystkie";
}

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <aside id="book-filters">

                <div id="nav" class="nav-visible">

                    <?= "<h3>".$_SESSION["kategoria"]."</h3>"; ?>

                    <h3>Sortowanie</h3>

                    <select id="sortuj_wg">
                        <option value="1">ceny rosnąco</option>
                        <option value="2">ceny malejąco</option>
                        <option value="3">nazwy A-Z</option>
                        <option value="4">nazwy Z-A</option>
                        <option value="5">Najnowszych</option>
                        <option value="6">Najstarszych</option>
                    </select>

                    <!-- <button id="sort_button" onclick="sortBooks()">Sortuj</button> -->

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
                        <!-- (szukaj tytułu w tej kategorii) -->
                        <!-- <div id="div-search">-->
                        <form action="../user/index.php" method="get">
                            <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                            <input type="submit" value="">
                        </form>
                    </div>

                    <?php
                    query("SELECT DISTINCT imie, nazwisko, id_autora FROM authors", "get_authors", ""); // lista <ul> autorów
                    ?>

                    <button id="filter-authors">Zastosuj</button>

                </div> <!-- #nav -->

            </aside> <!-- #book-filters -->

            <div id="content">


                <div id="circle-plot">
                    <svg viewBox="0 0 100 100">
                        <circle cx="15" cy="17" r="10" stroke="#D3D3D3" stroke-width="1" fill="none" />

                        <circle id="rating-circle" cx="15" cy="17" r="10" stroke="#ffc107" stroke-width="1" fill="none"
                                stroke-dasharray="62.8"
                                :style="`stroke-dashoffset: ${100 - rating}%`" class="filled">
                        </circle>

                        <text x="15" y="18.5" text-anchor="middle" font-size="3">
                            <tspan x="15" dy="-0.5em">średnia</tspan>
                            <tspan x="15" dy="1.2em">{{ rating }}</tspan>
                        </text>
                    </svg>
                </div>

                <!--stroke-dashoffset="' + (100 - rating) + '%" class="filled"-->



                <script>
                    /*const rating = 3.33;

                    const circle = document.getElementById('rating-circle');
                    const circumference = 2 * Math.PI * circle.getAttribute('r');
                    const offset = circumference * (1 - (rating / 5)); // Assuming the rating is out of 5

                    circle.style.strokeDasharray = `${circumference}`;
                    circle.style.strokeDashoffset = `${offset}`;*/

                    // Assuming you have a variable named 'rating' that holds the average rating value
                        const rating = 4.2;

                        const circle = document.getElementById('rating-circle');
                    const circumference = 2 * Math.PI * circle.getAttribute('r');
                    const offset = circumference * (1 - (rating / 5)); // Assuming the rating is out of 5

                    circle.style.strokeDasharray = `${circumference}`;
                    circle.style.strokeDashoffset = `${offset}`;


                    // To fill the circle proportionally based on the average rating using JavaScript, you can dynamically calculate the stroke-dashoffset value based on the rating. Here's an example of how you can achieve this.










                </script>


































            </div>

        </main>
    </div> <!-- #container -->

    <!-- <footer>
        <div id="footer">
            <script src="../scripts/set-theme.js"></script>
            <pre>
                <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer> -->

    <?php require "../view/___footer.php"; ?>

</div> <!-- #main-container -->




</body>
</html>