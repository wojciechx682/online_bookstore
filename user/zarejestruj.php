<?php
    require_once "../start-session.php"; // reCaptcha - site-key -> linia 376
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/header-container.php"; ?>

    <div id="container">

        <main>

            <div id="content">

                <form method="post" action="rejestracja.php" id="register-form">

                    <b>Stwórz nowe konto klienta</b><hr class="register-form-hr-line">

                    <div class="form-section">

                        <span class="row">
                            <label>
                                Imię: <input type="text" name="imie" required maxlength="255" value="<?php
                                    if (isset($_SESSION["register_imie"])) {
                                        echo $_SESSION["register_imie"];
                                            unset($_SESSION["register_imie"]);
                                    }
                                    else {
                                        echo "Adam";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_imie"])) {
                                        echo '<div class="error">'.$_SESSION["e_imie"].'</div>';
                                            unset($_SESSION["e_imie"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Nazwisko: <input type="text" name="nazwisko" required maxlength="255" value="<?php
                                    if (isset($_SESSION["register_nazwisko"])) {
                                        echo $_SESSION["register_nazwisko"];
                                            unset($_SESSION["register_nazwisko"]);
                                    }
                                    else {
                                        echo "Nowak";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_nazwisko"])) {
                                        echo '<div class="error">'.$_SESSION["e_nazwisko"].'</div>';
                                            unset($_SESSION["e_nazwisko"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                E-mail: <input type="email" name="email" required maxlength="255" value="<?php
                                    if (isset($_SESSION["register_email"])) {
                                        echo $_SESSION["register_email"];
                                            unset($_SESSION["register_email"]);
                                    }
                                    else {
                                        echo "adam.nowak@wp.pl";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_email"])) {
                                        echo '<div class="error">'.$_SESSION["e_email"].'</div>';
                                            unset($_SESSION["e_email"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Hasło: <input type="password" name="haslo1" maxlength="30" id="haslo1"
                                              required>

                                <div id="feedback" style="color:red;"></div>

                                <?php
                                    if (isset($_SESSION["e_haslo"])) {
                                        echo '<div class="error">'.$_SESSION["e_haslo"].'</div>';
                                            unset($_SESSION["e_haslo"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Powtórz hasło: <input type="password" name="haslo2" maxlength="30"
                                                      required>
                            </label>
                        </span>

                    </div> <!-- .form-section -->

                    <div class="form-section"> <!-- Dane adresowe -->

                        <span class="row">
                            <label>
                                Miejscowość: <input type="text" name="miejscowosc" required value="<?php
                                    if (isset($_SESSION["register_miejscowosc"])) {
                                        echo $_SESSION["register_miejscowosc"];
                                            unset($_SESSION["register_miejscowosc"]);
                                    }
                                    else {
                                        echo "Dolna odra";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_miejscowosc"])) {
                                        echo '<div class="error">'.$_SESSION["e_miejscowosc"].'</div>';
                                            unset($_SESSION["e_miejscowosc"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Ulica: <input type="text" name="ulica" value="<?php
                                    if (isset($_SESSION["register_ulica"])) {
                                        echo $_SESSION["register_ulica"];
                                            unset($_SESSION["register_ulica"]);
                                    }
                                    else {
                                        echo "Słoneczna";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_ulica"])) {
                                        echo '<div class="error">'.$_SESSION["e_ulica"].'</div>';
                                            unset($_SESSION["e_ulica"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Numer domu: <input type="text" name="numer_domu" value="<?php
                                    if (isset($_SESSION["register_numer_domu"])) {
                                        echo $_SESSION["register_numer_domu"];
                                            unset($_SESSION["register_numer_domu"]);
                                    }
                                    else {
                                        echo "61";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_numer_domu"])) {
                                        echo '<div class="error">'.$_SESSION["e_numer_domu"].'</div>';
                                            unset($_SESSION["e_numer_domu"]);
                                    }
                                ?>
                            </label>
                        </span>

                    </div>

                    <div class="form-section">

                        <span class="row">
                            <label>
                                Kod pocztowy: <input type="text" name="kod_pocztowy" value="<?php
                                    if (isset($_SESSION["register_kod_pocztowy"])) {
                                        echo $_SESSION["register_kod_pocztowy"];
                                            unset($_SESSION["register_kod_pocztowy"]);
                                    }
                                    else {
                                        echo "64-600";
                                    }
                                    ?>"> <br>

                                <?php
                                    if (isset($_SESSION["e_kod_pocztowy"])) {
                                        echo '<div class="error">'.$_SESSION["e_kod_pocztowy"].'</div>';
                                            unset($_SESSION["e_kod_pocztowy"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Miejscowość: <input type="text" name="kod_miejscowosc" value="<?php
                                    if (isset($_SESSION["register_kod_miejscowosc"])) {
                                        echo $_SESSION["register_kod_miejscowosc"];
                                            unset($_SESSION["register_kod_miejscowosc"]);
                                    }
                                    else {
                                        echo "Dolna odra";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_kod_miejscowosc"])) {
                                        echo '<div class="error">'.$_SESSION["e_kod_miejscowosc"].'</div>';
                                            unset($_SESSION["e_kod_miejscowosc"]);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Telefon (PL +48): <input type="tel" name="telefon" value="<?php
                                    if(isset($_SESSION["register_telefon"])) {
                                        echo $_SESSION["register_telefon"];
                                            unset($_SESSION["register_telefon"]);
                                    }
                                    else {
                                        echo "505101303";
                                    } ?>">

                                <?php
                                    if (isset($_SESSION["e_telefon"])) {
                                        echo '<div class="error">'.$_SESSION["e_telefon"].'</div>';
                                            unset($_SESSION["e_telefon"]);
                                    }
                                ?>
                            </label>
                        </span>

                    </div>

                    <div style="clear: both;"></div>

                    <hr class="register-form-hr-line">

                    <label>
                        <input type="checkbox" name="regulamin" <?php
                            if (isset($_SESSION["register_regulamin"])) {
                                echo "checked";
                                    unset($_SESSION["register_regulamin"]);
                            } else {
                                echo "checked";
                            } ?>>

                        Akceptuję regulamin
                    </label>

                    <?php
                        if (isset($_SESSION["e_regulamin"])) { // błąd z akceptacją regulaminu (checkbox);
                            echo '<div class="error" style="margin-top: 10px;">'.$_SESSION["e_regulamin"].'</div>';
                                unset($_SESSION["e_regulamin"]);
                        }
                    ?>

                    <div class="g-recaptcha" data-sitekey="6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1"></div>

                    <?php
                        if (isset($_SESSION["e_recaptcha"])) { // błąd z reCaptcha;
                            echo '<div class="error">'.$_SESSION["e_recaptcha"].'</div>';
                                unset($_SESSION["e_recaptcha"]);
                        }
                    ?>


                    <input type="submit" value="Zarejestruj się" id="register-button">

                    <?php
                        if (isset($_SESSION["e_fields"])) { // nie wypełniono wszystkich pol;
                            echo '<div class="error">'.$_SESSION["e_fields"].'</div>';
                                unset($_SESSION["e_fields"]);
                        }
                    ?>

                    <?php
                        if (isset($_SESSION["register-error"]) && $_SESSION["register-error"]) { // nie udało się wstawić wierszy do tabeli "adres";
                            echo '<div class="error">Wystąpił błąd. Spróbuj jeszcze raz</div>';
                                unset($_SESSION["register-error"]);
                        }
                    ?>

                    <?php
                        /*reCAPTCHA (v2) - jan.nowak.6820@gmail.com

                        klucze reCAPTCHA (v2) :
                            Site key = klucz jawny (HTML)
                            Secret key = klucz tajny (PHP)

                        Tworzenie reCaptcha:

                            google.com/recaptcha

                            -> v3 Admin Console
                            -> Utwórz + (google.com/recaptcha/admin/create)

                        etykieta: "XAMPP"
                        nazwa domeny : "localhost"

                        Site Key   :    	(html)    	6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1
                        Secret Key : 		(PHP)    	6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG

                        Umieszceznie reCAPTCHA w html :
                        -> v3 Documentation*/
                    ?>

                </form>

            </div>

        </main>

        <script>

            function checkUsername(e, minLength) {
                let elMsg = document.getElementById("feedback");
                let elUsernmae = document.getElementById("haslo1");

                let eventElement = e.target;
                console.log("eventElement = ", eventElement);
                let elementParent = eventElement.parentElement;
                console.log("elementParent = ", elementParent);
                let elementGrandParent = eventElement.parentNode.parentNode;
                console.log("elementGrandParent = ", elementGrandParent);

                if(elUsernmae.value.length < minLength) {
                    elMsg.textContent = "Hasło musi mieć conajmniej " + minLength + " znaków ";

                } else {
                    elMsg.textContent = "";
                }
            }

            function removeMsg(e) {
                let elMsg = document.getElementById("feedback");

                let eventElement = e.target;
                console.log("eventElement = ", eventElement);

                if(elMsg.textContent !== "") {
                    elMsg.textContent = "";
                }
            }

            let el = document.getElementById("haslo1");

            el.addEventListener("blur", function(e) {
                checkUsername(e, 10);
            }, false);

            el.addEventListener("focus", function(e) {
                removeMsg(e);
            }, false);

        </script>

    </div>

    <?php require "../view/footer.php" ?>

</div>

<script>
    content = document.getElementById("content");
    content.style.width = "100%";
</script>


<script src="https://www.google.com/recaptcha/api.js"></script>

</body>
</html>