<?php

    // Uwierzytelnienie administratora, przed dostępem do panelu admina - Czy jest zalogowany ? Czy jest to pracownik ?
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";

    query("SELECT SUM(ilosc_dostepnych_egzemplarzy) AS liczba_ksiazek FROM warehouse_books", "countBooksAvailable", ""); // liczba wszystkich książek (dostępnych na magazynie);


    /*query("SELECT COUNT(id_zamowienia) AS liczba_zamowien FROM zamowienia WHERE status='Oczekujące na potwierdzenie'", "countpendingOrders", ""); // liczba oczekujących zamówień (status = "Oczekujące ...");*/
    query("SELECT COUNT(id_zamowienia) AS liczba_zamowien FROM orders WHERE status='Oczekujące na potwierdzenie' AND id_pracownika='%s'", "countpendingOrders", $_SESSION["id"]); // liczba oczekujących zamówień - przypisanych do tego pracownika; (status = "Oczekujące ...");

    query("SELECT ROUND(SUM(pl.kwota),2) as totalSale
           FROM orders AS zm, payments AS pl 
           WHERE zm.status='Dostarczono' AND zm.id_zamowienia = pl.id_zamowienia", "countTotalSales", ""); // całkowity przychód ze zrealizowanych zamówień;
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<style>
    article#admin-main-page {
        /*border: 1px solid rgba(150, 150, 150, 0.5);*/
        /*overflow: auto;*/
    }
    article#admin-main-page section {
        /*height: 200px;*/
        /* width: 375px;*/
        width: 30%;
        min-width: 320px;
        float: left;
        /*border: 1px solid lightgreen;*/
        margin: 0 15px 15px 0;
        border: 1px solid rgba(150, 150, 150, 0.5);
        border-radius: 5px;
    }
    article#admin-main-page section div.icon-container {
        overflow: auto;
        border: 1px solid white;
        border-radius: 5px;
        width: 105px;
        padding: 10px 6px;
        float: left;
        margin-right: 10px;
    }
    article#admin-main-page section div.section-info {
        /* float: left;*/
        margin-bottom: 16px;
        margin-top: 8px;
    }
    article#admin-main-page section div.section-info a {
        text-decoration: none;
        color: white;
    }
    article#admin-main-page section div.section-info a:hover {
        text-decoration: underline;
        color: #d7d7d7;
    }
    article#admin-main-page section > a {
        text-decoration: none;
        color: white;
    }
    article#admin-main-page section > a:hover div.icon-container {
        color: #d7d7d7;
        border-color: #d7d7d7;
    }
</style>

<body>

    <div id="main-container">

        <div id="container">

            <main>

                <?php require "../template/admin/nav.php"; ?>

                <?php require "../template/admin/top-nav.php"; ?>

                <div id="content">

                    <article id="admin-main-page">
                        <section id="total-books">
                            <a href="books.php">
                                <div class="icon-container">
                                    <i class="icon-book-open"></i>
                                </div>
                            </a>
                            <div class="section-info">
                                <a href="books.php">
                                    Ilość produktów <!-- Liczba książek -->
                                </a>
                            </div>
                            <div class="section-info"><span class="section-info-details"><?= $_SESSION["booksAmount"]; ?></span></div>
                        </section>

                        <section id="pending-orders">
                            <a href="orders.php">
                                <div class="icon-container">
                                    <i class="icon-th-list"></i>
                                </div>
                            </a>
                            <div class="section-info">
                                <a href="orders.php">
                                    Oczekujące zamówienia
                                </a>
                            </div>
                            <div class="section-info"><span class="section-info-details"><?= $_SESSION["pendingOrders"]; ?></span></div>
                        </section>
                        <section id="total-sales">
                            <div class="icon-container">
                                <i class="icon-basket"></i>
                            </div>
                            <div class="section-info">Całkowity przychód</div>
                            <div class="section-info"><span class="section-info-details"><?= empty($_SESSION["totalSale"]) ? "0" : $_SESSION["totalSale"] ?> PLN</span></div>
                        </section>

                    </article>

                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

        <!-- brauke footer'a w tym miejscu ? -->

    </div> <!-- #main-container -->

</body>

</html>