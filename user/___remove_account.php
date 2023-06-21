<?php

	session_start();
	include_once "../functions.php";

	if( ! isset($_SESSION['zalogowany']) ) {
        header("Location: index.php?login-error");
		exit();
	}
    if( isset($_SESSION["password_confirmed"]) && $_SESSION["password_confirmed"] ) { // podano poprawne hasło;

        query("DELETE FROM klienci WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie konta klienta (+ jego zamówień, szczegółów zamówień, płatności, + koszyka);
        query("DELETE FROM komentarze WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie komentarzy dodaych prze usera;
        query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["id"]);
            // usunięcie tokenów do resetowania hasła, jeśli istniały jakies przypisane do tego usera;
        query("DELETE FROM ratings WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie komentarzy/opinii dodanych przez usera

        header('location: logout.php');
        exit();
    }
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
                            <!--<a href="___my_orders.php">[ Zamówienia ]</a><br><br>
                            <a href="edit_data.php">[ Edytuj dane użytkownika ]</a><br><br>
                            <a href="___remove_account.php">[ Usuń konto ]</a><br><br>
                            <a href="logout.php"> [ Wyloguj ]</a>-->
                        <a href="___my_orders.php"><h3>Zamówienia</h3><hr></a>
                        <a href="___account.php"><h3>Edytuj dane użytkownika</h3><hr></a>
                        <a href="___remove_account.php"><h3>Usuń konto</h3><hr></a>
                        <a href="logout.php"><h3>Wyloguj</h3><hr></a>
                    </div>
                </aside>
                <div id="content">
                    <?php /*print_r($_SESSION); */?>
                    <h3 class="account-header">Usuń konto</h3>
                    <div class="dane_konta">
                        <h3 class="account-header">Dane konta</h3>
                        <div class="edit_data_container remove_account">
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
                                    <div class="edit_data_right"><?=$_SESSION['ulica'], ", ", $_SESSION['numer_domu']?></div>
                                    <div class="edit_data_right"><?=$_SESSION['kod_pocztowy'], ", ", $_SESSION['kod_miejscowosc']?></div>

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
                                <?php if( isset($_SESSION["password_confirmed"]) && ! $_SESSION["password_confirmed"] ) { // confirm_password.php -> $_SESSION["password_confirmed"] == false ;
                                    echo '<span class="remove-account-password-error">Nieprawidłowe hasło</span>';
                                    unset($_SESSION["password_confirmed"]); } ?>
                            </form>
                        </div> <!-- #edit_data_container -->
                    </div> <!-- .dane_konta -->


                    <div class="dane_konta content-invisible insert-password"> <!-- Hasło -->
                        <h3 class="account-header">Potwierdź dane</h3>
                        <div class="edit_data_container">
                            <div class="edit_data_left-container">
                                <div class="edit_data_left"> Hasło </div>
                                <div class="edit_data_left"> Powtorz hasło </div>
                            </div>
                            <div class="edit_data_right-container">
                                <form id="confirm_password_form" action="confirm_password.php" method="post">
                                    <div class="edit_data_right"><input type="password" id="haslo_confirm" name="haslo_confirm"></div>
                                    <div class="edit_data_right"><input type="password" id="powtorz_haslo_confirm" name="powtorz_haslo_confirm"></div>

                                    <div class="edit_data_button">
                                        <button type="submit" form="confirm_password_form">Edytuj dane</button>
                                    </div>
                                </form>
                            </div>
                                <!-- <div style="clear: both;"></div>-->
                                <!-- <div class="edit_data_button">
                                    <button type="submit" form="confirm_password_form">Edytuj dane</button>
                                </div> -->
                        </div> <!-- .edit_data_container -->
                    </div> <!-- .dane_konta content-invisible insert-password -->

                        <!-- <div style="clear: both;"></div> -->
                    <script> displayNav(); </script>
                </div> <!-- #content -->
            </main>

            <?php
                if( isset($_POST["confirm-delete"]) && ! empty($_POST["confirm-delete"]) ) { // $_POST["confirm-delete"] - checkbox "Czy chcesz usunąć swoje konto ... " ;
                        // ukrycie informacji o koncie i wyświetlenie formularza do podania hasła ;
                    echo '<script>             
                        const el = document.querySelectorAll(".dane_konta");                                             
                        for (let i = 0; i < el.length; i++) {
                            el[i].classList.toggle("content-invisible");
                        }
                    </script>';
                }
            ?>
        </div> <!-- #container -->

    <?php require "../view/footer.php"; ?>

</div> <!-- #main-container -->

</body>
</html>