
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
        <!--<form method="post" action="../user/___book.php">-->
        <form method="post" action="../user/___book.php">
            <input type="hidden" name="book-id" value="%s"> <!-- $row["id_ksiazki"] -->
            <button type="submit" class="book-img-button">
                <img src="../assets/books/%s" alt="%s" title="%s">
            </button>
        </form>

        <!-- dane o książce -> "tytuł", "cena", "rok_wydania, autor (imie, nazwisko) -->
        <div class="book-description">

            <!-- ✓ ZAMIENIĆ NA FORMULARZ -->
            <!-- <div class="title">
                <a href="___book.php?book=s">
                    s
                </a>
            </div >-->

            <div class="title">
                 <!-- kliknięcie na TYTUŁ książki przechodzi na stronę "book.php" -> (z książką której dane zawarte są w tym formularzu)-->
                <form method="post" action="../user/___book.php">
                    <input type="hidden" name="book-id" value="%s"> <!-- $row["id_ksiazki"] -->
                    <button class="submit-book-form" type="submit">
                        <h3 class="book-title" title="%s">%s</h3>
                    </button>
                </form>
            </div>

            <div class="price"><span id="book-price">%s</span>PLN</div>
            <div class="year">%s</div>
            <div class="author">%s %s</div>
        </div> <!-- .book-description -->

        <div id="form-cart-container" style="min-width: 260px;  float: left; ">

            <!--<form action="change_cart_quantity.php" method="post" class="change_quantity_form" id="change_quantity_form s">-->

            <form action="change_cart_quantity.php" method="post" class="change_quantity_form" id="change_quantity_form%s"> <!-- $row["id_ksiazki"] --> <!-- AJAX -->

                <input type="hidden" name="book-id" data-book-id="%s"> <!-- $row["id_ksiazki"] -->

                <label>
                    <b>Ilość</b>
                    <input type="text" id="book-amount%s" class="book-amount" name="book-amount" value="%s">
                </label>

                <button type="button" data-book-id="%s" class="increase-btn">+</button> <!-- onclick="increase(this, s)" -->
                <button type="button" data-book-id="%s" class="decrease-btn"><span>-</span></button> <!-- onclick="decrease(this, s)" -->

            </form>

            <form action="remove_book.php" method="post" class="remove_book_form">
                           <!-- <input type="hidden" name="id_klienta" value="s">
                            <input type="hidden" name="ilosc" value="s">-->

                <input type="hidden" name="id_ksiazki" value="%s"> <!-- data-book-id --> <!-- $row["id_ksiazki"] -->
                <input type="submit" value="Usuń">
            </form>

        </div>

    </span>

</div>
