
<!-- // template used on the book page (book.php) to display the book-details -->

<div id="book-page">

    <div id="book-page-image">
        <img src="../assets/books/%s" alt="%s" title="%s"> <!-- $row["image_url"],  $row["tytul"],  $row["tytul"] -->
    </div>

    <div id="book-page-details">

        <div id="book-page-title">
            <span class="book-page-details">Tytuł</span>
            <span id="book-page-details-title">%s</span> <!-- $row["tytul"] -->
        </div>
        <div id="book-page-author">
            <span class="book-page-details">Autor</span>%s %s <!-- $row["imie"], $row["nazwisko"] -->
        </div>
        <div id="book-page-year">
            <span class="book-page-details">Rok wydania</span>%s <!-- $row["rok_wydania"] -->
        </div>

        <!-- (!) -------------------------------------------------------------------------- -->

        <div id="book-page-rate">
            <span id="book-rate" style="display: none;">%s</span> <!-- $row["rating"] - "4" -->

            <div id="rate-container">
                <div class="rate-outer">
                    <div class="rate-inner-base"></div> <!-- pojemnik na Szare gwiazki -->
                    <div class="rate-inner"></div>      <!-- pojemnik na Żółte gwiazdki -->
                </div>
            </div>

            <span class="rating-num" id="rating-num"></span> <!-- JS -> "4" -->
            <span class="rating-num">%s ocen, %s komentarzy</span> <!-- $row["liczba_ocen"], $row["liczba_komentarzy"] -->
        </div>

        <!-- (!) -------------------------------------------------------------------------- -->

        <div id="book-page-publ">
            <span class="book-page-details">Wydawnictwo</span>%s <!-- $row["nazwa_wydawcy"] -->
        </div>
        <div id="book-page-nopg">
            <span class="book-page-details">Ilość stron</span>%s <!-- $row["ilosc_stron"] -->
        </div>

    </div> <!-- #book-page-details -->

    <div id="add-to-cart">

        <span class="book-page-details">Cena</span>
            <span id="book-price">%s</span> PLN <!-- $row["cena"] -->

        <form action="add_to_cart.php" method="post">

            <input type="hidden" name="book-id" value="%s"> <!-- $row["id_ksiazki"] -->

            <label>
                <b>Ilość: </b>
                <input type="text" id="book-amount%s" name="book-amount" value="1"> <!-- $row["id_ksiazki"] -->
            </label>

            <button type="button" data-book-id="%s" class="increase-btn"> <!-- $row["id_ksiazki"] --> <!-- onclick="increase(this, s)" -->
                +
            </button>

            <button type="button" data-book-id="%s" class="decrease-btn"> <!-- $row["id_ksiazki"] --> <!-- onclick="decrease(this, s)" -->
                <span>-</span>
            </button>

                <div style="clear: both;"></div>

            <div id="book-status">
                %s <!-- "dostępna" / "niedostępna" -->
            </div>

            <button type="submit" class="btn-link" %s> <!-- enabled/disabled -->
                Dodaj ko koszyka
            </button> <!-- name="your_name" value="your_value" -->

        </form> <!-- add_to_cart.php -->

    </div> <!-- # add-to-cart -->

    <div style="clear: both;"></div>

    <!--<header><h1>Lorem ipsum</h1></header>-->
    <!--<script src="js/tabs.js"></script>-->

</div>
