
<!-- template used on order page (admin\orders.php) to display ALL orders made by clients (which are assigned to the logged-in employee !) -->

<!-- // | 1121 | 2023-07-08 18:23:58 | Jakub | Wojciechowski | 327.75 | Blik     | Zarchiwizowane
     // | 1122 | 2023-07-08 18:29:20 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
     // ...
     // ... -->

<!-- \admin\orders.php - szablon - pojedynczy wiersz w tabeli "orders" -->

<div class="order order-content">

    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s</div>
    <div class="order-payment">%s</div>
    <div class="order-status%s order-status">%s</div> <!-- order-id -->

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
                        <input type="hidden" name="%s"> <!-- order-id -->
                        <button class="submit-order-form" type="submit">
                                <!--<h3 class="book-title">Przeglądaj</h3>-->
                            Przeglądaj
                        </button>
                    </form>

                </div>

                <div class="order-option">
                    <!--<a href="order-details.php?s status=true" onclick="">Zmień status</a>-->

                    <form method="post" action="order-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="%s"> <!-- order-id -->
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
