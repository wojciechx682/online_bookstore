
<!-- // template used on the book page (book.php) to display the book details -->

<div id="book-page">

    <div id="book-page-image">
        <img src="../assets/books/%s" alt="%s" title="%s">
    </div>

    <div id="book-page-details">

        <div id="book-page-title">
            <span class="book-page-details">Tytuł</span>
            <span id="book-page-details-title">%s</span>
        </div>
        <div id="book-page-author">
            <span class="book-page-details">Autor</span>%s %s
        </div>
        <div id="book-page-year">
            <span class="book-page-details">Rok wydania</span>%s
        </div>

        <div id="book-page-rate">
            <span id="book-rate" style="display: none;">%s</span> <!-- $row["rating"] -->

            <div id="rate-container">
                <div class="rate-outer">
                    <div class="rate-inner-base"></div> <!-- pojemnik na Szare gwiazki -->
                    <div class="rate-inner"></div>      <!-- pojemnik na Żółte gwiazdki -->
                </div>
            </div>
            <span class="rating-num" id="rating-num"></span>
            <span class="rating-num">%s ocen, %s komentarzy</span>
        </div>

        <div id="book-page-publ">
            <span class="book-page-details">Wydawnictwo</span>%s
        </div>
        <div id="book-page-nopg">
            <span class="book-page-details">Ilość stron</span>%s
        </div>

    </div> <!-- #book-page-details -->

    <div id="add-to-cart">

        <span class="book-page-details">Cena</span>%s PLN

        <form action="add_to_cart.php" method="post">

            <input type="hidden" name="id_ksiazki" value="%s"> <!-- id książki -->

            <label>
                <b>Ilość: </b>
                <input type="text" id="koszyk_ilosc%s" name="koszyk_ilosc" value="1"> <!-- id = " koszyk_ilosc { id książki } " -->
            </label>

            <button type="button" onclick="increase(this, %s)"> <!-- id książki -->
                +
            </button>

            <button type="button" onclick="decrease(this, %s)"> <!-- id książki -->
                <span>-</span>
            </button>

                <div style="clear: both;"></div>

            <div id="book-status">
                %s
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
