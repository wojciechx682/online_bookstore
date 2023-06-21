<?php

	session_start();
	
	if( isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == "true" && ! isset($_SESSION['udanarejestracja']) )
	{   // ✓ "jeśli weszliśmy na zaloguj.php będąc zalogowanym"; - (i nie było to przekierowanie po zakończeniu pomyślnej rejestracji będąc zalogowanym na inne konto);

        // zmienna $_SESSION['zalogowany'] jest ustawiana na wartość "true" wewnątrz funkcji log_in() - tylko wtedy, jeśli podano poprawne dane logowania;
		header("Location: ___index2.php"); // index.php;
		exit();
	}
	elseif( isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == "true" && isset($_SESSION['udanarejestracja']) && $_SESSION['udanarejestracja'] == "true" )
	{   // ✓ jeśli pomyślnie stworzyliśmy konto, będąc zalogowanym na inne;
		header("Location: logout.php");
		exit();
	}
	elseif( !isset($_SESSION['zalogowany']) &&
             isset($_SESSION['udanarejestracja'])
    ) // ✓ jeśli stworzyliśmy konto (normalnie - nie będąc zalogowanym w tym czasie na inne);
	{
		//unset($_SESSION['udanarejestracja']);

        /*echo "<br> 23 <br> get -> " . print_r($_GET) . "<br>";
        echo "<br> post -> " . print_r($_POST) . "<br>";
        echo "<br> session -> " . print_r($_SESSION) . "<br>"; exit();*/



		// ✓ Usuwanie zmiennych pamiętających wartości wpisane do formularza - ponieważ ISTNIEJĄ one po pomyślnym stowrzeniu nowego konta !
		if (isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
		if (isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
		if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
//		if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
//		if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
		if (isset($_SESSION['fr_miejscowosc'])) unset($_SESSION['fr_miejscowosc']);
		if (isset($_SESSION['fr_ulica'])) unset($_SESSION['fr_ulica']);
		if (isset($_SESSION['fr_numer_domu'])) unset($_SESSION['fr_numer_domu']);
		if (isset($_SESSION['fr_kod_pocztowy'])) unset($_SESSION['fr_kod_pocztowy']);
		if (isset($_SESSION['fr_kod_miejscowosc'])) unset($_SESSION['fr_kod_miejscowosc']);
		if (isset($_SESSION['fr_telefon'])) unset($_SESSION['fr_telefon']);
		if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

        // (?) ewentualnie - zamiast tego -> wylogowanie - usuwa wszystkie zmienne sesyjne

		// Usuwanie błędów rejestracji - Te zmienne nie istnieją jeśli udało się stworzyć konto !;  A co jeśli udało się stworzyć konto, ale wcześniej ktoś wywołałe te błędy ... ?
//		if (isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
//		if (isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
//		if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
//		if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
//		if (isset($_SESSION['e_miejscowosc'])) unset($_SESSION['e_miejscowosc']);
//		if (isset($_SESSION['e_ulica'])) unset($_SESSION['e_ulica']);
//		if (isset($_SESSION['e_numer_domu'])) unset($_SESSION['e_numer_domu']);
//		if (isset($_SESSION['e_kod_pocztowy'])) unset($_SESSION['e_kod_pocztowy']);
//		if (isset($_SESSION['e_kod_miejscowosc'])) unset($_SESSION['e_kod_miejscowosc']);
//		if (isset($_SESSION['e_telefon'])) unset($_SESSION['e_telefon']);
//		if (isset($_SESSION['e_kod_miejscowosc'])) unset($_SESSION['e_kod_miejscowosc']);
//		if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
//		if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

		if (isset($_SESSION['blad'])) unset($_SESSION['blad']);
	}

	include_once "../functions.php";

	//query("", "", "");
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php" ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php" ?>

        <div id="container">

            <main>

                <div id="content">

                    <?php echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>"; ?>

                    <!-- Formularz Logowania -->

                    <!-- Księgarnia online<br><br> -->

                    <form action="logowanie.php" method="post" id="login-form">

                        <div class="login-form-section">

                            <span class="login-row">
                                    <label>
                                        E-mail <input type="email" name="email" required value="adam.nowak@wp.pl">
                                    </label>
                            </span>
                            <span class="login-row">
                                    <label>
                                        Hasło <input type="password" name="haslo" required value="PassJacob33#"
                                                           autocomplete="off"> <!-- jan -> jan1 -->
                                    </label>
                            </span>

                            <input type="submit" value="Zaloguj się">

                        </div> <!-- .login-form-section -->

                    </form>



                    <a href="___reset_password.php" class="a-login-page-link">Przypomnij hasło</a>

                    <a href="___zarejestruj.php" class="a-login-page-link">Nie posiadasz konta? Zarejestruj się</a>


                    <?php
                        if( isset($_SESSION["password-changed"]) && $_SESSION["password-changed"] )
                        {   // if variable EXISTS and has value egual to "TRUE";
                            echo "<h3>Udało się zmienić hasło</h3>";
                            session_unset();
                            session_destroy();
                        }
                    ?>

                    <?php
                        // pokazujemy zawartość tej zmiennej tylko jeśli podano nieprawidłowy login lub hasło;
                        // czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI;
                        // normalne logowanie, podany złe hasło;
                        if(isset($_SESSION['blad']))
                        {
                            echo ''.$_SESSION['blad']; // wyświetlenie komunikatu "nieprawidłowy login lub hasło";
                            unset($_SESSION["blad"]);
                        }
                    ?>

                    <?php

                        if(isset($_SESSION['udanarejestracja']))
                        {
                            unset($_SESSION['udanarejestracja']);

                            echo '<span style="font-weight: bold;">Rejestracja przebiegła pomyślnie - od teraz możesz zalogować się na swoje konto</span><br>';
                        }

                        if(isset($_SESSION['deleted-successfully']) && $_SESSION['deleted-successfully'])
                        {
                            unset($_SESSION['deleted-successfully']);

                            echo '<span style="font-weight: bold;">Twoje konto zostało usunięte</span><br>';
                        }
                    ?>

                </div> <!-- #content -->
            </main>
        </div> <!-- #container -->

        <script>
            // ustawienie wid div#content na 100%;
            content = document.getElementById("content");
            content.style.width = "100%";

        </script>

        <?php require "../view/___footer.php" ?>

    </div> <!-- #main-container -->
	
</body>
</html>
