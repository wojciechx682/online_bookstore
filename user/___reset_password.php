<?php

// podział kodu ma moduły / funkcje;    generowanie tokenu,     wysyłanie maila;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    require_once "../start-session.php";

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer; // In PHP, the "use" statement - is used to import external classes or namespaces into the current PHP file;
use PHPMailer\PHPMailer\Exception; // This line imports the "Exception" class from the PHPMailer\PHPMailer namespace;
use PHPMailer\PHPMailer\SMTP;      // The SMTP class is used for providing an alternative method of sending emails using the Simple Mail Transfer Protocol (SMTP);

// by including these use statements, you can refer to these classes directly by their names (PHPMailer, Exception, and SMTP)

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {                 // Post - Redirect - Get

    if ( isset($_POST["email"]) && ! empty($_POST["email"]) ) { // if email was in POST request;

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL); // email - OR - FALSE
                                                                                                // validate if provided email is correct;
                                                                                                // return false if email failed validation;
        if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ||
             $email === false ||
             $email !== $_POST["email"] ) {
                // email didn't pass validation;
                // ensures that the email input is sanitized and valid;
                // to avoid any potential XSS attacks and other vulnerabilities;
            $_SESSION["email-not-valid"] = "<h3 class='error'>Podaj poprawny adres e-mail</h3>"; // display error message;

            unset($_POST, $email);
            header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;

        } else {  // email passed the validation (filter_var);

            // check if there is any user (client) with that email;

            query("SELECT id_klienta, imie, email FROM klienci WHERE email='%s'", "check_email", $email);
            // ustawi zmienną       $_SESSION["email-exists"] --> na "true", jeśli JEST taki user (email) - (jeśli zwrócono rekordy z BD -> $result);
            //                      $_SESSION["imie"];
            //                      $_SESSION["given-email"]; <-- adres wprowadzony w POST["email"]

            if ( isset($_SESSION["email-exists"]) && $_SESSION["email-exists"] ) { // jeśli user podał email, który rzeczywiście istnieje (i do kogoś należy);

                // istnieje taki user (email), można zresetować mu hasło;

                query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE email='%s'", "verify_token", $email);
                // sprawdź, czy istnieje{ą) już tokeny w tabeli "password_reset_tokens" dla tego adresu e-email !;
                if ( isset($_SESSION["token-exists"]) && $_SESSION["token-exists"] ) {
                    // usuń wszystkie tokeny (jeśli istniały) z tej tabeli, dla tego klienta;
                    query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $email); // delete all rows with that email
                    unset($_SESSION["token-exists"], $_SESSION["email"], $_SESSION["exp-time"], $_SESSION["token"]);
                }

                $token_hashed = generate_token(); // returns false | OR | string ($token);

                if ($token_hashed) {

                    // token generated successfully

                    $datetime = new DateTimeImmutable();
                    $exp_time = $datetime->add(new DateInterval('PT15M'))->format('Y-m-d H:i:s'); // token expiration date;
                    $data = [$token_hashed, $email, $exp_time];

                    query("INSERT INTO password_reset_tokens (token_id, token, email, exp_time) VALUES (NULL, '%s', '%s', '%s')", "", $data);
                    // wstawienie wpisu do tabeli z tokenami (token + emaiL, exp_time);

                    try { // wyślij do klienta email z tokenem

                        $mail = new PHPMailer(true);   // create a new PHPMailer instance, passing `true` enables exceptions;


                        $mail->isSMTP();                         // Server settings below, Send using SMTP
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // aby widzieć komunikaty przebiegu wysyłania wiadomośći;

                        $mail->Host = 'smtp.gmail.com';          // Set the SMTP server to send through
                        $mail->Port = 465;                       // TCP port to connect to;  use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                        $mail->SMTPAuth = true;                  // Enable SMTP authentication

                        $mail->Username = 'jakub.wojciechowski.683@gmail.com'; // adres nadawcy; podaj swój adres gmail // SMTP username
                        $mail->Password = 'ubkdmiyqcquifysy';                  // podaj swoje HASŁO DO APLIKACJI (!) - gmail; // SMTP password

                        $mail->CharSet = 'UTF-8';  // konfiguracja wiadomości
                        $mail->setFrom('app.bookstore@gmail.com', 'Księgarnia internetowa - Przypomnij hasło'); // nazwa odbiorcy (name)
                        $mail->addAddress($email); // email ODBIORCY ;
                        //$mail->addReplyTo('biuro@domena.pl', 'Biuro');

                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Księgarnia internetowa - Przypomnij hasło';

                        $user = $_SESSION["imie"];

                        $mail->Body = '
                        <html>
                            <head>
                                <title>Przypomnij hasło</title>
                            </head>
                            <body>
                                <p>Witaj <b>'.$user.'</b>, </p>                            
                                <p>Poprosiłeś o zresetowanie hasła do swojego konta w księgarni. Aby zresetować hasło, wprowadź poniższy token na <strong><i><u>stronie resetowania hasła</u></i></strong> w aplikacji</p>                               
                                <h4>'.$token_hashed.'</h4>                             
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

                            unset($_POST, $email, $_SESSION["email-exists"], $_SESSION["imie"]);
                            header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;

                        } else {
                            $_SESSION["email-sent"] = false; // email niewysłany, wystąpił błąd
                        }

                    } catch(Exception $e) {

                        $_SESSION["sent-error"] = "<span class='error error-password'>{$mail->ErrorInfo}</span>";

                        unset($_POST, $email, $_SESSION["email-exists"], $_SESSION["imie"], $_SESSION["given-email"]);
                        header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
                    }

                } else {

                    // token generation failed, handle the error accordingly
                    $_SESSION["e-token"] = "<h3 style='margin-bottom: 0; padding-bottom: 0;'>Wystąpił błąd podczas generowania tokenu. Spróbuj jeszcze raz</h3>";

                    unset($_POST, $email, $_SESSION["email-exists"], $_SESSION["imie"], $_SESSION["given-email"]);
                    header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
                }

            } else {
                $_SESSION["email-exists"] = false;

                unset($_POST, $email);
                header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
            }
        }
    }

    elseif (isset($_POST["token"]) && ! empty($_POST["token"]) ) {

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING); // zahashowany token | lub | FALSE;

        if($token === false || $token !== $_POST["token"] ) {

            // $token nie przeszedł walidacji / sanityzacji

            $_SESSION["bad-token"] = '<span class="error">Zły token</span>';
            unset($_POST, $token);
            header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;

        } else {

            // $_POST["token"] --> $token,
            // $_SESSION["given-email"]

            // ✓ musimy sprawdzić, czy istnieje wpis (rekord) w tabeli "password_reset_tokens" dla podanego tokenu ($_POST["token"]) oraz maila ($_SESSION["given-email"]) - jeśli jest taki rekord, oznacza to że user podał poprawny token ($_POST["token"]), jeśli nie zwróci rekordów, tzn że podano zły token

            query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s' AND email='%s'", "verify_token", [$token, $_SESSION["given-email"]]);

            // ✓ $_SESSION["token-exists"] = true; (jeśli znaleziono taki token w BD - czyli user podał poprawny token !);
            // ✓ $_SESSION["email"] = $row["email"];
            // ✓ $_SESSION["exp_time"] = $row["exp_time"];
            // ✓ $_SESSION["token"] = $row["token"];

            if ( isset($_SESSION["token-exists"]) && $_SESSION["token-exists"] && // ✓ istnieje taki token w bd dla takiego maila,
                 isset($_SESSION["email"]) && ! empty($_SESSION["email"]) &&
                 isset($_SESSION["exp-time"]) && ! empty($_SESSION["exp-time"]) &&
                 isset($_SESSION["token"]) && ! empty($_SESSION["token"]) ) {

                /*&& $_SESSION["email"] == $_SESSION["given-email"]
                && ! isset($_POST["new-password"]) && ! isset($_POST["confirm-password"])*/

                unset($_SESSION["bad-token"]);

                // wysłano formularz z tokenem

                /*if($_SESSION["token"] != $token) {
                    $_SESSION["bad-token"] = "<h3>354 Zły token</h3>";
                } else {

                }*/ // jeśli podano błędny token (nieistniejący, to ten kod który czytasz w tym miejscu się nie wykona !

                $exp_time = $_SESSION["exp-time"];   // data wygaśnięcia tokenu;
                $datetime = new DateTimeImmutable();
                $cur_date = $datetime->format('Y-m-d H:i:s'); // aktualna data;

                // czy token był nadal ważny ?

                if ($cur_date < $exp_time) {

                    // token był nadal aktualny ... ;

                    /*echo '<script>hideResetForm();</script>';
                    echo '<script>hideTokenForm();</script>';
                    $reset_form = file_get_contents("../template/reset-password-form.php"); // template - szablon - "Wprowadź nowe hasło dla konta ..." ;
                    echo sprintf($reset_form, $_SESSION["email"]);*/

                    $_SESSION["token-valid"] = true;

                    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";
                    echo "SESSION ->"; var_dump($_SESSION); echo "<hr><br>";
                    echo "PHP_SELF ->"; print_r($_SERVER['PHP_SELF']); echo "<hr><br>"; exit();*/

                    unset($_POST, $_SESSION["email-sent"], $_SESSION["token-exists"], $_SESSION["email"], $_SESSION["exp-time"], $_SESSION["token"]);
                    header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303

                } else { // expired token

                    $_SESSION["bad-token"] = "<h3>Podany token nie jest juz aktualny, Spróbuj jeszcze raz</h3>";
                   /* echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";
                    echo "SESSION ->"; var_dump($_SESSION); echo "<hr><br>";
                    echo "PHP_SELF ->"; print_r($_SERVER['PHP_SELF']); echo "<hr><br>"; exit();*/

                    unset($_POST, $_SESSION["token-exists"], $_SESSION["email"], $_SESSION["exp-time"], $_SESSION["token"]);
                    header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
                }

            } else {
                $_SESSION["bad-token"] = '<span class="error">Zły token</span>';
                unset($_POST);
                header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
            }
        }

    } elseif ( isset($_POST["new-password"]) && ! empty($_POST["new-password"]) &&
               isset($_POST["confirm-password"]) && ! empty($_POST["confirm-password"]) )  { // user przesłał poprzez formularz nowe hasło --> name="new-password";

        $new_password = $_POST["new-password"];
        $confirm_password = $_POST["confirm-password"];

        if($new_password === $confirm_password) {

            $pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

            if ( ! preg_match($pass_regex, $new_password) ) {

                $_SESSION["e-haslo"] = '<span class="error">Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)</span>';

                header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;

            } else {

                $haslo = password_hash($new_password, PASSWORD_DEFAULT);
                $data = [$haslo, $_SESSION["given-email"]];

                query("UPDATE klienci SET haslo = '%s' WHERE email = '%s'", "", $data);

                $_SESSION["password-changed"] = true;

                query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["given-email"]);

                header('Location: ___zaloguj.php', true, 303); exit(); // redirect with HTTP 303 response code;
            }

        } else {

            $_SESSION["e-haslo"] = "<h3>Podane hasła nie są identyczne</h3>";
            header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;
        }
    }
}

/*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
echo "GET ->"; print_r($_GET); echo "<hr><br>";
echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";
echo "SESSION ->"; var_dump($_SESSION); echo "<hr><br>";
echo "PHP_SELF ->"; print_r($_SERVER['PHP_SELF']); echo "<hr><br>"; exit();*/

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

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <script src="../scripts/hide-field.js"></script>

    <?php require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <div id="content">

                <h3 class="account-header reset-password-header">Przypomnij hasło</h3>

                <form method="post" id="reset-form">

                    <div id="get-email">
                        <label>
                            Podaj e-mail: <input type="text" name="email" required>
                        </label>
                    </div>

                    <input type="submit" value="Przypomnij hasło">

                </form>

                <?php

                    if ( isset($_SESSION["token-valid"]) && $_SESSION["token-valid"]) { // user provided valid (correct) token;

                        echo '<script>hideResetForm();</script>';
                        echo '<script>hideTokenForm();</script>';

                        $reset_form = file_get_contents("../template/reset-password-form.php");
                        echo sprintf($reset_form, $_SESSION["given-email"]);
                    }

                    if(isset($_SESSION["e_haslo"])) { // hasło nie spełnia wymagań ;

                        echo $_SESSION["e_haslo"];
                        unset($_SESSION["e_haslo"]);
                    }

                    if ( isset($_SESSION["email-sent"]) &&
                               $_SESSION["email-sent"] &&
                        ! isset($_SESSION["token-exists"]) ) { // udało się przesłać email klientowi;

                        $token_form = file_get_contents("../view/email-sent.php");
                        echo $token_form;

                        echo '<script>hideResetForm();</script>'; // ukrycie pierwszego formularza "Podaj-email";

                    }

                ?>

                <hr class="register-form-hr-line reset-form-hr-line">

                <form method="post" action="logout.php">
                    <input type="hidden" name="reset-password-form">
                    <button type="submit" class="reset-password-button">
                        Spróbuj jeszcze raz
                    </button>
                </form>

                <?php
                    if( isset($_SESSION["email-exists"]) && $_SESSION["email-exists"] === false )
                    {
                        // == "true" - jeśli nie istnieje takie konto z tym emailem - (nie istnieje taki email w bazie danych) ;
                        echo '<span class="error">Nie istnieje konto przypisane do tego adresu</span>';
                        unset($_SESSION["email-exists"], $_SESSION["given-email"]);

                    } elseif ( isset($_SESSION["e-token"]) && ! empty($_SESSION["e-token"]) ) {

                        echo $_SESSION["e-token"]; // "Wystąpił błąd podczas generowania tokenu ..."
                        unset($_SESSION["e-token"]);
                    }

                    if( isset($_SESSION["sent-error"]) || ( isset($_SESSION["email-sent"]) && ($_SESSION["email-sent"] === false) ) ) { // nie udało się wysłać maila ;

                        echo "<h3>Wystąpił błąd. Nie udało się wysłać wiadomości na podany adres e-mail</h3>".$_SESSION["sent-error"];
                        unset($_SESSION["sent-error"], $_SESSION["email-sent"], $_SESSION["given-email"]);
                    }

                    if( isset($_SESSION["email-not-valid"]) ) { // niepoprany email - email nie przeszedł walidacji ;

                        echo $_SESSION["email-not-valid"];
                        unset($_SESSION["email-not-valid"], $_SESSION["given-email"]);
                    }

                    if( isset($_SESSION["bad-token"]) ) {

                        echo $_SESSION["bad-token"];
                        unset($_SESSION["bad-token"]);
                    }

                    if( isset($_SESSION["e-haslo"]) ) {

                        echo $_SESSION["e-haslo"];
                        unset($_SESSION["e-haslo"]);
                    }

                ?>

            </div>

        </main>

    </div>

    <?php require "../view/footer.php" ?>

</div>

<script>
    content = document.getElementById("content"); // ustawienie wid div#content na 100%
    //console.log("content -> ", content);
    content.style.width = "100%";
</script>

<script src="../scripts/set-span-width-v2.js"></script>

</body>
</html>