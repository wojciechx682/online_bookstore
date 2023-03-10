<?php

	session_start();

	include_once "../functions.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';


	//query("", "", "");
	
	if (isset($_POST["email"]) && !empty($_POST["email"])) {
	    
	        echo "<br> email -> " . $_POST["email"] . "<br><br>";
	    
	    //$email = $_POST["email"];
		
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		
	    
	    //$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // email - after the sanitization process. removes source code characters to avoid XSS attacks
	    
	    //echo "<br> email_s -> " . $email_s . "<br><br>";

	    if (empty($email)) 
		{
            // ensures that the email input is sanitized and valid
            // to avoid any potential XSS attacks and other vulnerabilities.
			//$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_reset'] = "Podaj poprawny adres e-mail";
		}
		else {
		    
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            // Sprawdzenie czy taki user (email) istnieje już w bazie, jeśli tak, to można zresetowac dla niego hasło
            
            var_dump($_SESSION); 
            
            query("SELECT id_klienta FROM klienci WHERE email='%s'", "check_email", $email);  
                                                                   // ustawi zmienną $_SESSION['email_exists'] na "true";
                
            if($_SESSION['email_exists'] == true) {
                
                // istnieje taki klient (email), można zresetować mu hasło ->
                
                $token = bin2hex(random_bytes(32));
                
                echo "<br> token --> " . $token . "<br>";
                
                $id = $_SESSION["id"];
                
                $data = [$id, $token];
                
                query("INSERT INTO password_reset_tokens (token_id, client_id, token) VALUES (NULL, '%s', '%s')", "", $data);  // ✓ 
                
                // jeśli nie wyjebało błędu przy INSERCIE, to jedziemy dalej -->
                
                //////////////////////////
                // wyślij do klienta email z linkiem ->
                
				echo "<br><br> 68 <br>";
				
                try {                           // try to send e-amil
                    
					
                    $mail = new PHPMailer();
        
                    $mail->isSMTP();
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;
        
                    $mail->Username = 'webapp.bookstore@gmail.com'; // Adres nadawcy; Podaj swój login gmail
                    $mail->Password = 'qhdptsplvclqyyhi'; // Podaj swoje hasło do aplikacji
        
                    // Konfiguracja wiadomości ->
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('no-reply-online-bookstore@domena.pl', 'Przypomnienie hasła');
                    $mail->addAddress($email); // email ODBIORCY
                    $mail->addReplyTo('biuro@domena.pl', 'Biuro');
        
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
                    
                    $url = 'https://apint000.000webhostapp.com/user/reset_password.php?email='.$email.'&token='.$token;
                    //$url = 'https://apint000.000webhostapp.com/user/reset_password.php?email='.urlencode($email).'&token='.urlencode($token);

                    $test = "123";

                    
                    $mail->Body = '
                    <html>
                        <head>
                            <title>Przypomnij hasło</title>
                        </head>
                        <body>
                            <p>Witaj,</p>
                            <p>Poprosiłeś o zresetowanie hasła. Aby zresetować hasło, kliknij poniższy link </p>
                                <a href="https://apint000.000webhostapp.com/user/reset_password.php?email=">reset_password</a>
                            <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                            <br>
                            <p>© 2023 Online Bookstore. All rights reserved.</p>
                        </body>
                    
                    </html>
                    
                    
                    ';
                    
                    // $mail->Body = '
                    // <html>
                    //     <head>
                    //         <title>Przypomnij hasło</title>
                    //     </head>
                    //     <body>
                    //         <p>Witaj,</p>
                    //         <p>Poprosiłeś o zresetowanie hasła. Aby zresetować hasło, kliknij poniższy link </p>
                    //             <a href=" https://apint000.000webhostapp.com/user/reset_password.php?email='.$email.'&token='.$token.'
                                
                    //             ">reset_password</a>
                    //         <p>Jeśli nie prosiłeś o zresetowanie hasła, możesz zignorować tę wiadomość.</p>
                    //         <br>
                    //         <p>© 2023 Online Bookstore. All rights reserved.</p>
                    //     </body>
                    
                    // </html>
                    
                    
                    // ';
        
                    //$mail->addAttachment('img/html-ebook.jpg'); // dodanie załącznika
        
                    $mail->send(); // wysłanie wiadomości
        
        
                } catch(Exception $e) {
                    echo "Błąd wysyłania maila: {$mail->ErrorInfo}";
                }
                
                
                
                
                
                
                //unset($_SESSION['email_exists']); 
                
                //exit();
            }    
                
            
            //exit();
		    
		    
		}
	    
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php" ?>

<body>

<?php require "../view/header-container.php" ?>

	<div id="container">	

		<div id="nav">

		</div>

		<div id="content">

            <?php var_dump($_SESSION); ?>

			<!-- Formularz      Resetowania hasła -->

			Przypomnij hasło<br><br>
			
			<form method="post">
			
				<!-- Login: <br> <input type="text" name="login"> <br> -->
				podaj e-mail: <input type="email" name="email" value=""> <br>
				
				<br><input type="submit" value="Przypomnij hasło">	
					
			</form>
			
			<?php
			
			    if(isset($_SESSION['e_reset'])) {
			        
			        echo "->". $_SESSION['e_reset'] . "<br>";
			        unset($_SESSION['e_reset']);
			        
			        
			    }
		    ?>
			
            <!--<form action="reset_password.php" method="post">-->
            <!--    <input type="hidden" name="id_ksiazki" value="%s">-->
            <!--    <input type="hidden" name="koszyk_ilosc" class="koszyk_ilosc"  value="1">-->
            <!--</form>-->
            
            <!--<br><button type="submit" name="reset-password-btn" id="reset-pass-btn" value="value" class="btn-link">Przypomnij hasło</button><br>-->
            
            

			
			
			

		</div>

        <?php require "../view/footer.php" ?>

	</div>
	
</body>
</html>