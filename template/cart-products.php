<div id="book%s" class="cart-book">

    <span class="book-details">
        <form method="post" action="../user/book.php">
            <input type="hidden" name="book-id" value="%s">
            <button type="submit" class="book-img-button">
                <img src="../assets/books/%s" alt="%s" title="%s">
            </button>
        </form>
        <div class="book-description">


            <div class="title">

                <form method="post" action="../user/book.php">
                    <input type="hidden" name="book-id" value="%s">
                    <button class="submit-book-form" type="submit">
                        <h3 class="book-title" title="%s">%s</h3>
                    </button>
                </form>
            </div>

            <div class="price"><span id="book-price">%s</span>PLN</div>
            <div class="year">%s</div>
            <div class="author">%s %s</div>
            <div class="cart-category">%s, %s</div>
        </div>

        <div id="form-cart-container" style="min-width: 260px;  float: left; ">

            <form action="change_cart_quantity.php" method="post" class="change_quantity_form" id="change_quantity_form%s">

                <input type="hidden" name="book-id" data-book-id="%s">

                <label>
                    <b>Ilość</b>
                    <input type="text" id="book-amount%s" class="book-amount" name="book-amount" value="%s">
                </label>

                <button type="button" data-book-id="%s" class="increase-btn">+</button>
                <button type="button" data-book-id="%s" class="decrease-btn"><span>-</span></button>

            </form>

            <form action="remove_book.php" method="post" class="remove_book_form">

                <input type="hidden" name="id_ksiazki" value="%s">
                <input type="submit" value="Usuń">
            </form>

        </div>

    </span>

</div>
