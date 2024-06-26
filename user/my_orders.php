<?php
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <?php require "../view/account-nav.php"; ?>

            <div id="content">

                <h3 class="account-header">Historia zamówień</h3>

                <?php

                    query("SELECT zm.id_zamowienia, zm.data_zlozenia_zamowienia, zm.status, zm.termin_dostawy, zm.data_wysłania_zamowienia, zm.data_dostarczenia, zm.komentarz, 
                                  fd.nazwa AS forma_dostawy, fd.cena AS koszt_dostawy, 
                                  pl.kwota AS suma, 
                                  mp.nazwa AS sposob_platnosci, mp.oplata AS koszt_platnosci
                           FROM orders AS zm, 
                                delivery_methods AS fd, 
                                payments AS pl, 
                                payment_methods AS mp 
                           WHERE zm.id_formy_dostawy = fd.id_formy_dostawy AND zm.id_zamowienia = pl.id_zamowienia AND pl.id_metody_platnosci = mp.id_metody_platnosci AND id_klienta = '%s'", "getOrders", $_SESSION['id']);

                    // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia;

                        // id_zamowienia            - 1263
                        // data_zlozenia_zamowienia - 2023-08-29 14:32:31
                        // status                   - Oczekujące na potwierdzenie
                        // termin_dostawy           - 0000-00-00
                        // data_wysłania_zamowienia - 0000-00-00 00:00:00
                        // data_dostarczenia        - 0000-00-00
                        // komentarz                - ""
                        // forma_dostawy            - Kurier DPD
                        // suma                     - 301.65
                        // sposob_platnosci         - Blik
                ?>

            </div>

        </main>

    </div>

    <script>displayNav();</script>

    <?php require "../view/footer.php"; ?>

</div>

<script>

    content = document.getElementById("content");
    content.style.overflow = "auto";

    // set order status "Zarchiwizowane" text-color to green;

    let orderStatus = document.querySelectorAll('div.order div.order-status');

    console.log("\n\norder-status -> ", orderStatus);
    console.log("\n\norder-status -> ", typeof orderStatus);

    for(let i=0; i<orderStatus.length; i++) {
        if(orderStatus[i].innerHTML == "Zarchiwizowane") {
            orderStatus[i].style.color = "#cb2f2f";
            orderStatus[i].style.fontWeight = "bold";
        }
    }

</script>

</body>
</html>