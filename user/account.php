<?php
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <?php require "../view/account-nav.php"; ?>

            <div id="content">

                <h3 class="account-header">Moje konto</h3>

                <div class="dane_konta">

                    <h3 class="account-header">Dane konta</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">

                            <label for="name"><div class="edit_data_left">Imię</div></label>
                            <label for="surname"><div class="edit_data_left">Nazwisko</div></label>
                            <label for="email"><div class="edit_data_left">E-mail</div></label>
                            <label for="phone"><div class="edit_data_left">Telefon</div></label>

                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_data_form" action="change_user_data.php" method="post">

                                <div class="edit_data_right">
                                    <input type="text" id="name" name="name" value="<?=$_SESSION["imie"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="text" id="surname" name="surname" value="<?=$_SESSION["nazwisko"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="email" id="email" name="email" value="<?=$_SESSION["email"]?>" maxlength="255" required>
                                </div>

                                <div class="edit_data_right">
                                    <input type="tel" id="phone" name="phone" value="<?=$_SESSION["telefon"]?>" maxlength="15" required>
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

                <h3 class="data-changed">

                    <?php
                        if (isset($_SESSION["user_data_error_message"])) {

                            echo $_SESSION["user_data_error_message"];
                                unset($_SESSION["user_data_error_message"]);

                        } else {
                            if (isset($_SESSION["is_user_data_changed"]) && $_SESSION["is_user_data_changed"]) {

                                echo "Dane zostały zmienione";
                                    unset($_SESSION["is_user_data_changed"]);
                            }
                        }
                    ?>

                </h3>

                <div class="dane_konta">

                    <h3 class="account-header">Dane adresowe</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">

                            <label for="city"><div class="edit_data_left">Miejscowość</div></label>
                            <label for="street"><div class="edit_data_left">Ulica</div></label>
                            <label for="houseNo"><div class="edit_data_left">Numer domu</div><hr></label>
                            <label for="postCode"> <div class="edit_data_left">Kod pocztowy</div></label>
                            <label for="cityCode"><div class="edit_data_left">Miasto</div></label>

                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_address_form" action="change_address_data.php" method="post">

                                <div class="edit_data_right">
                                    <input type="text" id="city" name="city" value="<?=$_SESSION["miejscowosc"]?>" maxlength="255" required>
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="street" name="street" value="<?=$_SESSION["ulica"]?>" maxlength="255">
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="houseNo" name="houseNo" value="<?=$_SESSION["numer_domu"]?>" maxlength="25" required>
                                </div><hr>
                                <div class="edit_data_right">
                                    <input type="text" id="postCode" name="postCode" value="<?=$_SESSION["kod_pocztowy"]?>" maxlength="25" required>
                                </div>
                                <div class="edit_data_right">
                                    <input type="text" id="cityCode" name="cityCode" value="<?=$_SESSION["kod_miejscowosc"]?>" maxlength="255" required>
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

                <h3 class="data-changed">

                    <?php
                        if( isset($_SESSION["address_data_error_message"]) ) {

                            echo $_SESSION["address_data_error_message"];
                                unset($_SESSION["address_data_error_message"]);

                        } else {

                            if( isset($_SESSION["is_address_data_changed"]) && $_SESSION["is_address_data_changed"] ) {

                                echo "Dane zostały zmienione";
                                    unset($_SESSION["is_address_data_changed"]);
                            }
                        }
                    ?>

                </h3>

                <div class="dane_konta">

                    <h3 class="account-header">Hasło</h3>

                    <div class="edit_data_container">

                        <div class="edit_data_left-container">
                                <label for="oldPassword"><div class="edit_data_left">Aktualne hasło</div></label>
                                <label for="newPassword"><div class="edit_data_left">Nowe hasło</div></label>
                                <label for="confirmPassword"><div class="edit_data_left">Powtorz hasło</div></label>
                        </div>

                        <div class="edit_data_right-container">

                            <form id="edit_password_form" action="change_password.php" method="post">

                                <div class="edit_data_right"><input required type="password" id="oldPassword" name="oldPassword" maxlength="255" autocomplete="off"></div>
                                <div class="edit_data_right"><input required type="password" id="newPassword" name="newPassword" maxlength="255" autocomplete="off"></div>
                                <div class="edit_data_right"><input required type="password" id="confirmPassword" name="confirmPassword" maxlength="255" autocomplete="off"></div>

                                <div class="edit_data_right">
                                    <div class="edit_data_button">
                                        <button type="submit" form="edit_password_form">Zmień hasło</button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <h3 class="data-changed data-changed-password">

                    <?php
                        if (isset($_SESSION["change_password_error_message"])) {

                            echo $_SESSION["change_password_error_message"];
                                unset($_SESSION["change_password_error_message"]);

                        } else {

                            if (isset($_SESSION["is_password_changed"]) && $_SESSION["is_password_changed"]) {

                                echo "Hasło zostało zmienione";
                                    unset($_SESSION["is_password_changed"]);
                            }
                        }
                    ?>

                </h3>

                <script> displayNav(); </script>

		    </div>

        </main>

	</div>

    <?php require "../view/___footer.php"; ?>

</div>

</body>
</html>

