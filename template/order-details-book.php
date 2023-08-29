
<!-- single row (book) in order table that displays book -->    <!-- functions.php -> orderDetailsGetBook() -->

<div style="overflow: auto;">
    <div class="book-no">%s</div>
    <div class="book-url">
            <!--<a href="../user/___book.php?book=& s">
                <img src="../assets/books/& s" alt="book">
            </a>-->
        <form method="post" action="../user/___book.php"> <!-- GET -> na POST <form> - użycie techniki PRG -->
            <input type="hidden" name="book-id" value="%s">
            <button type="submit" class="book-img-button">
                <img src="../assets/books/%s" alt="%s" title="%s">
            </button>
        </form>
    </div>

    <div class="book-desc">
        <!--<span class="order-book-desc-row"><strong>%s</strong></span>-->
        <form method="post" action="___book.php">
            <input type="hidden" name="book-id" value="%s"> <!-- id_ksiazki -->
            <button class="submit-book-form" type="submit">
                <h3 title="%s">%s</h3> <!-- tytuł -->
            </button>
        </form>
        <span class="order-book-desc-row">Autor - %s %s</span>
        <span class="order-book-desc-row">Rok wydania - %s</span>
    </div>

    <div class="book-quan book-quan%s"> <!-- 1, 2, ... -->
        <span class="order-book-desc-row">Ilość</span>
        <div style="margin: 0 auto; text-align: center; padding-top: 50px;">%s</div> <!-- bookQuantity -->
    </div>

    <div class="order-book-price order-book-price%s">
        <span class="order-book-price-row">Cena</span>
        <div style="margin: 0 auto; text-align: center; padding-top: 50px;">%s PLN</div>
    </div>
</div>

<hr>
