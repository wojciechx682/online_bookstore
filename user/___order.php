<?php

    // dodać zabezpieczenie przed ponownym przesłaniem formularza (patrz /learn_php );
    session_start();
    include_once "../functions.php";

    if( ! isset($_SESSION['zalogowany']) ) {
        header("Location: index.php?login-error");
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

            <!-- <aside> <div id="nav"></div> </aside> -->

            <div id="content">

                <h3 id="order-summary-header">Podsumowanie zamówienia</h3>

                <p>Twoje zamówienie zostało przekazane do realizacji, aby śledzić postęp zamówienia przejdź do zakładki <a href="___my_orders.php"><strong>Moje konto / Zamówienia</strong></a></p>

                <?php

                $id_klienta = $_SESSION["id"];

                    // query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, au.imie, au.nazwisko FROM klienci AS kl, koszyk AS ko, ksiazki AS ks, autor AS au WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']); // Książki które zamówił klient o danym ID;

                if( (isset($_POST['zamowienie-typ-dostawy'])) &&    // "value" attribute from radio input
                    (isset($_POST['zamowienie-typ-platnosci'])) &&

                    (!empty($_POST['zamowienie-typ-dostawy'])) &&
                    (!empty($_POST['zamowienie-typ-platnosci']))
                )
                {
                    if($_POST['zamowienie-typ-dostawy'] == "Kurier DPD")
                    {
                        $_POST['zamowienie-typ-dostawy']  = "Kurier DPD";
                    }
                    elseif($_POST['zamowienie-typ-dostawy']  == "Kurier Inpost")
                    {
                        $_POST['zamowienie-typ-dostawy']  = "Kurier Inpost";
                    }
                    elseif($_POST['zamowienie-typ-dostawy']  == "Paczkomaty 24/7 (Inpost)")
                    {
                        $_POST['zamowienie-typ-dostawy']  = "Paczkomaty 24/7 - Inpost";
                    }
                    elseif($_POST['zamowienie-typ-dostawy']  == "Odbiór w punkcie (Poczta polska)")
                    {
                        $_POST['zamowienie-typ-dostawy']  = "Odbiór w punkcie (Poczta polska)";
                    }
                    elseif($_POST['zamowienie-typ-dostawy']  == "Odbiór w sklepie (Księgarnia)")
                    {
                        $_POST['zamowienie-typ-dostawy']  = "Odbiór w sklepie (Księgarnia)";
                    }
                    else {
                        echo '<script>alert("podaj poprawną formę dostawy!")</script>';
                            // header("Locarion: submit_order.php");
                        echo '<script>window.location.href="submit_order.php";</script>';
                        exit();
                    }

                    if($_POST['zamowienie-typ-platnosci'] == "Blik")
                    {
                        $_POST['zamowienie-typ-platnosci'] = "Blik";
                    }
                    elseif($_POST['zamowienie-typ-platnosci'] == "Pobranie")
                    {
                        $_POST['zamowienie-typ-platnosci'] = "Pobranie";
                    }
                    elseif($_POST['zamowienie-typ-platnosci'] == "Karta płatnicza (online)")
                    {
                        $_POST['zamowienie-typ-platnosci'] = "Karta płatnicza (online)";
                    }
                    else {
                        echo '<script>alert("podaj poprawną formę płatności!")</script>';
                            // header("Locarion: submit_order.php");
                        echo '<script>window.location.href="submit_order.php";</script>';
                        exit();
                    }

                        // validate and sanitize user input
                    $forma_dostawy = filter_input(INPUT_POST, 'zamowienie-typ-dostawy', FILTER_SANITIZE_STRING);
                    $forma_platnosci = filter_input(INPUT_POST, 'zamowienie-typ-platnosci', FILTER_SANITIZE_STRING);

                        // echo "<br> forma_dostawy = " .$forma_dostawy. "<br>";
                        // echo "<br> forma_platnosci = " .$forma_platnosci;

                        ////////////////////////////////////////////////////////////////////////////////////////////////////
                    if(!$_SESSION["koszyk_ilosc_ksiazek"] ||
                        $_SESSION["koszyk_ilosc_ksiazek"] == 0) {

                        $_SESSION["order-error"] = true;
                            //header('location: submit_order');
                        echo '<script>window.location.href="submit_order.php";</script>';
                        exit();
                    }
                        ////////////////////////////////////////////////////////////////////////////////////////////////////
                        // $datetime = new DateTime();   // object of DateTime class

                    $datetime = new DateTimeImmutable(); // object of DateTimeImmutable class;
                                                         // values of the object "$datetime" cannot be changed
                                                         // calling methods on the DateTimeImmutable object (e.g. add) - will not change its value (original variable) - unlike DateTime.
                                                                 //$date = $datetime->format('Y-m-d H:i:s');
                                                                 //echo "<br>". $date;
                                                                 //echo "<br>". date('Y-m-d H:i:s');

                                                                 //$date = $data->format('d-m-Y H:i:s');
                                                                 //$datetime = $datetime->format('Y-m-d H:i:s'); // Data i czas serwera
                                                                 // 2022-10-04 13:45:26  <-- Format MySQL'owy
                                                                 //$d = $datetime->format('d');
                                                                 //$m = $datetime->format('m');
                                                                 //$Y = $datetime->format('Y');
                                                                 //$H = $datetime->format('H');
                                                                 //$i = $datetime->format('i');
                                                                 //$s = $datetime->format('s');
                                                                 //$dzisiaj = $d."-".$m."-".$Y." ".$H.":".$i;
                                                                 //$dzisiaj = $Y."-".$m."-".$d." ".$H.":".$i.":".$s;
                                                                 //echo "<br> dzisiaj &rarr; " . $dzisiaj;

                    $data_zlozenia_zamowienia = $datetime->format('Y-m-d H:i:s'); // Server Date and Time - MySQL format

                        // data złożenia zamówienia
                        // echo "<br><br> Data złożenia zamówienia = " . $data_zlozenia_zamowienia ."<br>";

                                                // Termin dostawy
                                                //echo "<br><br> Termin dostawy : " . date('d-m-Y H:i', strtotime($date. ' +5 days'));
                                                //echo "<br><br> Termin dostawy : " . date('Y-m-d ', strtotime($date. ' +5 days'));
                                                //$termin_dostawy = date('d-m-Y H:i', strtotime($date. ' +5 days'));
                                                //$termin_dostawy = date('Y-m-d ', strtotime($date. ' +5 days'));

                    // Termin dostawy
                    // $termin_dostawy = $datetime->add(new DateInterval('P5D'))->format('Y-m-d'); // + 5 days
                    $termin_dostawy = NULL;

                        // $termin_dostawy = $termin_dostawy->format('Y-m-d');
                        // echo "<br> Termin dostawy = " . $termin_dostawy."<br>";    // ('Y-m-d')

                    // data wysłania zamówienia
                    // $data_wyslania_zamowienia = $datetime->add(new DateInterval('P1D'))->format('Y-m-d H:i:s');
                    $data_wyslania_zamowienia = NULL;
                                    // $data_wyslania_zamowienia = $data_wyslania_zamowienia->format('Y-m-d H:i:s');
                                    // echo "<br>Data wysłania zamówienia : " . $data_wyslania_zamowienia;

                    // data dostarczenia zamówienia
                    // $data_dostarczenia_zamowienia = $datetime->add(new DateInterval('P5D'))->format('Y-m-d');
                    $data_dostarczenia_zamowienia = NULL;
                        //echo "<br><br>Data dostarczenia zamówienia : " . $data_dostarczenia_zamowienia;

                        // $status_array = ["W trakcie realizacji", "Wysłano", "Dostarczono", "Zrealizowano/Zakończono"];

                    $status_array = ["Oczekujące na potwierdzenie"]; // working on (testing)
                    $status = $status_array[array_rand($status_array)]; // random status
                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                        // load the content from the external template file into string
                        // $orderDetails = file_get_contents("../template/order-summary.php");

                        // replace fields in $book string to book data from $result, display result content as HTML
                        // echo sprintf($orderDetails, $data_zlozenia_zamowienia, $forma_platnosci, $forma_dostawy);

                        /*echo "<br><br>xxx Forma dostawy = ". $forma_dostawy;
                        echo "<br><br>Status = ". $status;
                        echo "<br><br>Forma płatności = ". $forma_platnosci;
                        echo "<br><br>Suma zamówienia = ". $_SESSION['suma_zamowienia'];*/

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    //$data_platnosci = $datetime->format('Y-m-d H:i:s');
                    $data_platnosci = $data_zlozenia_zamowienia; // Y-m-d H:i:s
                    /* echo "<br><br> Data płatności = " . $data_platnosci ."<br>";*/

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                        /*echo "<br><br> <span><strong><i>id_klienta &rarr;</i></strong></span>" . $_SESSION['id'];
                        echo "<br><span><strong><i>order date &rarr;</i></strong></span>" . $data_zlozenia_zamowienia;
                        echo "<br> <span><strong><i>expected delivery date &rarr;</i></strong></span>" . $termin_dostawy;
                        echo "<br> <span><strong><i>send date &rarr;</i></strong></span>" . $data_wyslania_zamowienia;
                        echo "<br> <span><strong><i>order delivery date &rarr;</i></strong></span>" . $data_dostarczenia_zamowienia;
                        echo "<br> <span><strong><i>form of delivery &rarr;</i></strong></span>" . $forma_dostawy;
                        echo "<br> <span><strong><i>status &rarr;</i></strong></span>" . $status . "<br>";*/

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    // Aktualizacja tabeli --> Zamowienia,  ✓

                    $suma_zamowienia = $_SESSION['suma_zamowienia'];

                    /*echo "<br>id_klienta = " . $_SESSION['id'] . "<br>";*/
                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    // wybierz pracownika z najmniejszą liczbą przypisanych do niego zamówień;
                        //query("SELECT id_pracownika, COUNT(*) AS 'liczba_zamowien' FROM zamowienia GROUP BY id_pracownika ORDER BY liczba_zamowien ASC LIMIT 1", "get_employee_id", ""); // $_SESSION["employee_id"]; // nie działa, jeśli dany pracownik ma 0 przypisanych zamówień;

                    query("SELECT pr.id_pracownika, COUNT(zm.id_zamowienia) as liczba_zamowien FROM pracownicy AS pr LEFT JOIN zamowienia zm ON pr.id_pracownika = zm.id_pracownika GROUP BY pr.id_pracownika ORDER BY liczba_zamowien ASC LIMIT 1", "get_employee_id", ""); // $_SESSION["employee_id"];

                    $id_pracownika = $_SESSION["employee_id"];

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    $order = [$id_klienta, $data_zlozenia_zamowienia, $termin_dostawy, $data_wyslania_zamowienia, $data_dostarczenia_zamowienia, $forma_dostawy, $status, $id_pracownika]; // an array that stores order data informations;

                    query("INSERT INTO zamowienia (id_zamowienia, id_klienta, data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status, id_pracownika) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_order_id", $order); // adds a new order - inserts data into the "orders" table, // gets the ID of the newly added order (row) -> $_SESSION['last_order_id']

                    unset($order);

                        // id of newly inserted row (order id) (order table) :
                        /*echo "<br> last id = " . $_SESSION['last_order_id'] . "<br>";*/

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    // Aktualizacja tabeli --> Płatności  ✓

                    $payment = [$_SESSION['last_order_id'], $data_platnosci, $suma_zamowienia, $forma_platnosci]; // an array that stores payment data related to last order

                    query("INSERT INTO platnosci (id_platnosci, id_zamowienia, data_platnosci, kwota, sposob_platnosci) VALUES (NULL, '%s', '%s', '%s', '%s')", "", $payment);

                    unset($payment);


                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    // Aktualizacja tabeli --> Szczegóły zamówienia  ✓ (na podstawie tabeli KOSZYK)

                    query("SELECT id_klienta, id_ksiazki, ilosc FROM koszyk WHERE id_klienta='%s'", "insert_order_details", $_SESSION['id']); // wstawia dane do tabeli "szczegóły_zamowienia" - na podstawie tabeli koszyk - (zawartości koszyka danego klienta)

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                        /*if(isset($_SESSION['last_order_id']) && !empty( $_SESSION['last_order_id']))
                        {
                            //echo "<br><strong>zamówienie -></strong><br>";

                            $order_id = htmlentities($_SESSION['last_order_id'], ENT_QUOTES, "UTF-8");

                            //query("SELECT id_zamowienia, id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", $_SESSION['last_order_id']);

                            $order_details_books_id = $_SESSION['order_details_books_id'];

                            echo "<br><strong>książki -> </strong><br>";

                            for($i = 0; $i < count($order_details_books_id); $i++)
                            {
                                $book_id = $order_details_books_id[$i];

                                //query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '$book_id'", "order_details_get_book", "$book_id");
                            }

                            unset($_SESSION['last_order_id']);
                            unset($_SESSION['order_details_books_id']);
                            unset($_SESSION['order_details_books_quantity']);
                            unset($_SESSION['suma_zamowienia']);
                        }*/
                }
                else
                {
                    echo "<script>alert('Musisz wybrać typ dostawy i formę płatności !');</script>";
                        // header('Location: submit_order.php');
                    echo '<script>window.location.href="submit_order.php";</script>';
                    exit();
                }

                ?>

            </div>

        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</div>

<script>
    function setSpanWidth() {
        // ten skrypt pobiera maksymalną szerokość spana na stronie, i ustawia szerokość każdego spana na tą wartość
        let spans = document.getElementsByTagName("span"); // you can change it to querySelectorAll
        console.log("spans ->", spans);
        let max_width = 0;
        tab = [];
        for( let i=0; i<spans.length; i++){
            tab.push(spans.item(i).offsetWidth);
        }
        console.log(tab);
        max_width = Math.max(...tab);
        console.log("max ->", max_width);
        for( let i=0; i<spans.length; i++){
            spans.item(i).style.width = max_width + 8 + "px";
            spans.item(i).style.margin = 0;
            spans.item(i).style.display = "inline-block";
            spans.item(i).style.textAlign = "left";
            console.log(i);
        }
    }
    setSpanWidth();

    function clear_result() {
        let result = document.getElementById("result");
        result.innerHTML = "";
    }

    // set #content width to 100% -->
    content = document.getElementById("content");
    content.style.width = "100%";

</script>

</body>
</html>