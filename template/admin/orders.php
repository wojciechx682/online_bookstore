
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
    <div class="order-total-sum">%s PLN</div>
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

                    <form method="post" action="order-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="order-id" value="%s">  <!-- order-id -->
                        <button class="submit-order-form" type="submit">
                            Przeglądaj
                        </button>
                    </form>

                </div>

                <div class="order-option">

                    <form method="post" action="order-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="order-id" value="%s"> <!-- order-id -->
                        <input type="hidden" name="change-status" value="true"> <!-- "Zmień status" -> true -->
                        <button class="submit-order-form" type="submit">
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
