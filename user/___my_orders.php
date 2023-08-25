<?php
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

<?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <?php require "../view/account-nav.php"; ?>

            <div id="content">

                <h3 class="account-header">Historia zamówień</h3> <!-- <h3>Zamówienia</h3><hr> -->

                <?php

                    query("SELECT id_zamowienia, data_zlozenia_zamowienia, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, fd.nazwa, komentarz FROM zamowienia, formy_dostawy AS fd WHERE zamowienia.id_formy_dostawy = fd.id_formy_dostawy AND id_klienta = '%s'", "getOrders", $_SESSION['id']); // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia;
                ?>

                <!--<br><br><a href="logout.php">[ Wyloguj ]</a>-->

            </div> <!-- #content -->
        </main>

    </div> <!-- #container -->

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
            orderStatus[i].style.color = "#30af30";
            orderStatus[i].style.fontWeight = "bold";
        }
    }

</script>

</body>
</html>