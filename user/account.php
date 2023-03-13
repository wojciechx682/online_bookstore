<?php
	session_start();
	include_once "../functions.php";
	if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error");
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<?php require "../view/head.php"; ?>
<body>
<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <aside class="account-data">
                <div id="nav">
                    <a href="edit_data.php">[ Edytuj dane użytkownika ]</a><br><br>
                    <a href="my_orders.php">[ Zamówienia ]</a><br><br>
                    <a href="logout.php"> [ Wyloguj ]</a>
                </div>
            </aside>

            <div id="content">
                <h2>Moje konto</h2><hr>
                <div class="dane_konta">
                    Dane konta <hr>
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
                            </form>
                        </div>
                        <!-- <div style="clear: both;"></div> -->
                        <div class="edit_data_button">
                            <button type="submit" form="edit_data_form">Edytuj dane</button>
                        </div>

                        <?php
                            if((isset($_SESSION['error_form']))) {
                                echo $_SESSION['error_form'];
                                unset($_SESSION['error_form']);
                            } else {
                                if((isset($_SESSION['validation_passed'])) && ($_SESSION['validation_passed'] == true))	{
                                    echo "Dane zostały zmienione";
                                    unset($_SESSION['validation_passed']);
                                }
                            }
                        ?>
                    </div>
                </div>

                <!-- <div style="clear: both;"></div> -->

                <div class="dane_konta">
                    Hasło <hr>
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
                                </form>
                        </div>
                        <!-- <div style="clear: both;"></div>-->
                        <div class="edit_data_button">
                            <button type="submit" form="edit_password_form">Edytuj dane</button>
                        </div>


                    </div>

                </div>
                    <?php
                        if((isset($_SESSION['validation_password'])) && ($_SESSION['validation_password'] == false) && (isset($_SESSION['error_form_password']))) {
                            echo $_SESSION['error_form_password'];
                            unset($_SESSION['stare_haslo']);
                            unset($_SESSION['validation_password']);
                            unset($_SESSION['error_form_password']);
                            unset($_SESSION['validation_passed_p']);
                        } else {
                            if((isset($_SESSION['validation_passed_p'])) && ($_SESSION['validation_passed_p'] == true)) {
                                echo "Hasło zostało zmienione";
                                unset($_SESSION['stare_haslo']);
                                unset($_SESSION['validation_password']);
                                unset($_SESSION['error_form_password']);
                                unset($_SESSION['validation_passed_p']);
                            }
                        }
                    ?>
                <script> displayNav(); </script>
		    </div>

        </main>

	</div>

    <?php require "../view/footer.php"; ?>

</body>
</html>