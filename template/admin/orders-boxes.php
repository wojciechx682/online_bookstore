
<!-- template used on order page (order.php) to display orders remove boxes (one for every row) -->

<div class="update-status hidden"> <!-- class -> update-status%s-->
    <!-- id_zamowienia -->

    <h2>Archiwizuj zamówienie</h2>

    <i class="icon-cancel"></i><hr>
    <!-- icon-cancel%s - id_zamowienia -->

    <div class="delivery-date"> <!--  delivery-date%s - id_zamowienia -->

        <form class="remove-order" action="remove-order.php" method="post">

            <input type="hidden" name="order-id" value="%s"> <!-- id_zamówienia (!) -->

            <span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>

            <textarea name="comment" id="comment" class="comment" onfocus="resetError(this)"></textarea> <!-- maxlength="50" minlength="10" -->

            <span class="remove-order-error">Opinia powinna zawierać od 10 do 255 znaków, oraz nie zawierać znaków specjalnych</span>

            <div style="clear: both;"></div>

            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>

        </form>

        <button class="cancel-order update-order-status btn-link btn-link-static">Anuluj</button> <!-- cancel-order%s - id_zamowienia -->

    </div>

</div>





