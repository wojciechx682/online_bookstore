<?php

	/*session_start();
	include_once "../functions.php";
    if( ! isset($_SESSION['zalogowany']) ) {

        $_SESSION["login-error"] = true;
            header("Location: ___zaloguj.php");
                exit();
    }*/

    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
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
            <aside class="account-data"> <!-- lewy nav-bar -->
                <div id="nav">
                            <!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->
                    <!--<a href="___account.php"> ← </a><br><br>
                    <a href="___my_orders.php">Zamówienia</a>-->

                    <a href="___my_orders.php"><h3>Zamówienia</h3><hr></a>
                    <a href="___account.php"><h3>Edytuj dane użytkownika</h3><hr></a>
                    <a href="___remove_account.php"><h3>Usuń konto</h3><hr></a>
                    <a href="logout.php"><h3>Wyloguj</h3><hr></a>

                </div> <!-- #nav -->
            </aside> <!-- .account-data (lewy nav-bar) -->

            <div id="content">

                <h3 class="account-header">Historia zamówień</h3> <!-- <h3>Zamówienia</h3><hr> -->

                <?php
                    echo '<script> displayNav(); </script>';

                    query("SELECT id_zamowienia, data_zlozenia_zamowienia, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, fd.nazwa, komentarz FROM zamowienia, formy_dostawy AS fd WHERE zamowienia.id_formy_dostawy = fd.id_formy_dostawy AND id_klienta = '%s'", "get_orders", $_SESSION['id']); // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia;
                ?>

                <!--<br><br><a href="logout.php">[ Wyloguj ]</a>-->

            </div> <!-- #content -->
        </main>

    </div> <!-- #container -->

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