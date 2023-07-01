<?php

	session_start();
	include_once "../functions.php";

    if( ! isset($_SESSION['zalogowany']) ) {

        $_SESSION["login-error"] = true;
        header("Location: ___zaloguj.php");
        exit();
    }

    if( isset($_SESSION["password_confirmed"]) && $_SESSION["password_confirmed"] ) { // podano poprawne hasło;

        query("DELETE FROM klienci WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie konta klienta (+ ✓ jego zamówień, ✓ szczegółów zamówień, ✓płatności, ✓ koszyka) - Dzięki zastosowaniu relacji i ograniczeń kluczy obcych w tych tabelach (ON DELETE CASCADE, ON UPDATE CASCADE);

            // ✓ Usunięcie klienta usuwa również jego ZAMÓWIENIA ->
                // "Zamówienia" -> Ograniczenia klucza obcego -> id_klienta ON DELETE CASCADE ;

        query("DELETE FROM adres WHERE adres_id='%s'", "", $_SESSION["adres_id"]);
            // usunięcie danych adresowych klienta (należy użyć osobnego zapytania ponieważ ON DELETE CASCADE usuwa klienta podczas usunięcia adresu (wiersza z adresem), a nie odwrotnie (wiersz z adresem pozostaje, jeśli usunięmy klienta) ; (✓✓✓ a wynika to z tego, że to w tabeli klientów jest klucz obcy "adres", a nie w tabeli adres KO "id_klienta") - ✓✓✓ a jest tak, ponieważ nie chciałem aby tabela "adres" przechowywała "id_klienta" oraz "id_pracownika"

        //query("DELETE FROM komentarze WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie komentarzy dodaych prze usera;
            //query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["id"]);
                // usunięcie tokenów do resetowania hasła, jeśli istniały jakies przypisane do tego usera;
            // ✓✓✓ NIE TRZEBA USUWAĆ WIERSZY Z TABELI TOKENÓW PONIEWAŻ JEST NAŁOŻENIE OGRANICZENIE klucza obcego (klienci) - email -> prt (email) - ON DELETE CASCADE
        //query("DELETE FROM ratings WHERE id_klienta='%s'", "", $_SESSION["id"]);
            // usunięcie komentarzy/opinii dodanych przez usera

        // Nie ma potrzeby usuwać "komentarze" i "oceny" (ratings) - ponieważ przy usunięciu klienta, zostają one usunięte;   komentarze, oceny -> ON DELETE CASCADE

        // ✓✓✓ Podsumowując, usuwając tabelę klienci - Usuwamy również (odpowiednie wiersze w innych tabelach) jego tokeny resetowania hasła (jeśli istniały), zawartość koszyka (wiersze z tabeli koszyk), zamówienia, płatności, szczegóły zamówienia, (✓ kaskada idzie po usunięciu zamówienia na płatności i szczegóły zamówienia)
        // komentarze oraz oceny ;

        header('location: logout.php');
        exit();
    }

    // Post-Redirect-Get (PRG) --> ;

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {

        if ( isset($_POST["confirm-delete"]) && ! empty($_POST["confirm-delete"]) && $_POST["confirm-delete"] === "on" ) {

            // wysłano formularz, ✓ checkbox został zaznaczony przed wysłaniem formularza ;

            $_SESSION["deletion-confirmed"] = true;

        } else { // ✖ nie zaznaczono checkbox'a o potwierdzeniu usunięcia konta ;

            $_SESSION["confirm-error"] = true;

            // handle error; ✓ or do nothing ?
        }

        unset($_POST);
            header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // redirect to prevent form resubmission
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
                    <?php print_r($_SESSION); ?>

                    <h3 class="account-header">Usuń konto</h3>

                    <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && ! isset($_SESSION["deletion-confirmed"]) ) : ?>

                        <div class="dane_konta dane-konta-form">
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
                                    <?php
                                        if ( isset($_SESSION["password_confirmed"]) && ! $_SESSION["password_confirmed"] ) {
                                                // confirm_password.php -> $_SESSION["password_confirmed"] == false ;
                                            echo '<span class="remove-account-password-error">Nieprawidłowe hasło</span>';
                                                unset($_SESSION["password_confirmed"]);
                                        }
                                        elseif ( isset($_SESSION["confirm-error"]) && $_SESSION["confirm-error"] ) {
                                                // checkbox was not checked ;
                                            echo '<span class="remove-account-confirm-error">Zaznacz checkbox potwierdzający usunięcie konta</span>';
                                                unset($_SESSION["confirm-error"]);
                                        }
                                    ?>
                                </form>

                            </div> <!-- #edit_data_container -->
                        </div> <!-- .dane_konta -->

                    <?php elseif ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["deletion-confirmed"]) && $_SESSION["deletion-confirmed"] ) : ?>

                        <?php unset($_SESSION["deletion-confirmed"]); ?>

                    <div class="dane_konta  insert-password"> <!-- Hasło --> <!-- content-invisible -->
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

                    <?php endif; ?>

                        <!-- <div style="clear: both;"></div> -->
                    <script> displayNav(); </script>
                </div> <!-- #content -->
            </main>

            <?php
                if( isset($_POST["confirm-delete"]) && ! empty($_POST["confirm-delete"]) ) { // $_POST["confirm-delete"] - checkbox "Czy chcesz usunąć swoje konto ... " ;
                        // ukrycie informacji o koncie i wyświetlenie formularza do podania hasła ;
                   /* echo '<script>
                        const el = document.querySelectorAll(".dane_konta");                                             
                        for (let i = 0; i < el.length; i++) {
                            el[i].classList.toggle("content-invisible");
                        }
                    </script>';*/
                }
            ?>
        </div> <!-- #container -->

    <?php require "../view/footer.php"; ?>

</div> <!-- #main-container -->

</body>
</html>