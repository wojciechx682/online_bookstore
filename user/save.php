<?php

// plik nieużywany !

session_start();
include_once "../functions.php";

if(!isset($_SESSION['zalogowany'])) {
    header("Location: main.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMaileraaaa/src/Exception.php';
require 'PHPMaileraaaa/src/PHPMailer.php';
require 'PHPMaileraaaa/src/SMTP.php';


// Klasa PHPMailer - wysyłanie wiadomości w formacie HTML;
// https://github.com/PHPMailer/PHPMailer

if (isset($_POST['email'])) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (empty($email)) {

        //$_SESSION['given_email'] = $_POST['email']; // to sie może przydać
        header('Location: index.php');

    } else {

        /*require_once 'database.php';
        $query = $db->prepare('INSERT INTO users VALUES (NULL, :email)');
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();*/

        try {                           // try to send e-amil

            $mail = new PHPMailer();

            $mail->isSMTP();
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;

            $mail->Username = 'jacoboc389@gmail.com'; // Adres nadawcy; Podaj swój login gmail
            $mail->Password = 'mdbhfnolvlngshyc'; // Podaj swoje hasło do aplikacji

            // Konfiguracja wiadomości ->
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('no-reply-222online-bookstore@domena.pl', 'Przypomnienie hasła');
            $mail->addAddress("8pt2e9es@minimail.gq"); // email ODBIORCY
            $mail->addReplyTo('biu123ro@domena.pl', 'Biuro');

            $mail->isHTML(true);
            $mail->Subject = 'Księgarnia internetowa - Przypomnij hasło';
            //$mail->Body = 'Hello World!';

            /*$mail->Body = '<html>
                <body>
                    <h1></h1>
                    ...
                    ...
                </body>
            </html>';*/

            // https://stackoverflow.com/questions/15890627/phpmailer-body-with-variables

            $mail->Body = '
            <html>
                <head>
                    <title>Przypomnij hasło</title>
                </head>
                <body>
                    <p>Witaj,</p>
                    <p>Poprosiłeś o zresetowanie hasła. Aby zresetować hasło, kliknij poniższy link/p>
                        <a href="#">...</a>
                    <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                    <br>
                    <p>© 2023 Online Bookstore. All rights reserved.</p>
                </body>
            
            </html>
            
            
            ';

            //$mail->addAttachment('img/html-ebook.jpg'); // dodanie załącznika

            $mail->send(); // wysłanie wiadomości


        } catch(Exception $e) {
            echo "Błąd wysyłania maila: {$mail->ErrorInfo}";
        }

    }


} else {

    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <title>Zapisanie się do newslettera</title>
    <meta name="description" content="Wysyłanie maili w PHP - funkcja mail(), PHPMailer, SwiftMailer">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">

    <header>
        <h1>Hurra! Wysłaliśmy Ci ebooka!</h1>
        <h1>(Nie no a tak serio to nie ...)</h1>
    </header>

    <main>
        <article>
            <p class="content">Dziękujemy za zapisanie się na listę mailową naszego newslettera! Link do obiecanego, darmowego ebooka znajdziesz w przysłanej przed chwilą wiadomości! W razie problemów z odnalezieniem maila sprawdź koniecznie zawartość folderu "Spam" w swojej skrzynce pocztowej. Owocnej lektury!</p>
        </article>
    </main>

</div>

</body>
</html>