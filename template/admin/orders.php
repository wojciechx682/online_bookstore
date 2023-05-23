
<!-- template used on order page (order.php) to display orders made by client -->

<!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<div class="order order-content" style="border: 3px solid red;">
    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s</div>
    <div class="order-payment">%s</div>
    <div class="order-status">%s</div>
    <div class="order-action">

        <div class="order-action-button" id="order-action-button%s" onclick="showOptions(this.id)">Zarządzaj <i class="icon-down-open"></i></div>

        <div class="order-options-container">
            <div class="order-action-options">
                <div class="order-option">
                    <a href="order-details.php?%s">Przeglądaj</a>
                </div>
                <div class="order-option">
                    <a href="order-details.php?%s&status=true" onclick=""><span style="color: red;">Zmień status</span></a>
                </div>
                <div class="order-option">
                    <a href="#" onclick="removeOrder(%s)"><span style="color: red;">Archiwizuj</span></a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- --------------------------------------------------------------------------------------------------------------- -->

<div class="update-status%s hidden">

    <h2>Archiwizuj zamówienie</h2>

    <i class="icon-cancel icon-cancel%s"></i><hr>

    <div class="delivery-date">
        <form class="remove-order" action="remove-order.php" method="post">

            <input type="hidden" name="order-id" value="%s">

            <span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>
            <textarea name="comment" id="comment"  maxlength="50" minlength="10">
					</textarea>
            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
        </form>
        <button class="update-order-status cancel-order cancel-order%s btn-link btn-link-static">Anuluj</button>
    </div>

</div>





