<?php
	/*session_start();
	include_once "../functions.php";
	if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error");
		exit();
	}*/

    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";


    if(isset($_SESSION["password_confirmed"]) && $_SESSION["password_confirmed"]) {
        // podano poprawne hasło
        query("DELETE FROM klienci WHERE id_klienta='%s'", "", $_SESSION["id"]); // usunięcie konta klienta (+ jego zamówień, szczegółów zamówień, płatności, + koszyka)
        query("DELETE FROM komentarze WHERE id_klienta='%s'", "", $_SESSION["id"]); // usunięcie komentarzy dodaych prze usera
        query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["id"]); // usunięcie tokenów do resetowania hasłą, jeśli istniały jakies przypisane do tego usera;
        query("DELETE FROM ratings WHERE id_klienta='%s'", "", $_SESSION["id"]); // usunięcie komentarzy/opinii dodanych przez usera
        header('location: logout.php');
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
                    <a href="my_orders.php">[ Zamówienia ]</a><br><br>
                    <a href="edit_data.php">[ Edytuj dane użytkownika ]</a><br><br>
                    <a href="remove_account.php">[ Usuń konto ]</a><br><br>
                    <a href="logout.php"> [ Wyloguj ]</a>
                </div>
            </aside>
            <div id="content">
                <?php /*print_r($_SESSION); */?>
                <h2>Usuń konto</h2><hr>
                <div class="dane_konta">
                    Dane konta <hr>
                    <div class="edit_data_container">
                        <div class="edit_data_left-container">
                            <div class="edit_data_left">Imię</div>
                            <div class="edit_data_left">Nazwisko</div>
                            <div class="edit_data_left">E-mail</div>
                            <div class="edit_data_left">Telefon</div><hr>
                            <div class="edit_data_left">Adres</div>
                        </div>
                        <div class="edit_data_right-container">
                                <div class="edit_data_right"><?=$_SESSION['imie']?></div>
                                <div class="edit_data_right"><?=$_SESSION['nazwisko']?></div>
                                <div class="edit_data_right"><?=$_SESSION['email']?></div>
                                <div class="edit_data_right"><?=$_SESSION['telefon']?></div><hr>
                                <div class="edit_data_right"><?=$_SESSION['miejscowosc']?></div>
                                <div class="edit_data_right"><?=$_SESSION['ulica'], " ", $_SESSION['numer_domu']?></div>
                                <div class="edit_data_right"><?=$_SESSION['kod_pocztowy'], " ", $_SESSION['kod_miejscowosc']?></div>

                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        <form method="post">
                            <label class="confirm-delete">
                                <input required type="checkbox" name="confirm-delete" class="confirm-delete">Czy na pewno chcesz usunąć swoje konto ?
                            </label>
                                <br>
                            <div class="edit_data_button">
                                <button type="submit">Potwierdź</button>
                            </div>
                            <?php if(isset($_SESSION["password_confirmed"]) && !$_SESSION["password_confirmed"]) {
                                echo "złe hasło";
                                unset($_SESSION["password_confirmed"]); } ?>
                        </form>
                    </div>
                </div>
                <br><hr><br>
                <!-- Hasło -->
                <div class="dane_konta content-invisible" >
                    Hasło <hr>
                    <div class="edit_data_container">
                        <div class="edit_data_left-container">
                            <div class="edit_data_left"> Hasło </div>
                            <div class="edit_data_left"> Powtorz hasło </div>
                        </div>
                        <div class="edit_data_right-container">
                            <form id="confirm_password_form" action="confirm_password.php" method="post">
                                <div class="edit_data_right"><input type="password" id="haslo_confirm" name="haslo_confirm"></div>
                                <div class="edit_data_right"><input type="password" id="powtorz_haslo_confirm" name="powtorz_haslo_confirm"></div>
                            </form>
                        </div>
                        <!-- <div style="clear: both;"></div>-->
                        <div class="edit_data_button">
                            <button type="submit" form="confirm_password_form">Edytuj dane</button>
                        </div>
                    </div>
                </div>

                <br><hr><br>

                <!-- <div style="clear: both;"></div> -->
                <script> displayNav(); </script>
		    </div>

        </main>
        <?php
            if(isset($_POST["confirm-delete"]) && !empty($_POST["confirm-delete"])) {
                // ukrycie informacji o koncie i wyświetlenie formularza do podania hasła
                echo '<script>             
                    const el = document.querySelectorAll(".dane_konta");                                             
                    for (let i = 0; i < el.length; i++) {
                        el[i].classList.toggle("content-invisible");
                    }
                </script>';
            }
        ?>
	</div>
    <?php require "../view/footer.php"; ?>
</body>
</html>