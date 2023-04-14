<?php

	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true") && (!(isset($_SESSION['udanarejestracja'])))) // jeśli weszliśmy na zaloguj.php będąc zalogowanym
	{
		header("Location: index.php");
		exit();
	}
	elseif((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true") && (isset($_SESSION['udanarejestracja'])) && ($_SESSION['udanarejestracja'] == "true")) // jeśli stworzyliśmy konto, będąc zalogowanym na inne
	{
		header("Location: logout.php");
		exit();
	}
	elseif(!isset($_SESSION['zalogowany']) &&
            isset($_SESSION['udanarejestracja'])
    ) // jeśli stworzyliśmy konto (normalnie - nie będąc zalogowanym w tym czasie na inne)
	{
		//unset($_SESSION['udanarejestracja']);

		// Usuwanie zmiennych pamiętających wartości wpisane do formularza
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



<div id="all-container">

    <?php require "../view/___header-container.php" ?>

	<div id="container">

        <main>

            <!--<div id="nav"></div>-->

            <div id="content">

                <?php // var_dump($_SESSION); ?>

                <!-- Formularz Logowania -->

                <!--Księgarnia online<br><br>-->

                <form action="logowanie.php" method="post" id="login-form">

                    <div class="login-form-section">

                        <span class="login-row">
                                <label>
                                    <!-- Login: <br> <input type="text" name="login"> <br> -->
                                    E-mail <input type="email" name="email" required value="jakub.nowak.382@gmail.com">
                                </label>
                        </span>
                        <span class="login-row">
                                <label>
                                    Hasło <input type="password" name="haslo" required value="aosdasdoaidsad#"
                                                       autocomplete="off">
                                </label>
                        </span>

                        <input type="submit" value="Zaloguj się">

                    </div>

                </form>

                <br><a href="___reset_password.php">Przypomnij hasło</a><br>

                <br><a href="zarejestruj.php">Nie posiadasz konta? Zarejestruj się</a><br>

                <?php
                    if(isset($_SESSION["password-changed"]) && $_SESSION["password-changed"]) {
                        echo "<h3>udało się zmienić hasło</h3>";
                        session_unset();
                        session_destroy();
                    }
                ?>

                <?php
                    // pokazujemy zawartość tej zmiennej tylko jeśli podano nieprawidłowy login lub hasło
                    // czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI

                    // normalne logowanie, podany złe hasło
                    if(isset($_SESSION['blad']))
                    {
                        echo '<br>'.$_SESSION['blad'];
                        unset($_SESSION["blad"]);
                    }
                ?>

                <?php

                    if(isset($_SESSION['udanarejestracja']))
                    {
                        unset($_SESSION['udanarejestracja']);

                        echo '<br><span style="color: blue;">Rejestracja przebiegła pomyślnie - od teraz możesz zalogować się na swoje konto</span><br>';
                    }

                    if(isset($_SESSION['deleted-successfully']) && $_SESSION['deleted-successfully'])
                    {
                        unset($_SESSION['deleted-successfully']);

                        echo '<br><span style="color: blue;">Twoje konto zostało usunięte</span><br>';
                    }
                ?>

            </div>

        </main>

	</div>


    <script>
        content = document.getElementById("content"); // ustawienie wid div#content na 100%
        //console.log("content -> ", content);
        content.style.width = "100%";

        /*formSection = document.querySelector(".form-section");
        formSection.style.width = "25%";*/
    </script>

    <?php require "../view/___footer.php" ?>

</div>
	
</body>
</html>