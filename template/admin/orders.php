
<!-- template used on order page (order.php) to display orders made by client -->

<!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<div class="order order-content">
    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s</div>
    <div class="order-payment">%s</div>
    <div class="order-status%s order-status">%s</div>
    <div class="order-action">

        <div class="order-action-button" id="order-action-button%s" onclick="showOptions(this.id)">Zarządzaj <i class="icon-down-open"></i></div>

        <div class="order-options-container">
            <div class="order-action-options">
                <div class="order-option">
                    <a href="order-details.php?%s">Przeglądaj</a>
                </div>
                <div class="order-option">
                    <a href="order-details.php?%s&status=true" onclick="">Zmień status</a>
                </div>
                <div class="order-option">
                    <a href="#" onclick="removeOrder(%s)">Archiwizuj</a>
                </div>
            </div>
        </div>

    </div>
</div>
