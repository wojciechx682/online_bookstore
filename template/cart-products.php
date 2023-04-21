
<? // template used on the cart page (cart.php) to display the products currently in the cart of a given customer ?>

<div id="book%s" class="cart-book">
    <span class="book-details">

        <a href="___book.php?book=%s">
            <img src="../assets/books/%s" alt="%s" title="%s">
        </a>

        <div class="book-description">
            <div class="title">
                <a href="___book.php?book=%s">
                    %s
                </a>
            </div>
            <div class="price">%s</div>
            <div class="year">%s</div>
            <div class="author">%s %s</div>
        </div>


        <form class="change_quantity_form" id="change_quantity_form%s" action="change_cart_quantity.php" method="post">
            <input type="hidden" name="id_ksiazki" value="%s">
            <b>Ilość</b>
            <input type="text" id="koszyk_ilosc%s" class="koszyk_ilosc" name="koszyk_ilosc" value="%s">
            <button type="button" onclick="increase(%s)">+</button>
            <button type="button" onclick="decrease(%s)"><span>-</span></button>
        </form>

        <form class="remove_book_form" action="remove_book.php" method="post">
            <input type="hidden" name="id_klienta" value="%s">
            <input type="hidden" name="id_ksiazki" value="%s">
            <input type="hidden" name="ilosc" value="%s">
            <input type="submit" value="Usuń">
        </form>

    </span>

</div>
