<?php

// podział kodu ma moduły / funkcje;    generowanie tokenu,     wysyłanie maila;

session_start();

include_once "../functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["email"]) && !empty($_POST["email"])) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    // return false if email failed validation

    if ($email === false) 	{
        // ensures that the email input is sanitized and valid
        // to avoid any potential XSS attacks and other vulnerabilities.
        $_SESSION['e_reset'] = "Podaj poprawny adres e-mail";
    }
    else {

        // sprawdzenie czy taki user (email) istnieje już w bazie, jeśli tak, to można zresetowac dla niego hasło

        query("SELECT id_klienta, imie FROM customers WHERE email='%s'", "check_email", $email);
        // ustawi zmienną       $_SESSION['email_exists'] -> na "true", jeśli jest taki user (email) - (jeśli zwrócono rekordy z BD - result);
        //                      $_SESSION["imie"];

        if(isset($_SESSION['email_exists']) && $_SESSION["email_exists"]) {

            // istnieje taki klient (email), można zresetować mu hasło ->

            $token = bin2hex(random_bytes(32));

            // Hash user token using sha256 algorithm
            $token_hashed = hash("sha256", $token);

            $datetime = new DateTimeImmutable();
            $exp_time = $datetime->add(new DateInterval('PT15M'))->format('Y-m-d H:i:s');
            $data = [$token_hashed, $email, $exp_time];

            query("INSERT INTO password_reset_tokens (token_id, token, email, exp_time) VALUES (NULL, '%s', '%s', '%s')", "", $data);
            // wstawienie wpisu do tabeli z tokenami (token + emaiL);

            // jeśli nie wyjebało błędu przy INSERCIE, to jedziemy dalej -->
            // wyślij do klienta email z tokenem ->
            //
            try {

                $mail = new PHPMailer(); // create a new PHPMailer instance

                $mail->isSMTP();
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // aby widzieć komunikaty przebiegu wysyłania wiadomośći

                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;

                $mail->Username = 'jakub.wojciechowski.683@gmail.com'; // adres nadawcy; podaj swój login gmail
                $mail->Password = 'ubkdmiyqcquifysy'; // podaj swoje hasło do aplikacji

                $mail->CharSet = 'UTF-8';  // konfiguracja wiadomości
                $mail->setFrom('app.bookstore@gmail.com', 'Księgarnia internetowa - Przypomnij hasło'); // nazwa odbiorcy (name)
                $mail->addAddress($email); // email ODBIORCY
                //$mail->addReplyTo('biuro@domena.pl', 'Biuro');

                $mail->isHTML(true);
                $mail->Subject = 'Księgarnia internetowa - Przypomnij hasło';

                $user = $_SESSION["imie"];

                $mail->Body = '
                        <html>
                            <head>
                                <title>Przypomnij hasło</title>
                            </head>
                            <body>
                                <p>Witaj '.$user.', </p>                            
                                <p>Poprosiłeś o zresetowanie hasła do swojego konta w księgarni. Aby zresetować hasło, wprowadź poniższy token na <strong><i>stronie resetowania</i></strong> hasła w aplikacji</p>                               
                                <strong><i>'.$token.'</i></strong>                                
                                <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                                <p>Powyższy token będzie aktywny tylko przez 15 minut</p>
                                <br>
                                <p>© 2023 Online Bookstore. All rights reserved.</p>
                            </body>                  
                        </html>
                    ';

                //$mail->addAttachment('img/html-ebook.jpg'); // załącznik
                //
                if($mail->send()) {
                    $_SESSION["email-sent"] = true;  // email wysłany pomyślnie
                } else {
                    $_SESSION["email-sent"] = false; // email niewysłany
                }

            } catch(Exception $e) {
                //echo "Błąd wysyłania maila: {$mail->ErrorInfo}";
                $_SESSION["sent-error"] = "Błąd wysyłania maila: {$mail->ErrorInfo}";
                unset($_SESSION["email-sent"]);
            }
            //exit();
            //unset($_SESSION['email_exists']);
            //exit();
        } else {
            $_SESSION["email-not-exists"] = true;
        }
        //exit();
    }
}
//    elseif ( isset($_SESSION["email_exists"]) &&   // jeśli udało się wysłać maila do klienta, i klient przesłał token który otrzymał na maila
//            $_SESSION["email_exists"] &&
//            isset($_SESSION["email-sent"]) &&
//            $_SESSION["email-sent"] &&
//            isset($_POST["token"]) &&
//            !empty($_POST["token"])
//    ) {
//
//        //echo '<script>hideField();</script>';
//
//        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING); // sanityzacja danych wejściowych (tokenu);
//
//        if($token === false || $token === null) {
//
//            // $token nie przeszedł walidacji/sanityzacji ...
//
//        } else {
//
//            // musimy pobrać maila na podstawie tokenu ✓
//
//            //exit();
//
//            query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s'", "verify_token", $token); // $_SESSION["token verified"] --> true jeśli podany token jest poprawny, $_SESSION["token verified"] = email_klienta_zgodny_z_tokenem
//
//            print_r($_SESSION);
//            // Array ( [email_exists] => 1 [email-sent] => 1 [token_verified] => 1 [email] => jakub.wojciechowski.682@gmail.com [exp_time] => 2023-03-11 19:12:17 )
//            //exit();
//
//            $exp_time = $_SESSION["exp_time"]; // data wygaśnięcia tokenu;
//
//            $datetime = new DateTimeImmutable();
//            $cur_date = $datetime->format('Y-m-d H:i:s'); // aktualna data
//
//            // Compare the two datetime values
//            if ($cur_date < $exp_time) {
//                // The expiration time has passed
//                echo 'Token is still valid';
//
//                // token nadal aktualny ...
//
//                // echo '<script>hideResetForm();</script>';/
//            } else {
//                // The token is still valid
//                echo 'Token has expired';
//            }//
//            echo "<br> ----> <br>";
//            print_r($_SESSION);
//
//            // Wszystkie się zgadza, ... ->
//            // Formularz resetowania hasła  +   Update tabeli klienci -->
//
//            //$data = [$token, $_SESSION["id"]];
//
//            //print_r($data);
//
//            //eixt();
//
//            // sprawdzenie czy user podał poprawny token (który otrzymał na maila) ->
//
//            //query("SELECT token, email, exp_time FROM password_reset_tokens WHERE token='%s' AND email='%s'", "verify_token", $data);
//
////            if($_SESSION["token verified"] == true) {
////
////                echo "<br><br><br><br><br><br><br> poprawny token !";
////
////            } else {
////                echo "<br><br><br><br><br><br><br> NIEpoprawny token !";
////            }
//        }
//    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php" ?>

<body>

<script src="../scripts/hide-field.js"></script>

<?php require "../view/header-container.php" ?>

<div id="container">

    <main>

        <aside>
            <div id="nav"></div>
        </aside>

        <div id="content">

            <?php print_r($_SESSION); ?>

            <!-- Formularz      Resetowania hasła -->

            <form method="post" id="reset-form">

                Przypomnij hasło<br><br>

                <!-- Login: <br> <input type="text" name="login"> <br> -->
                <div id="get-email">podaj e-mail: <input type="email" name="email"><br></div>

                <br><input type="submit" value="Przypomnij hasło">

                <?php
                    if(isset($_SESSION["email-not-exists"]) && $_SESSION["email-not-exists"])
                    {
                        echo "<br><br>Nie istnieje konto przypisane do tego adresu<br>";
                        unset($_SESSION["email-not-exists"]);
                    }
                ?>

            </form>

            <?php
                if(isset($_SESSION["email-sent"]) && $_SESSION["email-sent"] && !isset($_SESSION["token_verified"])) {

                    // udało się przesłać email klientowi

                    $toekn_form = file_get_contents("../view/email-sent.php");
                    echo $toekn_form;
                    echo '<script>hideResetForm();</script>';
                } else {

                    if(isset($_SESSION["sent-error"]) || (isset($_SESSION["email-sent"]) && ($_SESSION["email-sent"] == false))) {

                        echo "<div>nie udało się wysłać wiadomości na podany adres e-mail</div>";
                        unset($_SESSION["sent-error"]);
                        unset($_SESSION["email-sent"]);
                        //echo $_SESSION["sent-error"];
                        // unset ?
                    }
                }
            ?>

            <?php
                if(isset($_SESSION['e_reset'])) {   // niepoprany email

                    echo "<br>". $_SESSION['e_reset'] . "<br>";
                    unset($_SESSION['e_reset']);
                }

                if(isset($_SESSION["sent-error"])) { // błąd z wysłaniem maila

                    echo "<br>". $_SESSION["sent-error"] . "<br>";
                    unset($_SESSION["sent-error"]);
                }
            ?>

            <!--<form action="reset_password.php" method="post">-->
            <!--    <input type="hidden" name="id_ksiazki" value="%s">-->
            <!--    <input type="hidden" name="koszyk_ilosc" class="koszyk_ilosc"  value="1">-->
            <!--</form>-->

            <!--<br><button type="submit" name="reset-password-btn" id="reset-pass-btn" value="value" class="btn-link">Przypomnij hasło</button><br>-->

    <!--        <br><br>-->

            <?php

                if ( isset($_SESSION["email_exists"]) &&
                    $_SESSION["email_exists"] &&
                    isset($_SESSION["email-sent"]) &&
                    $_SESSION["email-sent"] &&
                    isset($_POST["token"]) &&
                    !empty($_POST["token"])
                ) {
                    // jeśli udało się wysłać maila do klienta, i klient przesłał (odesłał) token który otrzymał na maila -->

                    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING); // sanityzacja danych wejściowych (tokenu);

                    $token_hashed = hash('sha256', $token);

                    if($token === false || $token === null) {

                        // $token nie przeszedł walidacji/sanityzacji ...

                        $_SESSION["bad-token"] = "zły token";
                        echo "<br>". $_SESSION["bad-token"];
                        unset($_SESSION["bad-token"]);

                    } else {

                        // musimy pobrać maila na podstawie tokenu ✓

                        query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s'", "verify_token", $token_hashed); // $_SESSION["token_verified"] --> true jeśli podany token jest poprawny, $_SESSION["token verified"] = email_klienta_zgodny_z_tokenem;
                        //   $_SESSION["email"] = $row["email"];
                        //   $_SESSION["exp_time"] = $row["exp_time"];
                                    // $_SESSION["token_verified"] = true; (jeśli znaleziono taki token w BD)
                                    // $_SESSION["email"] = $row["email"];
                                    // $_SESSION["exp_time"] = $row["exp_time"];

                        //print_r($_SESSION);
                        // Array ( [email_exists] => 1 [email-sent] => 1 [token_verified] => 1 [email] => jakub.wojciechowski.682@gmail.com [exp_time] => 2023-03-11 19:12:17 )

                        if(isset($_SESSION["token_verified"]) && isset($_SESSION["email"]) && isset($_SESSION["exp_time"]) && $_SESSION["token_verified"] && !empty($_SESSION["email"]) && !empty($_SESSION["exp_time"]) && !isset($_POST["new-password"]) && !isset($_POST["confirm-password"])) {

                            unset($_SESSION["bad-token"]);

                            // użytkownik podał poprawny token ->

                            $exp_time = $_SESSION["exp_time"];   // data wygaśnięcia tokenu;
                            $datetime = new DateTimeImmutable();
                            $cur_date = $datetime->format('Y-m-d H:i:s'); // aktualna data

                            // Czy token był nadal ważny ?
                            if ($cur_date < $exp_time) {

                                // token nadal aktualny ...

                                echo '<script>hideResetForm();</script>';
                                echo '<script>hideTokenForm();</script>';

                                $reset_form = file_get_contents("../template/reset-password-form.php"); // template

                                echo sprintf($reset_form, $_SESSION["email"]);

                                //echo $reset_form;

                            } else {
                                // the token not valid
                                echo "<br>Podany token nie jest juz aktualny<br>";
                            }
                        } elseif ( empty($_SESSION["token_verified"]) ) {
                            // ...
                            $_SESSION["bad-token"] = "zły token";
                            echo "<br>". $_SESSION["bad-token"];
                            unset($_SESSION["bad-token"]);
                        }
                    }
                }

                // wysłanie nowego hasła (POST) -->

                if ( (isset($_POST["new-password"]) )

                ) {
                    $new_password = $_POST["new-password"];
                    $confirm_password = $_POST["confirm-password"];

                    echo '<script>hideResetForm();</script>';
                    echo '<script>hideTokenForm();</script>';

                    $reset_form = file_get_contents("../template/reset-password-form.php"); // template
                    echo sprintf($reset_form, $_SESSION["email"]);

                    if($new_password === $confirm_password) {

                        $pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

                        if(!(preg_match($pass_regex, $new_password))) {

                            $_SESSION['e_haslo'] = "
                            Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)";
                        } else {
                            $haslo = password_hash($new_password, PASSWORD_DEFAULT);
                            $data = [$haslo, $_SESSION["email"]];
                            query("UPDATE customers SET haslo = '%s' WHERE email = '%s'", "", $data);
                            //echo "<br>udało się zaktualizować dane<br>";

                            $_SESSION["password-changed"] = true;

                            query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["email"]);

                            //header('Location: zaloguj.php');
                            echo '<script>window.location.href="zaloguj.php";</script>';
                            exit();
                        }
                    } else {
                        //session_unset();
                        //session_destroy();
                        //print_r($_SESSION);
                        //echo "<br>Nie udało się zaktualizować danych<br>";
                        //echo '<a href ="http://localhost:8080/online_bookstore/user/reset_password.php">Spróbuj jeszcze raz</a>';

        //                echo '<script>hideResetForm();</script>';
        //                //echo '<script>hideTokenForm();</script>';
        //                $reset_form = file_get_contents("../template/reset-password-form.php"); // template
        //                echo sprintf($reset_form, $_SESSION["email"]);

                        echo "<br>Podane hasła nie są identyczne";

                    }
                } else {

                }
            ?>

            <?php
                if(isset($_SESSION["e_haslo"])) { // hasło nie spełnia wymagań


                    echo "<br>". $_SESSION["e_haslo"] . "<br>";
                    unset($_SESSION["e_haslo"]);
                }
            ?>

        </div>

        <?php print_r($_SESSION); ?>

    </main>

</div>

<?php require "../view/footer.php" ?>

<script src="../scripts/set-span-width-v2.js"></script>

</body>
</html>