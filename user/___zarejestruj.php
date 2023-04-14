<?php
	session_start();
	include_once "../functions.php";

    // reCaptcha - sitekey -> linia 337
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="all-container">

<?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <!--<div id="nav"></div>-->

            <div id="content">

                <!-- Formularz rejestracji -->

                <form method="post" action="rejestracja.php" id="register-form">

                    Stwórz nowe konto klienta<br><hr>

                    <div class="form-section">

                        <span class="row">
                            <label>
                                Imię: <input type="text" name="imie" required value="<?php
                                if(isset($_SESSION['fr_imie']))
                                {
                                    echo $_SESSION['fr_imie'];
                                    unset($_SESSION['fr_imie']);
                                }
                                else {
                                    echo "Adam";
                                } ?>"> <br>

                                <?php
                                    if(isset($_SESSION['e_imie'])) {
                                        echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                                        unset($_SESSION['e_imie']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Nazwisko: <input type="text" name="nazwisko" required value="<?php
                                if(isset($_SESSION['fr_nazwisko']))
                                {
                                    echo $_SESSION['fr_nazwisko'];
                                    unset($_SESSION['fr_nazwisko']);
                                }
                                else {
                                    echo "Nowak";
                                } ?>">

                                <?php
                                    if(isset($_SESSION['e_nazwisko'])) // błąd z naziwskiem użytkownika
                                    {
                                        echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                                        unset($_SESSION['e_nazwisko']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <!-- type="email" -->
                            <label>
                                E-mail: <input type="email" name="email" required value="<?php
                                if(isset($_SESSION['fr_email']))
                                {
                                    echo $_SESSION['fr_email'];
                                    unset($_SESSION['fr_email']);
                                }
                                else {
                                    echo "adam.nowak@wp.pl";
                                } ?>">

                                <?php
                                    if(isset($_SESSION['e_email']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                        unset($_SESSION['e_email']);
                                    }
                                ?>
                            </label>
                        </span>

                        <!-- Nickname: <br> <input type="text" name="nick" value="<?php /*
                            if(isset($_SESSION['fr_nick']))
                            {
                                echo $_SESSION['fr_nick'];
                                unset($_SESSION['fr_nick']);
                            }
                        */ ?>"> <br> -->

                        <?php
                            /*if(isset($_SESSION['e_nick'])) // błąd z nickiem użytkownika ...
                            {
                                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                                unset($_SESSION['e_nick']);
                            } */
                        ?>


                        <span class="row">
                            <label>
                                Hasło: <input type="password" maxlength="30" id="haslo1" name="haslo1"
                                                   required value="PassJacob33#" >
                                <div id="feedback"></div>

                                <?php
                                    if(isset($_SESSION['e_haslo']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                                        unset($_SESSION['e_haslo']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Powtórz hasło: <input type="password" maxlength="30" name="haslo2"
                                                           required value="PassJacob33#">
                            </label>
                        </span>

                        <!-- <br> <hr> -->
                    </div>

                    <div class="form-section">
                        <!--Dane adresowe <br><br>-->


                        <span class="row">
                            <label>
                                Miejscowość: <input type="text" name="miejscowosc" value="<?php
                                    if(isset($_SESSION['fr_miejscowosc']))
                                    {
                                        echo $_SESSION['fr_miejscowosc'];
                                        unset($_SESSION['fr_miejscowosc']);
                                    }
                                    else {
                                        echo "Dolna odra";
                                    }
                                ?>">

                                <?php
                                    if(isset($_SESSION['e_miejscowosc']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_miejscowosc'].'</div>';
                                        unset($_SESSION['e_miejscowosc']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Ulica: <input type="text" name="ulica" value="<?php
                                    if(isset($_SESSION['fr_ulica']))
                                    {
                                        echo $_SESSION['fr_ulica'];
                                        unset($_SESSION['fr_ulica']);
                                    }
                                    else {
                                        echo "Słoneczna";
                                    }
                                ?>">

                                <?php
                                    if(isset($_SESSION['e_ulica']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_ulica'].'</div>';
                                        unset($_SESSION['e_ulica']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Numer domu: <input type="text" name="numer_domu" value="<?php
                                    if(isset($_SESSION['fr_numer_domu']))
                                    {
                                        echo $_SESSION['fr_numer_domu'];
                                        unset($_SESSION['fr_numer_domu']);
                                    }
                                    else
                                    {
                                        echo "61";
                                    }
                                ?>">

                                <?php
                                    if(isset($_SESSION['e_numer_domu']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_numer_domu'].'</div>';
                                        unset($_SESSION['e_numer_domu']);
                                    }
                                ?>
                            </label>
                        </span>

                        <!-- <br>  <hr> <br> -->

                    </div>

                    <div class="form-section">

                        <span class="row">
                            <label>
                                Kod pocztowy: <input type="text" name="kod_pocztowy" value="<?php
                                    if(isset($_SESSION['fr_kod_pocztowy']))
                                    {
                                        echo $_SESSION['fr_kod_pocztowy'];
                                        unset($_SESSION['fr_kod_pocztowy']);
                                    }
                                    else {
                                        echo "64-600";
                                    }
                                ?>"> <br>

                                <?php
                                    if(isset($_SESSION['e_kod_pocztowy']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_kod_pocztowy'].'</div>';
                                        unset($_SESSION['e_kod_pocztowy']);
                                    }
                                ?>
                            </label>
                        </span>

                        <span class="row">
                            <label>
                                Miejscowość: <input type="text" name="kod_miejscowosc" value="<?php
                                    if(isset($_SESSION['fr_kod_miejscowosc']))
                                    {
                                        echo $_SESSION['fr_kod_miejscowosc'];
                                        unset($_SESSION['fr_kod_miejscowosc']);
                                    }
                                    else {
                                        echo "Dębno";
                                    }
                                ?>">

                                <?php
                                    if(isset($_SESSION['e_kod_miejscowosc']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_kod_miejscowosc'].'</div>';
                                        unset($_SESSION['e_kod_miejscowosc']);
                                    }
                                ?>
                            </label>
                        </span>

                        <!-- Województwo: <br> <input type="text" name="wojewodztwo" value="<?php /*
                            if(isset($_SESSION['fr_kod_wojewodztwo']))
                            {
                                echo $_SESSION['fr_kod_wojewodztwo'];
                                unset($_SESSION['fr_kod_wojewodztwo']);
                            }
                        */ ?>"> <br>

                        <?php /*
                            if(isset($_SESSION['e_kod_wojewodztwo']))
                            {
                                echo '<div class="error">'.$_SESSION['e_kod_wojewodztwo'].'</div>';
                                unset($_SESSION['e_kod_wojewodztwo']);
                            } */
                        ?>

                        Kraj: <br> <input type="text" name="kraj" value="<?php /*
                            if(isset($_SESSION['fr_kraj']))
                            {
                                echo $_SESSION['fr_kraj'];
                                unset($_SESSION['fr_kraj']);
                            }	*/
                        ?>"> <br>

                        <?php	/*
                            if(isset($_SESSION['e_kraj']))
                            {
                                echo '<div class="error">'.$_SESSION['e_kraj'].'</div>';
                                unset($_SESSION['e_kraj']);
                            }	*/
                        ?> -->

                        <!-- Pesel: <br> <input type="text" name="pesel" value="<?php /*
                            if(isset($_SESSION['fr_pesel']))
                            {
                                echo $_SESSION['fr_pesel'];
                                unset($_SESSION['fr_pesel']);
                            }
                        */ ?>"> <br>	-->

                        <?php /*
                            if(isset($_SESSION['e_pesel']))
                            {
                                echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
                                unset($_SESSION['e_pesel']);
                            }
                        */ ?>

                        <!-- Data urodzenia: <br> <input type="text" name="data_urodzenia" value="<?php /*
                            if(isset($_SESSION['fr_data_urodzenia']))
                            {
                                echo $_SESSION['fr_data_urodzenia'];
                                unset($_SESSION['fr_data_urodzenia']);
                            }
                        */ ?>"> <br>

                        <?php /*
                            if(isset($_SESSION['e_data_urodzenia']))
                            {
                                echo '<div class="error">'.$_SESSION['e_data_urodzenia'].'</div>';
                                unset($_SESSION['e_data_urodzenia']);
                            }	*/
                        ?> -->

                        <span class="row">
                            <label>
                                Telefon (PL +48): <input type="tel" name="telefon" value="<?php
                                    if(isset($_SESSION['fr_telefon']))
                                    {
                                        echo $_SESSION['fr_telefon'];
                                        unset($_SESSION['fr_telefon']);
                                    }
                                    else
                                    {
                                        echo "505101303";
                                    }
                                ?>">

                                <?php
                                    if(isset($_SESSION['e_telefon']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_telefon'].'</div>';
                                        unset($_SESSION['e_telefon']);
                                    }
                                ?>
                            </label>
                        </span>

                        <!-- <hr> -->

                    </div>
                    <div style="clear: both;"></div>

                    <hr>

                    <!--<span class="row">-->

                        <label>
                            <input type="checkbox" name="regulamin" <?php

                            if(isset($_SESSION['fr_regulamin']))
                            {
                                echo "checked";
                                unset($_SESSION['fr_regulamin']);
                            }
                            else
                            {
                                echo "checked";
                            }

                            ?>> Akceptuję regulamin
                        </label>

                        <?php
                        if(isset($_SESSION['e_regulamin'])) // błąd z akceptacją regulaminu (checkbox) ...
                        {
                            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                            unset($_SESSION['e_regulamin']);
                        }
                        ?>

                    <!--</span>-->

                    <br><br>

                    <div class="g-recaptcha" data-sitekey="6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1"></div>

                    <?php
                    if(isset($_SESSION['e_bot'])) // błąd z re'captcha
                    {
                        echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                        unset($_SESSION['e_bot']);
                    }
                    ?>

                    <br>
                    <input type="submit" value="Zarejestruj się" >

                    <?php
                    if(isset($_SESSION['e_fields'])) // nie wypełniono wszystkich pol
                    {
                        echo '<div class="error">'.$_SESSION['e_fields'].'</div>';
                        unset($_SESSION['e_fields']);
                    }
                    ?>

                    <!-- reCAPTCHA (v2 !!!)

                        klucze reCAPTCHA (v2 !!!) :
                            Site key = klucz jawny (HTML)
                            Secret key = klucz tajny (PHP)

                        Tworzenie reCaptcha:

                            google.com/recaptcha

                            -> v3 Admin Console
                            -> Utwórz + (google.com/recaptcha/admin/create)

                        etykieta: "XAMPP"
                        nazwa domeny : "localhost"

                        Site Key   :    	(html)
                        Secret Key : 		(PHP)

                        Umieszceznie reCAPTCHA w html :
                        -> v3 Documentation
                    -->

                    <!-- reCAPTCHA (v2) - konto jan.nowak.6820@gmail.com

                        klucze reCAPTCHA (v2) :
                            Site key = klucz jawny (HTML)
                            Secret key = klucz tajny (PHP)

                        Tworzenie reCaptcha:

                            google.com/recaptcha

                            -> v3 Admin Console
                            -> Utwórz + (google.com/recaptcha/admin/create)

                        etykieta: "XAMPP"
                        nazwa domeny : "localhost"

                        Site Key   : 6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1   	(html)
                        Secret Key : 6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG		(PHP)

                        Umieszceznie reCAPTCHA w html :
                        -> v3 Documentation
                    -->

                </form>

            </div>

        </main>

        <script>

            // validate password length (JS) -->

            function checkUsername(e, minLength) {
                let elMsg = document.getElementById("feedback");
                let elUsernmae = document.getElementById("haslo1"); // nazwa użytkownika

                let eventElement = e.target;
                console.log("eventElement = ", eventElement);
                let elementParent = eventElement.parentElement; // (!)      rodzic elementu -> <p>
                //                  eventElement.parentNode;    // ✓
                console.log("elementParent = ", elementParent);
                let elementGrandParent = eventElement.parentNode.parentNode; // (!) dziadek -> <div>
                console.log("elementGrandParent = ", elementGrandParent);
                // elementGrandParent.removeChild(elementParent); // usunięcie <p> // ✓

                if(elUsernmae.value.length < minLength) {
                    elMsg.textContent = "Hasło musi mieć conajmniej " + minLength + " znaków ";

                } else {
                    elMsg.textContent = ""; // usunięcie komunikatu
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

            var el = document.getElementById("haslo1");



            el.addEventListener("blur", function(e) {
                checkUsername(e, 10);
            }, false);

            el.addEventListener("focus", function(e) {
                removeMsg(e);
            }, false);

        </script>

	</div>

</div>

    <?php require "../view/footer.php"; ?>

    <script>
        content = document.getElementById("content"); // ustawienie wid div#content na 100%
        // console.log("content -> ", content);
        content.style.width = "100%";
    </script>


    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>