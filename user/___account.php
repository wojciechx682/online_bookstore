<?php
    require_once "../authenticate-user.php";

    // $_SESSION["imie"]
    // $_SESSION["nazwisko"]
    // $_SESSION["email"]
    // $_SESSION["telefon"]
        // $_SESSION["user_data_error_message"]
        // $_SESSION["is_user_data_changed"]

    // $_SESSION["miejscowosc"]
    // $_SESSION["ulica"]
    // $_SESSION["numer_domu"]
    // $_SESSION["kod_pocztowy"]
    // $_SESSION["kod_miejscowosc"]
        // $_SESSION["address-data-error"]
        // $_SESSION["is_address_data_changed"]

    // $_SESSION["error_password_message"]
    // $_SESSION["is_password_changed"]
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <?php require "../view/account-nav.php"; ?>

            <div id="content">

                <h3 class="account-header">Moje konto</h3>

                <?php
                    echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";
                ?>

                <div class="dane_konta">

                    <h3 class="account-header">Dane konta</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">

                            <label for="imie_edit"><div class="edit_data_left">Imię</div></label>
                            <label for="nazwisko_edit"><div class="edit_data_left">Nazwisko</div></label>
                            <label for="email_edit"><div class="edit_data_left">E-mail</div></label>
                            <label for="telefon_edit"><div class="edit_data_left">Telefon</div></label>

                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_data_form" action="change_user_data.php" method="post">

                                <div class="edit_data_right">
                                    <input type="text" id="imie_edit" name="imie_edit" value="<?=$_SESSION["imie"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="text" id="nazwisko_edit" name="nazwisko_edit" value="<?=$_SESSION["nazwisko"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="text" id="email_edit" name="email_edit" value="<?=$_SESSION["email"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="text" id="telefon_edit" name="telefon_edit" value="<?=$_SESSION["telefon"]?>" maxlength="15" required>
                                </div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_data_form">Edytuj dane</button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <?php
                    if (isset($_SESSION["user_data_error_message"])) {

                        echo "<h3 class='data-changed'>" . $_SESSION["user_data_error_message"] . "</h3>";
                        unset($_SESSION["user_data_error_message"]);

                    } else {

                        if (isset($_SESSION["is_user_data_changed"]) && $_SESSION["is_user_data_changed"]) {

                            echo "<h3 class='data-changed'>Dane zostały zmienione</h3>";
                            unset($_SESSION["is_user_data_changed"]);
                        }
                    }
                ?>

                <div class="dane_konta">

                    <h3 class="account-header">Dane adresowe</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">

                            <label for="miejscowosc_edit"><div class="edit_data_left">Miejscowość</div></label>
                            <label for="ulica_edit"><div class="edit_data_left">Ulica</div></label>
                            <label for="numer_domu_edit"><div class="edit_data_left">Numer domu</div><hr></label>
                            <label for="kod_poczt_edit"> <div class="edit_data_left">Kod pocztowy</div></label>
                            <label for="miasto_edit"><div class="edit_data_left">Miasto</div></label>

                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_address_form" action="change_user_address.php" method="post">

                                <div class="edit_data_right">
                                    <input type="text" id="miejscowosc_edit" name="miejscowosc_edit" value="<?=$_SESSION["miejscowosc"]?>" maxlength="255" required>
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="ulica_edit" name="ulica_edit" value="<?=$_SESSION["ulica"]?>" maxlength="255">
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="numer_domu_edit" name="numer_domu_edit" value="<?=$_SESSION["numer_domu"]?>" maxlength="25" required>
                                </div><hr>
                                <div class="edit_data_right">
                                    <input type="text" id="kod_poczt_edit" name="kod_poczt_edit" value="<?=$_SESSION["kod_pocztowy"]?>" maxlength="25" required>
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="miasto_edit" name="miasto_edit" value="<?=$_SESSION["kod_miejscowosc"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_address_form">Potwierdź adres</button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>
                </div>

                <?php
                    if( isset($_SESSION["address-data-error"]) ) {

                        echo "<h3 class='data-changed'>" . $_SESSION["address-data-error"] . "</h3>";
                            unset($_SESSION["address-data-error"]);

                    } else {

                        if( isset($_SESSION["is_address_data_changed"]) && $_SESSION["is_address_data_changed"] ) {

                            echo "<h3 class='data-changed'>Dane zostały zmienione</h3>";
                                unset($_SESSION["is_address_data_changed"]);
                        }
                    }
                ?>

                <div class="dane_konta">

                    <h3 class="account-header">Hasło</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">
                                <label for="stare_haslo_edit"><div class="edit_data_left">Stare hasło</div></label>
                                <label for="nowe_haslo_edit"><div class="edit_data_left">Nowe hasło</div></label>
                                <label for="powtorz_haslo_edit"><div class="edit_data_left">Powtorz hasło</div></label>
                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_password_form" action="change_password.php" method="post">

                                <div class="edit_data_right"><input required type="password" id="stare_haslo_edit" name="stare_haslo_edit"></div>
                                <div class="edit_data_right"><input required type="password" id="nowe_haslo_edit" name="nowe_haslo_edit"></div>
                                <div class="edit_data_right"><input required type="password" id="powtorz_haslo_edit" name="powtorz_haslo_edit"></div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_password_form">Zmień hasło</button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                    <?php
                        if (isset($_SESSION["error_password_message"])) {

                            echo "<h3 class='data-changed data-changed-password'>" . $_SESSION["error_password_message"] . "</h3>";
                            unset($_SESSION["error_password_message"]);

                        } else {

                            if (isset($_SESSION["is_password_changed"]) && $_SESSION["is_password_changed"]) {

                                echo "<h3 class='data-changed'>Hasło zostało zmienione</h3>";
                                unset($_SESSION["is_password_changed"]);
                            }
                        }
                    ?>

                <script> displayNav(); </script>
                <!-- ustawia szerokość lewego nava na 25% oraz odpowiednią szerokość dla diva "content" -->

		    </div>

        </main>

	</div>

    <?php require "../view/footer.php"; ?>

</div>

</body>
</html>