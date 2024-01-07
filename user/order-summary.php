<?php
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

            <!-- <aside> <div id="nav"></div> </aside> -->

            <div id="content" style="width: 100% !important;">

                <h3 id="order-summary-header">Podsumowanie zamówienia</h3>

                <p>Twoje zamówienie zostało przekazane do realizacji, aby śledzić postęp zamówienia przejdź do zakładki <a href="___my_orders.php"><strong>Moje konto / Zamówienia</strong></a></p>

            </div>

        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</div>

</body>
</html>