<?php

    require_once "../start-session.php";

	if ( isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true &&

        ! isset($_SESSION["udanarejestracja"]) &&
        ! isset($_SESSION["login-error"]) ) // authenticate-user.php
	{
        // ✓ "jeśli weszliśmy na zaloguj.php będąc wcześniej zalogowanym" ;

        // - (i nie było to przekierowanie po zakończeniu pomyślnej rejestracji /będąc zalogowanym na inne konto);
            // zmienna $_SESSION['zaloogwany'] jest ustawiana na wartość "true" wewnątrz funkcji log_in() - tylko wtedy, jeśli podano poprawne dane logowania;

		header("Location: ___account.php"); // przekierowanie na strone profilu użytkownika;
		exit();
	}
	elseif ( isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true &&
             isset($_SESSION["udanarejestracja"]) && $_SESSION["udanarejestracja"] === true &&

             ! isset($_SESSION["login-error"]) ) // authenticate-user.php
	{
        // ✓ jeśli (pomyślnie) stworzyliśmy konto, będąc zalogowanym na inne ;

        /*echo "<br>25<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
        echo "GET ->"; print_r($_GET); echo "<hr><br>";
        echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>"; exit();*/

		header("Location: logout.php"); // ustawi zmienną $_SESSION['udanarejestracja'] = true, przekieruje z powrotem do zaloguj.php (spełni się 3-ci warunek w zaloguj.php);
		exit();
	}
	elseif ( ! isset($_SESSION["zalogowany"]) &&
               isset($_SESSION["udanarejestracja"]) &&

             ! isset($_SESSION["login-error"]) // authenticate-user.php
    ) // ✓ jeśli stworzyliśmy konto (normalnie - nie będąc zalogowanym w tym czasie na inne);
	{
		// unset($_SESSION['udanarejestracja']);

		// ✓ Usuwanie zmiennych pamiętających wartości wpisane do formularza - ponieważ ISTNIEJĄ one po pomyślnym stowrzeniu nowego konta !
		/*if (isset($_SESSION['register_imie'])) unset($_SESSION['register_imie']);
		if (isset($_SESSION['register_nazwisko'])) unset($_SESSION['register_nazwisko']);
		if (isset($_SESSION['register_email'])) unset($_SESSION['register_email']);
            //		if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
            //		if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
		if (isset($_SESSION['register_miejscowosc'])) unset($_SESSION['register_miejscowosc']);
		if (isset($_SESSION['register_ulica'])) unset($_SESSION['register_ulica']);
		if (isset($_SESSION['register_numer_domu'])) unset($_SESSION['register_numer_domu']);
		if (isset($_SESSION['register_kod_pocztowy'])) unset($_SESSION['register_kod_pocztowy']);
		if (isset($_SESSION['register_kod_miejscowosc'])) unset($_SESSION['register_kod_miejscowosc']);
		if (isset($_SESSION['register_telefon'])) unset($_SESSION['register_telefon']);
		if (isset($_SESSION['register_regulamin'])) unset($_SESSION['register_regulamin']);*/

        unset($_SESSION["valid"], $_SESSION["register_imie"], $_SESSION["register_nazwisko"], $_SESSION["register_email"], $_SESSION["register_miejscowosc"], $_SESSION["register_ulica"], $_SESSION["register_numer_domu"], $_SESSION["register_kod_pocztowy"], $_SESSION["register_kod_miejscowosc"], $_SESSION["register_telefon"], $_SESSION["register_regulamin"]);

        // (?) ewentualnie - zamiast tego -> wylogowanie - usuwa wszystkie zmienne sesyjne

		// Usuwanie błędów rejestracji - Te zmienne nie istnieją jeśli udało się stworzyć konto !;  A co jeśli udało się stworzyć konto, ale wcześniej ktoś wywołałe te błędy ... ?
        // Usunąć poniższe zakomentowane linie, te zmienne nie istnieją, jeśli udało się stworzyć konto (nie ważne czy user był zalogowany, czy nie);

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

	/*include_once "../functions.php";*/

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

                    <?php
                        /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";*/
                    ?>

                    <!-- Formularz Logowania -->

                    <!-- Księgarnia online<br><br> -->

                    <form action="logowanie.php" method="post" id="login-form">

                        <b>Zaloguj się na swoje konto</b><hr class="register-form-hr-line login-form-hr-line">

                        <div class="login-form-section">

                            <span class="login-row">
                                    <label>
                                        E-mail <input type="email" name="email" required value="adam.nowak1@wp.pl">
                                    </label>
                            </span>

                            <span class="login-row">
                                    <label>
                                        Hasło <input type="password" name="password" required value="PassJacob33#" autocomplete="off">
                                    </label>
                            </span>


                            <div class="g-recaptcha g-recaptcha-login" data-sitekey="6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1"></div>

                            <input type="submit" value="Zaloguj się">

                        </div>

                    </form>

                    <hr class="register-form-hr-line">

                    <a href="___reset_password.php" class="a-login-page-link">Przypomnij hasło</a>

                    <a href="___zarejestruj.php" class="a-login-page-link">Nie posiadasz konta? Zarejestruj się</a>


                    <?php
                        if (isset($_SESSION["password-changed"]) && $_SESSION["password-changed"]) {
                            // if variable EXISTS and has value egual to "TRUE";
                            echo "<h3 class='success'>Hasło zostało zmienione</h3>";
                            session_unset();
                            session_destroy();
                        }
                    ?>

                    <?php
                        // pokazujemy zawartość tej zmiennej tylko jeśli podano NIEPRAWIDŁOWY login lub hasło;
                            // czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI;
                        // normalne logowanie, podany zły login/hasło;
                        if (isset($_SESSION["invalid_credentials"])) {
                            echo $_SESSION["invalid_credentials"]; // wyświetlenie komunikatu "Nieprawidłowy e-mail lub hasło";
                                unset($_SESSION["invalid_credentials"]);
                        }
                    ?>

                    <?php
                        if(isset($_SESSION["e_recaptcha"])) // błąd z reCaptcha;
                        {
                            echo $_SESSION["e_recaptcha"];
                                unset($_SESSION["e_recaptcha"]);
                        }
                    ?>



                    <?php

                        if(isset($_SESSION["udanarejestracja"]) && $_SESSION["udanarejestracja"]) {

                            unset($_SESSION["udanarejestracja"]);

                            echo '<span class="success">Rejestracja przebiegła pomyślnie, od teraz możesz zalogować się na swoje konto</span><br>';
                        }

                        if(isset($_SESSION["deleted-successfully"]) && $_SESSION["deleted-successfully"])
                        {
                            unset($_SESSION["deleted-successfully"]);

                            echo '<span style="font-weight: bold;">Twoje konto zostało usunięte</span><br>';
                        }
                    ?>

                </div>

            </main>

        </div>

        <script>
            // ustawienie width div#content na 100%;
            content = document.getElementById("content");
            content.style.width = "100%";
        </script>

        <?php require "../view/___footer.php" ?>

    </div>

    <div id="login-error-message" class="hidden">
        <h2>Musisz być zalogowany !</h2>
            <hr>
        <button id="confirm-message" class="btn-link btn-link-static">
            Potwierdź
        </button>
    </div>

    <div class="background">

    </div>

    <?php if ( isset($_SESSION["login-error"]) && $_SESSION["login-error"] ) : ?>

        <?php //unset($_SESSION["login-error"]) ?>
        <?php session_unset(); ?>

        <script>
                let statusBox = document.getElementById("login-error-message");
                let container = document.querySelector(".background");
            statusBox.classList.toggle("hidden");
            container.classList.toggle("bright");
            let confirmBtn = document.getElementById("confirm-message");
            confirmBtn.addEventListener("click", function() {
                //console.log("\nclicked ! ");
                statusBox.classList.toggle("hidden");
                container.classList.toggle("bright");
                container.style.pointerEvents = "none"; // ✓
            });
        </script>

    <?php else: ?>

        <script>
            let container = document.querySelector(".background");
            container.style.pointerEvents = "none"; // ✓
        </script>

    <?php endif; ?>
<!--
    <script>
        let statusBox = document.getElementById("login-error-message");
            // całe okiento z błędem logowania ;

        let container = document.querySelector(".background"); /* dark background <div> */

        /*let allContainer = body.parentElement;

        if(!statusBox.classList.contains("hidden")) {
            allContainer.classList.toggle("bright");
        }*/

        let confirmBtn = document.getElementById("confirm-message");


        console.log("\n258 ! ");

        console.log("\nstatusBox ->", statusBox);
        console.log("\ncontainer ->", container);
        console.log("\nconfirmBtn ->", confirmBtn);

        confirmBtn.addEventListener("click", function() {

            console.log("\nclicked ! ");


            statusBox.classList.toggle("hidden");
            container.classList.toggle("bright");
        });

    </script> -->

    <script src="https://www.google.com/recaptcha/api.js"></script>

</body>
</html>
