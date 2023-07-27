<?php

// podział kodu ma moduły / funkcje;    generowanie tokenu,     wysyłanie maila;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*session_start();
    include_once "../functions.php";*/

    require_once "../start-session.php";

use PHPMailer\PHPMailer\PHPMailer; // In PHP, the "use" statement is used to import external classes or namespaces into the current PHP file;
use PHPMailer\PHPMailer\Exception; // This line imports the "Exception" class from the PHPMailer\PHPMailer namespace;
use PHPMailer\PHPMailer\SMTP;      // The SMTP class is used for providing an alternative method of sending emails using the Simple Mail Transfer Protocol (SMTP);

// by including these use statements, you can refer to these classes directly by their names (PHPMailer, Exception, and SMTP)

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ( isset($_POST["email"]) && ! empty($_POST["email"]) ) { // if email was in POST request;

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // validate if provided email is correct;
        // return false if email failed validation;

    if ($email === false) { // email didn't pass validation;
                                  // ensures that the email input is sanitized and valid;
                                  // to avoid any potential XSS attacks and other vulnerabilities;
        $_SESSION['e_reset'] = "<h3>Podaj poprawny adres e-mail</h3>"; // display error message;
    }
    else {  // email passed the validation;

            // check if there is any user with that email;
                // sprawdzenie czy taki user (email) istnieje już w bazie, jeśli tak, to można zresetowac dla niego hasło;

        query("SELECT id_klienta, imie FROM klienci WHERE email='%s'", "check_email", $email);
        // ustawi zmienną       $_SESSION['email_exists'] -> na "true", jeśli jest taki user (email) - (jeśli zwrócono rekordy z BD - result);
        //                      $_SESSION["imie"];

        if( isset($_SESSION['email_exists']) && $_SESSION["email_exists"] ) { // jeśli user podał email, który rzeczywiście istnieje (i do kogoś należy);

            // istnieje taki klient (email), można zresetować mu hasło;

            // $token = bin2hex(random_bytes(32));    // generate random token;
            // $token_hashed = hash("sha256", $token); // hash user token using sha256 algorithm;

            $token_hashed = generate_token();

            if ($token_hashed !== null) {
                // Token generation succeeded, continue with your code
                // ...


                $datetime = new DateTimeImmutable();
                $exp_time = $datetime->add(new DateInterval('PT15M'))->format('Y-m-d H:i:s'); // token expiration date;
                $data = [$token_hashed, $email, $exp_time];

                query("INSERT INTO password_reset_tokens (token_id, token, email, exp_time) VALUES (NULL, '%s', '%s', '%s')", "", $data);
                // wstawienie wpisu do tabeli z tokenami (token + emaiL);

                // jeśli nie wyjebało błędu przy INSERCIE, to jedziemy dalej -->
                // wyślij do klienta email z tokenem ->

                try {

                    $mail = new PHPMailer(); // create a new PHPMailer instance;

                    $mail->isSMTP();
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // aby widzieć komunikaty przebiegu wysyłania wiadomośći;

                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;

                    $mail->Username = 'jakub.wojciechowski.683@gmail.com'; // adres nadawcy; podaj swój login gmail
                    $mail->Password = 'ubkdmiyqcquifysy';                  // podaj swoje hasło do aplikacji;

                    $mail->CharSet = 'UTF-8';  // konfiguracja wiadomości
                    $mail->setFrom('app.bookstore@gmail.com', 'Księgarnia internetowa - Przypomnij hasło'); // nazwa odbiorcy (name)
                    $mail->addAddress($email); // email ODBIORCY ;
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
                                <p>Poprosiłeś o zresetowanie hasła do swojego konta w księgarni. Aby zresetować hasło, wprowadź poniższy token na <strong><i><u>stronie resetowania hasła</u></i></strong> w aplikacji</p>                               
                                <strong><i>'.$token_hashed.'</i></strong>                                
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
                // Token generation failed, handle the error accordingly
                // ...

                $_SESSION['e_token'] = "<h3 style='margin-bottom: 0; padding-bottom: 0;'>Wystąpił błąd podczas generowania tokenu. Spróbuj jeszcze raz</h3>"; // display error message;
            }


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

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <script src="../scripts/hide-field.js"></script> <!-- (!) -->

    <?php require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

           <!-- <aside> <div id="nav"> </div> </aside> -->

            <div id="content">

                <?php
                    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";*/
                ?>

                <!-- Formularz Resetowania hasła -->

                <form method="post" id="reset-form">

                    <h3 class="account-header">Przypomnij hasło</h3>

                    <div id="get-email">
                        <label>
                            Podaj e-mail: <input type="email" name="email">
                        </label>
                    </div>

                    <input type="submit" value="Przypomnij hasło">

                    <?php
                        if( isset($_SESSION["email-not-exists"]) && $_SESSION["email-not-exists"] )
                        {
                                // == "true" - jeśli nie istnieje takie konto z tym emailem (nie istnieje taki email w bazie danych) ;
                            echo "<h3>Nie istnieje konto przypisane do tego adresu</h3>";
                                unset($_SESSION["email-not-exists"]);
                        } elseif ( isset($_SESSION["e_token"]) && ! empty($_SESSION["e_token"]) ) {

                            echo "<h3>".$_SESSION["e_token"]."</h3>";
                            unset($_SESSION["e_token"]);
                        }
                    ?>

                </form>

                <?php
                    if( isset($_SESSION["email-sent"]) && $_SESSION["email-sent"] && ! isset($_SESSION["token_verified"]) ) {

                        // udało się przesłać email klientowi;

                        $toekn_form = file_get_contents("../view/email-sent.php");
                        echo $toekn_form;
                        echo '<script>hideResetForm();</script>'; // ukrycie pierwszego formularza "Podaj-email";
                    } else {

                        if( isset($_SESSION["sent-error"]) || ( isset($_SESSION["email-sent"]) && ($_SESSION["email-sent"] == false) ) ) {

                            echo "<div>Nie udało się wysłać wiadomości na podany adres e-mail</div>";
                            unset($_SESSION["sent-error"]);
                            unset($_SESSION["email-sent"]);
                            //echo $_SESSION["sent-error"];
                            // unset ?
                        }
                    }
                ?>

                <?php
                    if( isset($_SESSION['e_reset']) ) {   // niepoprany email - email nie przeszedł walidacji ;

                        echo " ". $_SESSION['e_reset'] . "<br>";
                            unset($_SESSION['e_reset']);
                    }

                    if( isset($_SESSION["sent-error"]) ) { // błąd z wysłaniem maila

                        echo " ". $_SESSION["sent-error"] . "<br>";
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

                    if (   isset($_SESSION["email_exists"]) && $_SESSION["email_exists"] // jeśli istnieje taki user (email) w BD,
                        && isset($_SESSION["email-sent"]) && $_SESSION["email-sent"]     // jeśli udało się wysłać maila,
                        && isset($_POST["token"]) && ! empty($_POST["token"])            // ..\view\email-sent --> input, name="token";
                    ) {
                        // jeśli udało się wysłać maila do klienta, i klient przesłał (odesłał) token który otrzymał na maila;

                        // (!) to jest zahashowany token ;
                        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
                            // sanityzacja danych wejściowych (tokenu);

                        // $token_hashed = hash('sha256', $token);

                        if($token === false || $token === null || $token !== $_POST["token"] ) {

                            // $token nie przeszedł walidacji / sanityzacji ...

                            $_SESSION["bad-token"] = "<h3>Zły token</h3>";
                                echo " ". $_SESSION["bad-token"];
                            unset($_SESSION["bad-token"]);

                        } else {

                            // musimy pobrać maila na podstawie tokenu ✓ ;

                            query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s'", "verify_token", $token);
                            // $_SESSION["token_verified"] --> true - jeśli podany token jest poprawny (ponieważ zwróciło rekordy w $result),  ̶$̶_̶S̶E̶S̶S̶I̶O̶N̶[̶"̶t̶o̶k̶e̶n̶ ̶v̶e̶r̶i̶f̶i̶e̶d̶"̶]̶ ̶=̶ ̶e̶m̶a̶i̶l̶_̶k̶l̶i̶e̶n̶t̶a̶_̶z̶g̶o̶d̶n̶y̶_̶z̶_̶t̶o̶k̶e̶n̶e̶m̶ ̶;̶

                            // ✓ $_SESSION["token_verified"] = true; (jeśli znaleziono taki token w BD - czyli user podał poprawny token !);
                            // ✓ $_SESSION["email"] = $row["email"];
                            // ✓ $_SESSION["exp_time"] = $row["exp_time"];

                            // print_r($_SESSION);
                            // Array ( [email_exists] => 1 [email-sent] => 1 [token_verified] => 1 [email] => jakub.wojciechowski.682@gmail.com [exp_time] => 2023-03-11 19:12:17 )

                            if( isset($_SESSION["token_verified"])
                                && isset($_SESSION["email"])
                                && isset($_SESSION["exp_time"]) && $_SESSION["token_verified"]
                                && ! empty($_SESSION["email"]) && ! empty($_SESSION["exp_time"])
                                && ! isset($_POST["new-password"]) && ! isset($_POST["confirm-password"]) ) {

                                unset($_SESSION["bad-token"]);

                                    // wysłano formularz z tokenem,
                                // użytkownik podał poprawny token ->

                                $exp_time = $_SESSION["exp_time"];   // data wygaśnięcia tokenu;
                                $datetime = new DateTimeImmutable();
                                $cur_date = $datetime->format('Y-m-d H:i:s'); // aktualna data;

                                // czy token był nadal ważny ?

                                if ($cur_date < $exp_time) {

                                    // token był nadal aktualny ... ;

                                    echo '<script>hideResetForm();</script>';
                                    echo '<script>hideTokenForm();</script>';

                                    $reset_form = file_get_contents("../template/reset-password-form.php"); // template - szablon - "Wprowadź nowe hasło dla konta ..." ;

                                    echo sprintf($reset_form, $_SESSION["email"]);

                                    //echo $reset_form;

                                } else {
                                    // the token not valid;
                                    echo "<h3>Podany token nie jest juz aktualny</h3>";
                                }
                            } elseif ( empty($_SESSION["token_verified"]) ) {
                                // ...
                                $_SESSION["bad-token"] = "<h3>Zły token</h3>";
                                    echo " ". $_SESSION["bad-token"];
                                unset($_SESSION["bad-token"]);
                            }
                        }
                    }

                    // wysłanie nowego hasła (POST) -->

                    if ( isset($_POST["new-password"]) ) // ..\template\reset-password-form.php ;
                    {
                        // user przesłał poprzez formularz nowe hasło --> name="new-password";

                        $new_password = $_POST["new-password"];
                            $confirm_password = $_POST["confirm-password"];

                        echo '<script>hideResetForm();</script>';
                            echo '<script>hideTokenForm();</script>';

                        $reset_form = file_get_contents("../template/reset-password-form.php"); // template
                        echo sprintf($reset_form, $_SESSION["email"]);

                        if($new_password === $confirm_password) {

                            $pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

                            if( ! preg_match($pass_regex, $new_password) ) {

                                $_SESSION['e_haslo'] = "<h3>
                                Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)</h3>";
                            } else {
                                $haslo = password_hash($new_password, PASSWORD_DEFAULT);
                                $data = [$haslo, $_SESSION["email"]];
                                query("UPDATE klienci SET haslo = '%s' WHERE email = '%s'", "", $data);
                                //echo "<br>udało się zaktualizować dane<br>";

                                $_SESSION["password-changed"] = true;

                                query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["email"]);

                                //header('Location: zaloguj.php');
                                echo '<script>window.location.href="___zaloguj.php";</script>';
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

                            echo "<h3>Podane hasła nie są identyczne</h3>";
                        }
                    } /*else {

                    }*/
                ?>

                <?php
                    if(isset($_SESSION["e_haslo"])) { // hasło nie spełnia wymagań ;

                        echo " ". $_SESSION["e_haslo"] . "<br>";
                        unset($_SESSION["e_haslo"]);
                    }
                ?>

                <br>
                <a href="logout.php">Spróbuj jeszcze raz</a>

            </div>

            <?php // print_r($_SESSION); ?>

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