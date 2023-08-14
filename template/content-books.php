
<!-- template used on main page (index.php) to display books -->

<div class="outer-book">
    <div class="book" id="book%s">
        <div class="book-cover">
            <!--<a href="../user/___book.php?book=s">
                <img src="../assets/books/s" alt="s" title="s">
            </a>--> <!-- GET -> na POST <form> <-------------------- -->
            <form method="post" action="../user/___book.php">
                <input type="hidden" name="%s"> <!-- id_ksiazki -->
                <button type="submit" class="book-img-button">
                    <img src="../assets/books/%s" alt="%s" title="%s">
                </button>
            </form>
        </div>
        <div class="book-info">
            <!--<a href="../user/___book.php?book">
                <h3 class="book-title">Java - Techniki zaawansowane Wydanie V</h3>
            </a>-->            <!-- GET -> na POST <form> <-------------------- -->
            <!-- ✓✓✓ GET -> na POST <form> - użycie techniki PRG <-------------------- -->
            <form method="post" action="../user/___book.php">
                <input type="hidden" name="%s"> <!-- id_ksiazki -->
                <button class="submit-book-form" type="submit">
                    <h3 class="book-title">%s</h3> <!-- tytuł -->
                </button>
            </form>

            <div class="book-price">%s</div>
            <div class="book-year">%s</div>

            <div class="book-author">%s %s</div>
            <!-- <div class="book-rating">%s</div>-->

            <div class="book-status">%s</div> <!-- "dostępna/niedostępna" -->

            <!--<button class="add-to-cart">Add to Cart</button>-->
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="id_ksiazki" value="%s"> <!-- id_ksiazki -->
                <input type="hidden" name="koszyk_ilosc" class="koszyk_ilosc" value="1">
                <button type="submit" class="btn-link" %s>Dodaj do koszyka</button> <!-- "" / "disabled" -->
            </form>
        </div> <!-- .book-info -->
    </div> <!-- .book #book s -->
</div> <!-- .outer-book -->
