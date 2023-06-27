
<!-- template used on main page (index.php) to display books -->

<div class="outer-book">
    <div class="book" id="book%s">
        <div class="book-cover">
            <a href="../user/___book.php?book=%s">        <!-- GET -> na POST <form> <-------------------- -->
                <img src="../assets/books/%s" alt="%s" title="%s">
            </a>
        </div>
        <div class="book-info">

            <a href="../user/___book.php?book">        <!-- GET -> na POST <form> <-------------------- -->
                <h3 class="book-title">Java - Techniki zaawansowane Wydanie V</h3>
            </a>

            <!-- ✓✓✓ GET -> na POST <form> <-------------------- -->
            <form method="post" action="../user/___book.php">
                <input type="hidden" name="%s">
                <button id="submit-book-form" type="submit">aaa<h3 class="book-title">%s</h3></button>
            </form>

            <div class="book-price">%s</div>
            <div class="book-year">%s</div>

            <div class="book-author">%s %s</div>
            <!-- <div class="book-rating">%s</div>-->

            <!--<button class="add-to-cart">Add to Cart</button>-->
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="id_ksiazki" value="%s"> <!-- <-------------------- -->
                <input type="hidden" name="koszyk_ilosc" class="koszyk_ilosc"  value="1">
                <button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>
            </form>
        </div>
    </div>
</div>
