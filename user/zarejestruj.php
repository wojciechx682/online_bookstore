<?php
	session_start();
	include_once "../functions.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <!--<div id="nav"></div>-->

            <div id="content">

                <!-- Formularz rejestracji -->

                <form method="post" action="rejestracja.php">  <!-- brak atrybutu action - ten sam plik rejestracja.php przetwarza formularz
                                                                bez atrybutu action, domyślnie - ten sam plik otrzyma post'em przesłane dane
                                                                                WALIZACJA DANYCH W W TYM SAMYM PLIKU ! (rejestracja.php) -->
                    Stwórz nowe konto klienta<br><hr>

                    <div class="form-section">
                        Imię: <br> <input type="text" name="imie" value="<?php
                        if(isset($_SESSION['fr_imie']))
                        {
                            echo $_SESSION['fr_imie'];
                            unset($_SESSION['fr_imie']);
                        }
                        else
                        {
                            echo "Paweł";
                        }
                        ?>"> <br>

                        <?php
                        if(isset($_SESSION['e_imie']))
                        {
                            echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                            unset($_SESSION['e_imie']);
                        }
                        ?>

                        Nazwisko: <br> <input type="text" name="nazwisko" value="<?php
                        if(isset($_SESSION['fr_nazwisko']))
                        {
                            echo $_SESSION['fr_nazwisko'];
                            unset($_SESSION['fr_nazwisko']);
                        }
                        else
                        {
                            echo "Michalczyk";
                        }
                        ?>"> <br>

                        <?php
                        if(isset($_SESSION['e_nazwisko'])) // błąd z naziwskiem użytkownika
                        {
                            echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                            unset($_SESSION['e_nazwisko']);
                        }
                        ?>

                        <!-- type="email" -->
                        E-mail: <br> <input type="email" name="email" value="<?php
                        if(isset($_SESSION['fr_email']))
                        {
                            echo $_SESSION['fr_email'];
                            unset($_SESSION['fr_email']);
                        }
                        else
                        {
                            echo "pawel12@wp.pl";
                        }
                        ?>"> <br>
                        <?php
                        if(isset($_SESSION['e_email']))
                        {
                            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                        ?>

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


                        Hasło: <br> <input type="password" name="haslo1"

                                           value="PassJacob33#" ><br>

                        <?php
                        if(isset($_SESSION['e_haslo']))
                        {
                            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                            unset($_SESSION['e_haslo']);
                        }
                        ?>
                        Powtórz hasło: <br> <input type="password" name="haslo2"

                                                   value="PassJacob33#" ><br>

                        <!-- <br> <hr> -->
                    </div>


                    <div class="form-section">
                        <!--Dane adresowe <br><br>-->

                        Miejscowość: <br> <input type="text" name="miejscowosc" value="<?php
                            if(isset($_SESSION['fr_miejscowosc']))
                            {
                                echo $_SESSION['fr_miejscowosc'];
                                unset($_SESSION['fr_miejscowosc']);
                            }
                            else
                            {
                                echo "Dolna odra";
                            }
                        ?>"> <br>

                        <?php
                            if(isset($_SESSION['e_miejscowosc']))
                            {
                                echo '<div class="error">'.$_SESSION['e_miejscowosc'].'</div>';
                                unset($_SESSION['e_miejscowosc']);
                            }
                        ?>

                        Ulica: <br> <input type="text" name="ulica" value="<?php
                            if(isset($_SESSION['fr_ulica']))
                            {
                                echo $_SESSION['fr_ulica'];
                                unset($_SESSION['fr_ulica']);
                            }
                            else
                            {
                                echo "Słoneczna";
                            }
                        ?>"> <br>

                        <?php
                            if(isset($_SESSION['e_ulica']))
                            {
                                echo '<div class="error">'.$_SESSION['e_ulica'].'</div>';
                                unset($_SESSION['e_ulica']);
                            }
                        ?>


                        Numer domu: <br> <input type="text" name="numer_domu" value="<?php
                            if(isset($_SESSION['fr_numer_domu']))
                            {
                                echo $_SESSION['fr_numer_domu'];
                                unset($_SESSION['fr_numer_domu']);
                            }
                            else
                            {
                                echo "61";
                            }
                        ?>"> <br>

                        <?php
                            if(isset($_SESSION['e_numer_domu']))
                            {
                                echo '<div class="error">'.$_SESSION['e_numer_domu'].'</div>';
                                unset($_SESSION['e_numer_domu']);
                            }
                        ?>

                        <br> <!-- <hr> --><br>

                    </div>

                    <div class="form-section">

                        Kod pocztowy: <br> <input type="text" name="kod_pocztowy" value="<?php
                            if(isset($_SESSION['fr_kod_pocztowy']))
                            {
                                echo $_SESSION['fr_kod_pocztowy'];
                                unset($_SESSION['fr_kod_pocztowy']);
                            }
                            else
                            {
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

                        Miejscowość: <br> <input type="text" name="kod_miejscowosc" value="<?php
                            if(isset($_SESSION['fr_kod_miejscowosc']))
                            {
                                echo $_SESSION['fr_kod_miejscowosc'];
                                unset($_SESSION['fr_kod_miejscowosc']);
                            }
                            else
                            {
                                echo "Dębno";
                            }
                        ?>"> <br>

                        <?php
                            if(isset($_SESSION['e_kod_miejscowosc']))
                            {
                                echo '<div class="error">'.$_SESSION['e_kod_miejscowosc'].'</div>';
                                unset($_SESSION['e_kod_miejscowosc']);
                            }
                        ?>

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

                        Telefon (PL +48): <br> <input type="text" name="telefon" value="<?php
                            if(isset($_SESSION['fr_telefon']))
                            {
                                echo $_SESSION['fr_telefon'];
                                unset($_SESSION['fr_telefon']);
                            }
                            else
                            {
                                echo "505101303";
                            }
                        ?>"> <br>

                        <?php
                            if(isset($_SESSION['e_telefon']))
                            {
                                echo '<div class="error">'.$_SESSION['e_telefon'].'</div>';
                                unset($_SESSION['e_telefon']);
                            }
                        ?>

                        <br>    <!-- <hr> -->

                    </div>
                    <div style="clear: both;"></div>

                    <hr>

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

	</div>

    <?php require "../view/footer.php"; ?>

    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>