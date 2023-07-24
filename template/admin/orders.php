
<!-- template used on order page (order.php) to display ALL orders made by clients (which are assigned to the logged-in employee !) -->

    <!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<!-- // |1121| 2023-07-08 18:23:58 | Jakub | Wojciechowski | 327.75 | Blik     | Zarchiwizowane
     // |1122| 2023-07-08 18:29:20 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
     // |1123| 2023-07-08 18:29:42 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
     // |1125| 2023-07-08 21:25:53 | Jakub | Wojciechowski | 128.3  | Blik     | Oczekujące na potwierdzenie
     // |1126| 2023-07-08 22:25:13 | Adam  | Nowak         | 222.5  | Blik     | Dostarczono
     // |1127| 2023-07-09 16:19:38 | Jakub | Wojciechowski | 377.5  | Blik     | Oczekujące na potwierdzenie
     // |1128| 2023-07-09 21:33:59 | Jakub | Wojciechowski | 279.3  | Pobranie | Zarchiwizowane
     // |1129| 2023-07-10 00:11:49 | Jakub | Wojciechowski | 700    | Blik     | Oczekujące na potwierdzenie
     // |1130| 2023-07-14 03:00:56 | Jakub | Wojciechowski | 1695.5 | Blik     | Oczekujące na potwierdzenie -->

<!-- \admin\orders.php - szablon - pojedynczy wiersz w tabeli "orders" -->

<div class="order order-content">

    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s</div>
    <div class="order-payment">%s</div>
    <div class="order-status%s order-status">%s</div>

    <div class="order-action">

        <div class="order-action-button" id="order-action-button%s" onclick="showOptions(this.id)"> <!-- ✓ wyświetlenie / ukrycie listy opcji -->
            <!-- scripts\show-order-options.js -->
            Zarządzaj <i class="icon-down-open"></i>
        </div>

        <div class="order-options-container">

            <div class="order-action-options hidden">

                <div class="order-option">
                    <!-- <a href="order-details.php? s">Przeglądaj</a> -->
                        <!-- PRG - GET -> na POST <form> <-- ------------------ -->

                    <!--<form method="post" action="order-details.php">
                        <input type="hidden" name="s">
                        <button type="submit" class="book-img-button">
                            <img src="../assets/books/s" alt="s" title="s">
                        </button>
                    </form>-->

                    <form method="post" action="order-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="%s"> <!-- orderId -->
                        <button class="submit-order-form" type="submit">
                            <!--<h3 class="book-title">Przeglądaj</h3>-->
                            Przeglądaj
                        </button>
                    </form>

                </div>

                <div class="order-option">
                    <!--<a href="order-details.php?s status=true" onclick="">Zmień status</a>-->

                    <form method="post" action="order-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="%s"> <!-- orderId -->
                        <input type="hidden" name="true"> <!-- "Zmień status" -> true -->
                        <button class="submit-order-form" type="submit">
                            <!--<h3 class="book-title">Przeglądaj</h3>-->
                            Zmień status
                        </button>
                    </form>

                </div>

                <div class="order-option">    <!-- orderId -->
                    <a href="#" onclick="removeOrder(%s)">Archiwizuj</a> <!-- scripts\remove-order.js -->
                </div>

            </div> <!-- .order-action-options -->

        </div> <!-- .order-options-container -->

    </div> <!-- .order-action -->

</div> <!-- .order order-content -->
