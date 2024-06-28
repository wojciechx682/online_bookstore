<?php

    require_once "../start-session.php";

	if (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true &&
        !isset($_SESSION["udanarejestracja"]) &&
        !isset($_SESSION["login-error"]) ) {
		    header("Location: account.php");
		        exit();
	}
	elseif (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true &&
            isset($_SESSION["udanarejestracja"]) && $_SESSION["udanarejestracja"] === true &&
            !isset($_SESSION["login-error"]) ) {
		    header("Location: logout.php");
		        exit();
	}
	elseif (!isset($_SESSION["zalogowany"]) &&
             isset($_SESSION["udanarejestracja"]) &&
             !isset($_SESSION["login-error"])
    ) {

        unset($_SESSION["valid"], $_SESSION["register_imie"], $_SESSION["register_nazwisko"], $_SESSION["register_email"], $_SESSION["register_miejscowosc"], $_SESSION["register_ulica"], $_SESSION["register_numer_domu"], $_SESSION["register_kod_pocztowy"], $_SESSION["register_kod_miejscowosc"], $_SESSION["register_telefon"], $_SESSION["register_regulamin"]);

		if (isset($_SESSION['blad'])) unset($_SESSION['blad']);
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php" ?>

<body>

    <div id="main-container">

        <?php require "../view/header-container.php" ?>

        <div id="container">

            <main>

                <div id="content">

                    <form action="logowanie.php" method="post" id="login-form">

                        <b>Zaloguj się na swoje konto</b><hr class="register-form-hr-line login-form-hr-line">

                        <div class="login-form-section">

                            <span class="login-row">
                                <label>
                                    E-mail <input type="email" name="email" required value="adam.nowak@wp.pl">
                                </label>
                            </span>

                            <span class="login-row">
                                <label>
                                    Hasło <input type="password" name="password" required autocomplete="off">
                                </label>
                            </span>


                            <div class="g-recaptcha g-recaptcha-login" data-sitekey="6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1"></div>

                            <input type="submit" value="Zaloguj się">

                        </div>

                    </form>

                    <hr class="register-form-hr-line">

                    <a href="reset_password.php" class="a-login-page-link">Przypomnij hasło</a>

                    <a href="zarejestruj.php" class="a-login-page-link">Nie posiadasz konta? Zarejestruj się</a>


                    <?php
                        if (isset($_SESSION["password-changed"]) && $_SESSION["password-changed"]) {
                            echo "<h3 class='success'>Hasło zostało zmienione</h3>";
                                session_unset();
                                    session_destroy();
                        }
                    ?>

                    <?php
                        if (isset($_SESSION["invalid_credentials"])) {
                            echo $_SESSION["invalid_credentials"];
                                unset($_SESSION["invalid_credentials"]);
                        }
                    ?>

                    <?php
                        if(isset($_SESSION["e_recaptcha"])) {
                            echo $_SESSION["e_recaptcha"];
                                unset($_SESSION["e_recaptcha"]);
                        }
                    ?>

                    <?php

                        if(isset($_SESSION["udanarejestracja"]) && $_SESSION["udanarejestracja"]) {

                            unset($_SESSION["udanarejestracja"]);
                                echo '<span class="success">Rejestracja przebiegła pomyślnie, od teraz możesz zalogować się na swoje konto</span><br>';
                        }

                        if(isset($_SESSION["deleted-successfully"]) && $_SESSION["deleted-successfully"]) {
                            unset($_SESSION["deleted-successfully"]);
                                echo '<span style="font-weight: bold;">Twoje konto zostało usunięte</span><br>';
                        }
                    ?>

                </div>

            </main>

        </div>

        <script>
            content = document.getElementById("content");
            content.style.width = "100%";
        </script>

        <?php require "../view/footer.php" ?>

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

        <?php session_unset(); ?>

        <script>
                let statusBox = document.getElementById("login-error-message");
                let container = document.querySelector(".background");
            statusBox.classList.toggle("hidden");
            container.classList.toggle("bright");
            let confirmBtn = document.getElementById("confirm-message");
            confirmBtn.addEventListener("click", function() {
                statusBox.classList.toggle("hidden");
                container.classList.toggle("bright");
                container.style.pointerEvents = "none";
            });
        </script>

    <?php else: ?>

        <script>
            let container = document.querySelector(".background");
            container.style.pointerEvents = "none"; // ✓
        </script>

    <?php endif; ?>

    <script src="https://www.google.com/recaptcha/api.js"></script>

</body>
</html>
