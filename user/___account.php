<?php
    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <aside class="account-data">
                <div id="nav">
                    <!-- <a href="___my_orders.php">[ Zamówienia ]</a><br><br>
                    <a href="edit_data.php">[ Edytuj dane użytkownika ]</a><br><br>
                    <a href="___remove_account.php">[ Usuń konto ]</a><br><br>
                    <a href="logout.php"> [ Wyloguj ]</a> -->
                    <a href="___my_orders.php"><h3>Zamówienia</h3><hr></a>
                        <a href="___account.php"><h3>Edytuj dane użytkownika</h3><hr></a>
                    <a href="___remove_account.php"><h3>Usuń konto</h3><hr></a>
                    <a href="logout.php"><h3>Wyloguj</h3><hr></a>

                </div> <!-- #nav -->
            </aside> <!-- .account-data (lewy nav-bar) -->

            <div id="content">
                <h3 class="account-header">Moje konto</h3>
                <div class="dane_konta">
                    <h3 class="account-header">Dane konta</h3>
                    <div class="edit_data_container">
                        <div class="edit_data_left-container">
                            <div class="edit_data_left">Imię</div>
                            <div class="edit_data_left">Nazwisko</div>
                            <div class="edit_data_left">E-mail</div>
                            <div class="edit_data_left">Telefon</div>
                        </div>
                        <div class="edit_data_right-container">
                            <form id="edit_data_form" action="validate_user_data.php" method="post">
                                <div class="edit_data_right"><input type="text" id="imie_edit" name="imie_edit" value="<?=$_SESSION['imie']?>"></div>
                                <div class="edit_data_right"><input type="text" id="nazwisko_edit" name="nazwisko_edit" value="<?=$_SESSION['nazwisko']?>"></div>
                                <div class="edit_data_right"><input type="text" id="email_edit" name="email_edit" value="<?=$_SESSION['email']?>"></div>
                                <div class="edit_data_right"><input type="text" id="telefon_edit" name="telefon_edit" value="<?=$_SESSION['telefon']?>"></div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_data_form">Edytuj dane</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="clear: both;"></div>
                            <!--<div class="edit-data-button-left"></div>-->
                    </div> <!-- .edit_data_container -->
                </div> <!-- .dane_konta -->

                <?php
                    if( isset($_SESSION['error_form']) ) { // jeśli dane nie przeszły walidacji w "validate_user_data.php";

                        echo "<h3 class='data-changed'>" . $_SESSION['error_form'] . "</h3>"; // validate_user_data.php -> "Podaj poprawne dane", "...", - komunikat z błędem;
                        unset($_SESSION['error_form']); // usunięcie komunikatu z błędem (aby nie wyświetlał się ponownie po odświeżeniu strony);
                    } else { // dane przeszły walidację;

                        if( isset($_SESSION['validation_passed']) && $_SESSION['validation_passed']) {

                            // validate_user_data.php -> $_SESSION['validation_passed'] = true; // dane PRZESZŁY walidację;
                            echo "<h3 class='data-changed'>Dane zostały zmienione</h3>";
                            unset($_SESSION['validation_passed']); // usunięcie komunikatu z błędem (aby nie wyświetlał się ponownie po odświeżeniu strony);
                        }
                    }
                ?>

                <div style="clear: both;"></div>

                <div class="dane_konta"> <!-- dane adresowe -->
                    <h3 class="account-header">Dane adresowe</h3>
                    <div class="edit_data_container">
                        <div class="edit_data_left-container">
                            <div class="edit_data_left">Miejscowość</div>
                            <div class="edit_data_left">Ulica</div>
                            <div class="edit_data_left">Numer domu</div><hr>
                            <div class="edit_data_left">Kod pocztowy</div>
                            <div class="edit_data_left">Miasto</div>
                        </div>
                        <div class="edit_data_right-container">
                            <form id="edit_address_form" action="validate_address_data.php" method="post">
                                <div class="edit_data_right"><input type="text" id="miejscowosc_edit" name="miejscowosc_edit" value="<?=$_SESSION['miejscowosc']?>"></div>
                                <div class="edit_data_right"><input type="text" id="ulica_edit" name="ulica_edit" value="<?=$_SESSION['ulica']?>"></div>
                                <div class="edit_data_right"><input type="text" id="numer_domu_edit" name="numer_domu_edit" value="<?=$_SESSION['numer_domu']?>"></div><hr>
                                <div class="edit_data_right"><input type="text" id="kod_poczt_edit" name="kod_poczt_edit" value="<?=$_SESSION['kod_pocztowy']?>"></div>
                                <div class="edit_data_right"><input type="text" id="miasto_edit" name="miasto_edit" value="<?=$_SESSION['kod_miejscowosc']?>"></div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_address_form">Potwierdź adres</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                         <div style="clear: both;"></div>

                        <!--<div class="edit-data-button-left"></div>-->
                        <!--<div class="edit_data_button">
                            <button type="submit" form="edit_address_form">Edytuj dane</button>
                        </div>-->
                    </div>
                </div>

                <?php
                    if( isset($_SESSION['a_error']) ) { // dane nie przeszły walidacji; 'a_error' = "Podaj poprawną ...";

                            // echo $_SESSION['a_error'];
                        echo "<h3 class='data-changed'>" . $_SESSION['a_error'] . "</h3>";
                            unset($_SESSION['a_error']);
                    } else {

                        if( isset($_SESSION['validation_passed_a']) && $_SESSION['validation_passed_a'] ) {

                            // ✓ jeśli udało się zmienić dane adresowe; // ✓ jeśli dane przeszły walidację;
                            echo "<h3 class='data-changed'>Dane zostały zmienione</h3>";
                                unset($_SESSION['validation_passed_a']);
                        }
                    }
                ?>

                <div class="dane_konta">
                    <h3 class="account-header">Hasło</h3>
                    <div class="edit_data_container">
                        <div class="edit_data_left-container">
                                <div class="edit_data_left"> Stare hasło </div>
                                <div class="edit_data_left"> Nowe hasło </div>
                                <div class="edit_data_left"> Powtorz hasło </div>
                        </div>
                        <div class="edit_data_right-container">
                                <form id="edit_password_form" action="validate_password.php" method="post">
                                    <div class="edit_data_right"><input type="password" id="stare_haslo_edit" name="stare_haslo_edit"></div>
                                    <div class="edit_data_right"><input type="password" id="nowe_haslo_edit" name="nowe_haslo_edit"></div>
                                    <div class="edit_data_right"><input type="password" id="powtorz_haslo_edit" name="powtorz_haslo_edit"></div>

                                    <div class="edit_data_right">
                                        <div class="edit_data_button">
                                            <button type="submit" form="edit_password_form">Zmień hasło</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                         <div style="clear: both;"></div>

                        <!--<div class="edit-data-button-left"></div>-->
                        <!--<div class="edit_data_button">
                            <button type="submit" form="edit_password_form">Edytuj dane</button>
                        </div>-->
                    </div> <!-- .edit_data_container -->

                </div>
                    <?php
                        if( isset($_SESSION['validation_password']) && ! $_SESSION['validation_password'] && isset($_SESSION['error_form_password']) ) {

                            // $_SESSION['validation_password'] == "false" - jeśli nie udało się zmienić hasła, nie przeszło walidacji, hasło było takie samo co już istniejące, ... ogólnie "wystąpił błąd" - przy próbie zmiany hasła;

                            // $_SESSION['error_form_password'] - przechowuje komunikat informujący dokładnie jaki wystąpił błąd;

                                // echo $_SESSION['error_form_password'];
                                echo "<h3 class='data-changed'>" . $_SESSION['error_form_password'] . "</h3>"; // komunikat z błędem;
                            unset($_SESSION['stare_haslo']);
                            unset($_SESSION['validation_password']);
                            unset($_SESSION['error_form_password']);
                            unset($_SESSION['validation_passed_p']);
                        } else {
                            if( isset($_SESSION['validation_passed_p']) && $_SESSION['validation_passed_p'] ) {

                                // $_SESSION['validation_passed_p'] == true - jeśli udało się zmienić hasło;

                                    // echo "Hasło zostało zmienione";

                                    echo "<h3 class='data-changed'>Hasło zostało zmienione</h3>";
                                unset($_SESSION['stare_haslo']);
                                unset($_SESSION['validation_password']);
                                unset($_SESSION['error_form_password']);
                                unset($_SESSION['validation_passed_p']);
                            }
                        }
                    ?>

                <script> displayNav(); </script> <!-- ustawia szerokość lewego nava na 25% oraz odpowiednią szerokość dla diva "content" -->

		    </div> <!-- #content -->

        </main>
	</div> <!-- #container -->

    <?php require "../view/footer.php"; ?>

</div> <!-- #main-container -->

</body>
</html>