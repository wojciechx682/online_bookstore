
<!-- template used on order page (order.php) to display orders remove boxes (one for every row) -->

<div class="update-status%s update-status hidden">

    <h2>Archiwizuj zamówienie</h2>

    <i class="icon-cancel icon-cancel%s"></i><hr>

    <div class="delivery-date delivery-date%s">
        <form class="remove-order" action="remove-order.php" method="post">

            <input type="hidden" name="order-id" value="%s"> <!-- id_zamówienia (!) -->

            <span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>

            <textarea name="comment" id="comment" class="comment" onfocus="resetError(this)"></textarea> <!-- maxlength="50" minlength="10" -->

            <span class="remove-order-error">Opinia powinna zawierać od 10 do 255 znaków, oraz nie zawierać znaków specjalnych</span><div style="clear: both;"></div>

            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
        </form>
        <button class="cancel-order cancel-order%s update-order-status btn-link btn-link-static">Anuluj</button>

    </div>

</div>





