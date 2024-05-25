
<!-- template used on order page (admin\orders.php) to display orders remove box ( ̶o̶n̶e̶ ̶f̶o̶r̶ ̶e̶v̶e̶r̶y̶ ̶r̶o̶w̶ ) -->

<div class="update-status hidden"> <!-- class -> update-status%s--> <!-- id_zamowienia -->

    <h2>Archiwizuj zamówienie</h2>

    <i class="icon-cancel"></i><hr>

    <div class="delivery-date hidden">

        <form class="remove-order" action="remove-order.php" method="post">

            <input type="hidden" name="order-id" value="%s"> <!-- order-id -->

            <span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>

            <textarea name="comment" id="comment" class="comment" onfocus="resetError(this)" maxlength="255"></textarea> <!-- minlength="10" maxlength="255" -->

            <span class="remove-order-error hidden">
                Opinia powinna zawierać od 10 do 255 znaków, oraz nie zawierać znaków specjalnych
            </span>

            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>

        </form>

        <button class="cancel-order update-order-status btn-link btn-link-static">Anuluj</button>

    </div> <!-- .delivery-date -->

</div> <!-- .update-status -->





