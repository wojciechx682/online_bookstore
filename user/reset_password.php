<?php

// podział kodu ma moduły / funkcje;    generowanie tokenu,     wysyłanie maila;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*require_once "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;*/

    require_once "../start-session.php";

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

/*require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer; // In PHP, the "use" statement - is used to import external classes or namespaces into the current PHP file;
use PHPMailer\PHPMailer\Exception; // This line imports the "Exception" class from the PHPMailer\PHPMailer namespace;
use PHPMailer\PHPMailer\SMTP; */     // The SMTP class is used for providing an alternative method of sending emails using the Simple Mail Transfer Protocol (SMTP);

// by including these use statements, you can refer to these classes directly by their names (PHPMailer, Exception, and SMTP)

/*require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';*/ // <!-- bez użycia Composera !


if ($_SERVER["REQUEST_METHOD"] === "POST") {                 // Post - Redirect - Get

    if (isset($_POST["email"])) { // if email was in POST request;

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL); // email - OR - FALSE
                                                                                                // validate if provided email is correct;
                                                                                                // return false if email failed validation;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email) || $email !== $_POST["email"]) {
                // email didn't pass validation;
                // ensures that the email input is sanitized and valid;
                // to avoid any potential XSS attacks and other vulnerabilities;
            $_SESSION["email-not-valid"] = "Podaj poprawny adres e-mail";

        } else { // email passed the validation (filter_var);

                unset($_SESSION["email-exists"]);
            query("SELECT id_klienta, imie, email FROM customers WHERE email='%s'", "resetPasswordCheckEmail", $email);  // check if there is any user (client) with that email;

            // query("SELECT 'klient' AS user_type, imie, email FROM klienci WHERE BINARY email = '%s' UNION SELECT 'pracownik' AS user_type, imie, email FROM pracownicy WHERE BINARY email = '%s'", "resetPasswordCheckEmail", [$email, $email]);

                // ustawi zmienną       $_SESSION["email-exists"] --> na "true", jeśli JEST taki user (email) - (jeśli zwrócono rekordy z BD -> $result);
                //                                                        w przeciwnym razie, zmienna nie istnieje (null)
                //                      $_SESSION["imie"]; --> (imie klienta)

            if (isset($_SESSION["email-exists"]) && $_SESSION["email-exists"]) { // jeśli user podał email, który rzeczywiście istnieje (i do kogoś należy);

                // istnieje taki user (email), można zresetować mu hasło;

                    unset($_SESSION["token-exists"], $_SESSION["email"], $_SESSION["exp-time"], $_SESSION["token"]);
                query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE email='%s'", "verifyToken", $email);
                // sprawdź, czy istnieje{ą) już tokeny w tabeli "password_reset_tokens" dla tego adresu e-email !;
                if (isset($_SESSION["token-exists"]) && $_SESSION["token-exists"]) {
                    // usuń wszystkie tokeny (jeśli istniały) z tej tabeli, dla tego klienta;
                    query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $email); // delete all rows with that email
                        unset($_SESSION["token-exists"], $_SESSION["email"], $_SESSION["exp-time"], $_SESSION["token"]);
                }

                $token = generate_token(); // returns false | OR | string ($token);

                if ($token) {

                    // token (plain) generated successfully, hash user token to store it in database -->
                    $token_hashed = hash("sha256", $token); // hash user token using sha256 algorithm;
                    $datetime = new DateTimeImmutable();
                    $exp_time = $datetime->add(new DateInterval('PT15M'))->format('Y-m-d H:i:s'); // token expiration date;
                    $data = [$token_hashed, $email, $exp_time];

                    $insertSuccessful = query("INSERT INTO password_reset_tokens (token_id, token, email, exp_time) VALUES (NULL, '%s', '%s', '%s')", "", $data);
                    // wstawienie wpisu do tabeli z tokenami (token + emaiL, exp_time);

                    if ($insertSuccessful) { // udało się wstawić wiersz z tokenem do BD

                        $user = $_SESSION["imie"];

                        $message = '
                            <html>
                                <head>
                                    <title>Przypomnij hasło</title>
                                </head>
                                <body>
                                    <p>Witaj <b>'.$user.'</b>, </p>                            
                                    <p>Poprosiłeś o zresetowanie hasła do swojego konta w księgarni. Aby zresetować hasło, wprowadź poniższy kod na <strong><i><u>stronie resetowania hasła</u></i></strong> w aplikacji</p>                               
                                    <h4>'.$token.'</h4>                             
                                    <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                                    <p>Powyższy kod będzie aktywny tylko przez 15 minut</p>
                                    <br>
                                    <p>© 2023 Online Bookstore. All rights reserved.</p>
                                </body>                  
                            </html>
                        ';

                        $subject = "Księgarnia internetowa - Przypomnij hasło";

                        if (sendEmail($message, $email, $subject)) { // email wysłany pomyślnie

                            $_SESSION["email-sent"] = true;

                            unset($_SESSION["sent-error"]);

                        } else { // nie udało się wysłać wiadomości e-mail;

                            $_SESSION["email-sent"] = false; // email niewysłany, wystąpił błąd;
                        }

                        /*try {

                            // wyślij do klienta email z tokenem

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
                                    <p>Poprosiłeś o zresetowanie hasła do swojego konta w księgarni. Aby zresetować hasło, wprowadź poniższy kod na <strong><i><u>stronie resetowania hasła</u></i></strong> w aplikacji</p>
                                    <h4>'.$token.'</h4>
                                    <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                                    <p>Powyższy kod będzie aktywny tylko przez 15 minut</p>
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
                        }*/

                    } else { // nie udało się wstawić wiersza z tokenem do BD;

                        $_SESSION["e-token"] = "Wystąpił błąd podczas generowania kodu weryfikacyjnego. Spróbuj jeszcze raz";
                    }

                } else { // token generation failed (generate_token());

                    $_SESSION["e-token"] = "Wystąpił błąd podczas generowania kodu weryfikacyjnego. Spróbuj jeszcze raz";

                }

                unset($_SESSION["email-exists"], $_SESSION["imie"]);

            } else { // nie istnieje konto z takim adresem e-mail

                $_SESSION["email-exists"] = false;
            }
        }

        unset($_POST); // keep $email (post)
    }

    elseif (isset($_POST["token"])) {

        $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING); // zahashowany token | lub | FALSE;

        if (empty($token) || ($token !== $_POST["token"])) { // $token nie przeszedł walidacji

            $_SESSION["bad-token"] = "Wprowadzony kod jest nieprawidłowy. Upewnij się, że używasz najnowszego kodu wysłanego na Twój adres e-mail";

        } else { // $token passed validation (filter_input);

            // $_POST["token"] --> $token,

            // ✓ musimy sprawdzić, czy istnieje wpis (rekord) w tabeli "password_reset_tokens" dla podanego tokenu ($_POST["token"]) - jeśli jest taki rekord, oznacza to że user podał poprawny token ($_POST["token"]), jeśli nie zwróci rekordów, tzn że podano zły token;

            $token_hashed = hash("sha256", $token);

            query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s'", "verifyToken", $token_hashed);

            // ✓ $_SESSION["token-exists"] = true; (jeśli znaleziono taki token w BD - czyli user podał poprawny token !);
            // ✓ $_SESSION["email"] = $row["email"];  <------
            // ✓ $_SESSION["exp_time"] = $row["exp_time"];
            // ✓ $_SESSION["token"] = $row["token"];

            if ( isset($_SESSION["token-exists"]) && $_SESSION["token-exists"] &&
                 isset($_SESSION["email"]) && ! empty($_SESSION["email"]) &&
                 isset($_SESSION["exp-time"]) && ! empty($_SESSION["exp-time"]) &&
                 isset($_SESSION["token"]) && ! empty($_SESSION["token"]) ) { // istnieje taki token

                // ✓ istnieje taki token (hash) - nie musimy sprawdzać zgodności adresu e-mail, ponieważ algorytm hashujący sha-256 jest bezkolizyjny - ilość możliwych do wygenerowania hashy wynosi tyle --> 115,792,089,237,316,195,423,570,985,008,687,907,853,269,984,665,640,564,039,457,584,007,913,129,639,936

                unset($_SESSION["bad-token"]);

                $exp_time = $_SESSION["exp-time"];   // data wygaśnięcia tokenu;
                $datetime = new DateTimeImmutable();
                $cur_date = $datetime->format('Y-m-d H:i:s'); // aktualna data;

                if ($cur_date < $exp_time) {  // czy token był nadal ważny
                    // token był nadal aktualny;
                    $_SESSION["token-valid"] = true;
                    unset($_SESSION["email-sent"]);

                } else { // expired token

                    unset($_SESSION["email"]);
                    $_SESSION["bad-token"] = "Podany kod nie jest juz aktualny. Spróbuj jeszcze raz";
                }

            } else {

                $_SESSION["bad-token"] = "Wprowadzony kod jest nieprawidłowy. Upewnij się, że używasz najnowszego kodu wysłanego na Twój adres e-mail";
            }
        }

        unset($_POST, $_SESSION["token-exists"], $_SESSION["exp-time"], $_SESSION["token"]);

    } elseif ( isset($_POST["newPassword"]) && ! empty($_POST["newPassword"]) &&
               isset($_POST["confirmPassword"]) && ! empty($_POST["confirmPassword"]) )  { // user przesłał poprzez formularz nowe hasło --> name="new-password";

        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];

        if($newPassword === $confirmPassword) {

            $pass_regex = '/^((?=.*[!@#$%^&_*+-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

            if ( !preg_match($pass_regex, $newPassword) ) {

                $_SESSION["e-haslo"] = "Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&_*+-\/\?)";

            } else {

                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $data = [$newPassword, $_SESSION["email"]];
                    //unset($_SESSION["e-haslo"]);
                $updateSuccessful = query("UPDATE customers SET haslo = '%s' WHERE email = '%s'", "", $data);

                if($updateSuccessful) {

                    $_SESSION["password-changed"] = true;

                    query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["email"]);

                    header('Location: zaloguj.php', true, 303); exit(); // redirect with HTTP 303 response code;

                } else {

                    $_SESSION["e-haslo"] = "Wystąpił błąd. Nie udało się zmienić hasła";
                }
            }

        } else {

            $_SESSION["e-haslo"] = "Podane hasła nie są identyczne";
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF'], true, 303); exit(); // redirect with HTTP 303 response code;

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

<?php require "../view/head.php"; ?>

<body>

<div id="main-container">

    <script src="../scripts/hide-field.js"></script>

    <?php require "../view/header-container.php"; ?>

    <div id="container">

        <main>

            <div id="content">

                <h3 class="account-header reset-password-header">Przypomnij hasło</h3>

                <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && empty($_SESSION["email-sent"]) && empty($_SESSION["token-valid"]) ) : ?>

                    <form method="post" id="reset-form">

                        <div id="get-email">
                            <label>
                                Podaj e-mail: <input type="text" name="email" required>
                            </label>
                        </div>

                        <input type="submit" value="Przypomnij hasło">

                    </form>

                <?php elseif ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_SESSION["email-sent"])) : ?>

                    <!-- // udało się przesłać email klientowi; -->

                    <?php
                        $token_form = file_get_contents("../view/email-sent.php");
                        echo $token_form;

                    ?>

                <?php elseif ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_SESSION["token-valid"])) : ?>

                    <!-- // user provided valid (correct) token; -->

                    <?php
                        $reset_form = file_get_contents("../template/reset-password-form.php");
                        echo sprintf($reset_form, $_SESSION["email"]);

                        if(isset($_SESSION["e_haslo"])) { // hasło nie spełnia wymagań;

                            echo '<span class="error">'.$_SESSION["e_haslo"].'</span>';
                                unset($_SESSION["e_haslo"]);
                        }
                    ?>

                <?php endif; ?>

                <?php

                    /*if ( isset($_SESSION["token-valid"]) && $_SESSION["token-valid"]) { // user provided valid (correct) token;

                        echo '<script>hideResetForm();</script>';
                        echo '<script>hideTokenForm();</script>';

                        $reset_form = file_get_contents("../template/reset-password-form.php");
                        echo sprintf($reset_form, $_SESSION["email"]);
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

                    }*/

                ?>

                <hr class="register-form-hr-line reset-form-hr-line">

                <form method="post" action="logout.php">
                    <input type="hidden" name="reset-password-form">
                    <button type="submit" class="reset-password-button">
                        Spróbuj jeszcze raz
                    </button>
                </form>

                <?php

                    if (isset($_SESSION["email-exists"]) && $_SESSION["email-exists"] === false) {
                        // == "true" - jeśli nie istnieje takie konto z tym emailem - (nie istnieje taki email w bazie danych) ;
                        echo '<span class="error">Nie istnieje konto przypisane do tego adresu</span>';
                            unset($_SESSION["email-exists"], $_SESSION["email"]);

                    } elseif (isset($_SESSION["e-token"]) && ! empty($_SESSION["e-token"])) {

                        echo '<span class="error">'.$_SESSION["e-token"].'</span>'; // "Wystąpił błąd podczas generowania kodu weryfikacyjnego. Spróbuj jeszcze raz"
                            unset($_SESSION["e-token"]);
                    }

                    if (isset($_SESSION["sent-error"]) || (isset($_SESSION["email-sent"]) && ($_SESSION["email-sent"] === false))) { // nie udało się wysłać maila ;

                        echo "<span class='error error-password'>".$_SESSION["sent-error"]."</span>"; // "Wystąpił błąd. Nie udało się wysłać wiadomości na podany adres e-mail ... ";
                        unset($_SESSION["sent-error"], $_SESSION["email-sent"], $_SESSION["given-email"]);
                    }

                    if (isset($_SESSION["email-not-valid"])) { // email nie przeszedł walidacji (filter_input);

                        echo '<span class="error">'.$_SESSION["email-not-valid"].'</span>';
                        unset($_SESSION["email-not-valid"]);
                    }

                    if (isset($_SESSION["bad-token"])) {

                        echo '<span class="error">'.$_SESSION["bad-token"].'</span>'; // ""Wprowadzony kod jest nieprawidłowy. Upewnij się, że używasz najnowszego kodu wysłanego na Twój adres e-mail";
                        unset($_SESSION["bad-token"]);
                    }

                    if (isset($_SESSION["e-haslo"])) { // hasło nie przeszło walidacji

                        echo '<span class="error">'.$_SESSION["e-haslo"].'</span>';
                        unset($_SESSION["e-haslo"]);
                    }

                ?>

            </div>

        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</div>

<script>
    content = document.getElementById("content"); // ustawienie wid div#content na 100%
    //console.log("content -> ", content);
    content.style.width = "100%";
</script>

<script src="../scripts/set-span-width-v2.js"></script>

</body>
</html>