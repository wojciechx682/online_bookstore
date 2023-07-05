
<!-- template used on the cart page (cart.php) to display the products currently in the cart of a given customer -->

<div id="book%s" class="cart-book">

    <span class="book-details">

        <!--<a href="___book.php?book=s">
            <img src="../assets/books/s" alt="s" title="s">
        </a>-->

        <!-- ✓✓✓ GET -> na POST <form> - użycie techniki PRG <-------------------- -->
        <!--<form method="post" action="../user/___book.php">
            <input type="hidden" name=" s">
            <button class="submit-book-form" type="submit"><h3 class="book-title">s</h3></button>
        </form>-->

            <!-- kliknięcie na obrazek przechodzi na stronę "book.php" -> (z książką której dane zawarte są w tym formularzu)-->
        <form method="post" action="../user/___book.php">
            <input type="hidden" name="%s"> <!-- id_ksiazki -->
            <button type="submit" class="book-img-button">
                <img src="../assets/books/%s" alt="%s" title="%s">
            </button>
        </form>

            <!-- dane o książce -> "tytuł", "cena", "rok_wydania, autor (imie, nazwisko) -->
        <div class="book-description" >

            <!-- ✓ ZAMIENIĆ NA FORMULARZ -->
            <!-- <div class="title">
                <a href="___book.php?book=s">
                    s
                </a>
            </div >-->

            <div class="title">
                 <!-- kliknięcie na TYTUŁ książki przechodzi na stronę "book.php" -> (z książką której dane zawarte są w tym formularzu)-->
                <form method="post" action="../user/___book.php">
                    <input type="hidden" name="%s"> <!-- id_ksiazki -->
                    <button class="submit-book-form" type="submit">
                        <h3 class="book-title">%s</h3>
                    </button>
                </form>
            </div>

            <div class="price">%s  PLN</div>
            <div class="year">%s</div>
            <div class="author">%s %s</div>
        </div> <!-- .book-description -->

        <form action="change_cart_quantity.php" method="post"
              class="change_quantity_form" id="change_quantity_form%s">

            <input type="hidden" name="id_ksiazki" value="%s"> <!-- id_ksiazki -->
            <b>Ilość</b>
            <input type="text" id="koszyk_ilosc%s" class="koszyk_ilosc" name="koszyk_ilosc" value="%s">
            <button type="button" onclick="increase(%s)">+</button>
            <button type="button" onclick="decrease(%s)"><span>-</span></button>
        </form>

    <form action="remove_book.php" method="post"
                                   class="remove_book_form">
                   <!-- <input type="hidden" name="id_klienta" value="s">
                    <input type="hidden" name="ilosc" value="s">-->

        <input type="hidden" name="id_ksiazki" value="%s">
        <input type="submit" value="Usuń">
    </form>

    </span>

</div>
