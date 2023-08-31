<?php

    // "logowanie.php" - file is used for handling the login process.

    // POST -> email, haslo;

    // plik ten obsługuje proces logowania, zajmuje się przekierowaniem kierowanym od klienta, (serwer wysyła odpowiedź przekierowania do klienta - kod stanu 302 - HTTP);
    //  Gdy klient wysyła żądanie do „logowanie.php” (z pliku zaloguj.php - POST request z danymi formularza logowania) - kod PHP w pliku sprawdza różne warunki i stwierdza, czy przekierowanie konieczne. Następnie serwer wysyła kod stanu 302 wraz z nagłówkiem „Lokalizacja” (header), wskazując nową lokalizację, do której klient powinien zostać przekierowany.

    // Kod w pliku "logowanie.php" -  zawiera logikę sprawdzającą, czy użytkownik jest już zalogowany lub czy brakuje niezbędnych danych logowania. Jeśli spełniony jest którykolwiek z tych warunków, plik przekierowuje użytkownika na inną stronę, np. stronę logowania ("___zaloguj.php") lub stronę główną ("index.php").

    // Kiedy widzisz kod stanu 302 w narzędziach deweloperskich przeglądarki dla żądania „logowanie.php”, oznacza to, że serwer instruuje klienta, aby przekierował na inną stronę w oparciu o warunki zdefiniowane w kodzie PHP. Przeglądarka klienta powinna automatycznie podążać za przekierowaniem i wysłać nowe żądanie do określonej lokalizacji;

    // Korzystanie z przekierowania 302 jest powszechną praktyką obsługi procesów logowania i kontrolowania nawigacji użytkownika. Pozwala serwerowi zarządzać sesjami użytkowników, przeprowadzać niezbędne kontrole i przekierowywać użytkowników do odpowiednich stron na podstawie statusu logowania lub innych warunków.

    // ✓ Podsumowując, ten plik zajmuje się Przekierowaniem Klienta na odpowiednią stroną w zależności od różnych warunków;

            // logowanie - warto użyć  HTTPS / SSL;
            // "Limit login attempts: Prevent brute force attacks by limiting the number of login attempts allowed within a certain time period.";

	// session_start(); // a function that allows a document to use a session ; every document that uses a session must have this entry at the beginning.
	// include_once "../functions.php";

    require_once "../start-session.php";

	if ( (!isset($_POST["email"]) || !isset($_POST["password"])) ||              // jeśli nie ustawiono loginu/hasła;
         (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true)) { // lub jesteśmy zalogowani (byliśmy zalogowani wcześniej);

        // spełni się, jeśli (sprawdzone 100% - testowałem) -->
            // nie podaliśmy loginu i hasła, oraz nie byliśmy zalogowani;
            // nie podaliśmy loginu i hasła, oraz bylismy zalogowani;
            // podaliśmy login i hasło, oraz byliśmy zalogowani;    ("ponieważ jeśli byliśmy już zalogowani, to chcemy aby przekierowało nas na stronę główną);

        // nie spełni się, jeśli ->
            // podaliśmy login i hasło, oraz nie byliśmy zalogowani; ("normale logowanie");

        // Podsumowując można powiedzież, że przekierowanie na index.php nastąpi, w przypadkach gdy :
            // nie podaliśmy loginu i hasła,
            // lub jeśli byliśmy już zalogowani

		header('Location: ___zaloguj.php'); exit();

	} else { // zmienne $_POST["email"], $_POST["password"] - istnieją (mogą być puste), ORAZ (AND) NIE jesteśmy zalogowani ;
             // ✓ spełni się, jeśli -> podaliśmy login i hasło, oraz nie byliśmy zalogowani; ("normale logowanie");

        // $email = $_POST['email']; // "jason1@wp.pl";
		// $email = htmlentities($email, ENT_QUOTES, "UTF-8"); // zamiana na encje - zamiana znaków kodów źródłowych na encje; &lt&gt;

		$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            // email - po procesie sanityzacji, // FILTER_SANITIZE_EMAIL - filtr do adresów mailowych (used to sanitize and validate email addresses);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email) || ($email !== $_POST["email"])) { // email nie przeszedł walidacji;
			$_SESSION["invalid_credentials"] = '<span class="error">Podaj poprawny adres e-mail</span>';
			    header('Location: ___zaloguj.php');
                    exit();
        } else { // email is correct; (email is valid - filter_var);

			    // query("SELECT * FROM klienci WHERE email='%s'", "log_in", $email_sanitized);

            require('C:\xampp\apache\conf\config.php');
            $secret = RECAPTCHA_SECRET_KEY; // re-captcha secret-key

            // make HTTP request to Google reCAPTCHA API to verify the user's response; returns encoded JSON string, that needs to be decoded;
            // pobierz zawartość pliku z odpowiedzią Google;
            $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response'])); // $response - decoded PHP object;
            // $response => stdClass Object ( [success] => 1 [challenge_ts] => 2023-08-15T15:41:42Z [hostname] => localhost )
            if (!$response->success) {
                $_SESSION["e_recaptcha"] = '<span class="error">Weryfikacja reCaptcha nie przebiegła pomyślnie</span>';
                    header('Location: ___zaloguj.php');
                        exit();
            }

            $_SESSION["invalid_credentials"] = '<span class="error">Nieprawidłowy e-mail lub hasło</span>'; // initialize erros message;

			query("SELECT kl.id_klienta, kl.haslo, kl.imie, kl.nazwisko, kl.telefon, kl.email, kl.adres_id,
                                ad.miejscowosc, ad.ulica, ad.numer_domu, ad.kod_pocztowy, ad.kod_miejscowosc
                         FROM clients AS kl, address AS ad 
                         WHERE kl.adres_id = ad.adres_id
                         AND BINARY kl.email='%s'", "log_in", $email);
            // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST["password"];

            // funkcja log_in - ustawia $_SESSION["blad"] == "nieprawidłowy login lub hasło" - jeśli podano złe dane logowania;
                // jeśli podano poprawne dane logowania, wewnątrz funkcji następuje przekierowanie do odpowiednich plików;

            if (isset($_SESSION["invalid_credentials"])) { // ✓ niepoprawne dane logowania - nie znaleziono takiego KLIENTA (email) !, próba znalezienia takiego pracownika;
                // ✓ błąd powstały w wyniku złych danych logowania KLIENTA (nieistniejący email) - jeśli podano istniejący e-mail, to to się ✓ nie wykona, tylko nastąpi przekierowanie do zaloguj.php z komunikatem błędu - (warunek else password_verify() w log_in)
                // ✓ może te dane logowania NALEŻĄ DO PRACOWNIKA ?

                query("SELECT pr.id_pracownika, pr.haslo, pr.imie, pr.nazwisko, pr.telefon, pr.email, pr.stanowisko, pr.adres_id,
                                ad.miejscowosc, ad.ulica, ad.numer_domu, ad.kod_pocztowy, ad.kod_miejscowosc
                         FROM employees AS pr, address AS ad 
                         WHERE pr.adres_id = ad.adres_id
                         AND pr.email='%s'", "log_in", $email) ;
                // problem implementacyjny --> ✓ zmodyfikować funkcję log_in ! // ✓ dodac instrukcję warunkową (if);
            }

            header('Location: ___zaloguj.php');
                exit(); // zmienna $_SESSION["invalid_credentials"] jest ustawiona, podano adres e-mail który nie należy ani do klienta, ani do pracownika; | lub | podano złe hasło (do istniejącego konta);
                // jeśli nie nastąpiło wcześniej przekierowanie w funkcji log_in - (w przypadku podania nie-istniejącaego adresu e-mail - który nie należy ani do klienta, ani do pracownika) - funkcja log_in() zwraca return (nie następuje przekierowanie);   zmienna $_SESSION["blad"] jest ustawiona, zostanie wyświetlony komunikat w zaloguj.php; (to się wykona, jeśli podany e-mail który nie należy do żadnego klienta ani do żadnego pracownika);
		}
	}

?>