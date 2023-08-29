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

                echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";

                    query("SELECT zm.id_zamowienia, zm.data_zlozenia_zamowienia, zm.status, zm.termin_dostawy, zm.data_wysłania_zamowienia, zm.data_dostarczenia, zm.komentarz, 
                                  fd.nazwa AS forma_dostawy, 
                                  pl.kwota AS suma, 
                                  mp.nazwa AS sposob_platnosci 
                           FROM zamowienia AS zm, 
                                formy_dostawy AS fd, 
                                platnosci AS pl, 
                                metody_platnosci AS mp 
                           WHERE zm.id_formy_dostawy = fd.id_formy_dostawy AND zm.id_zamowienia = pl.id_zamowienia AND pl.id_metody_platnosci = mp.id_metody_platnosci AND id_klienta = '%s'", "getOrders", $_SESSION['id']);

                    // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia;
                ?>

                <!--<br><br><a href="logout.php">[ Wyloguj ]</a>-->

            </div> <!-- #content -->
        </main>

    </div> <!-- #container -->

    <script>displayNav();</script>

    <?php require "../view/___footer.php"; ?>

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