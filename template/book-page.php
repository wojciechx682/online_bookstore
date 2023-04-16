
<? // template used on the book page (book.php) to display the book details ?>

<div id="book-page">

    <div id="book-page-image">
        <img src="../assets/books/%s" alt="%s" title="%s">
    </div>
    <div id="book-page-details">
        <div id="book-page-title">
            <span class="book-page-details">Tytuł</span>%s</div>
        <div id="book-page-author">
            <span class="book-page-details">Autor</span>%s %s</div>
        <div id="book-page-year"><span class="book-page-details">Rok wydania</span>%s</div>
        <div id="book-page-rate">
            <span id="book-rate" style="display:   none;">%s</span>

            <div id="rate-container">
                <div class="rate-outer">
                    <div class="rate-inner-base"></div>
                    <div class="rate-inner"></div>
                </div>
            </div>
            <span class="rating-num" id="rating-num"></span>
            <span class="rating-num">%s ocen, %s komentarzy</span>
        </div>

        <div id="book-page-publ"><span class="book-page-details">Wydawnictwo</span>%s</div>
        <div id="book-page-nopg"><span class="book-page-details">Ilość stron</span>%s</div>



    </div>

    <div id="add-to-cart">

        <span class="book-page-details">Cena</span>%s



        <form action="add_to_cart.php" method="post">
            <input type="hidden" name="id_ksiazki" value="%s"> <!-- id książki -->

            <b>Ilosc: </b>
            <input type="text" id="koszyk_ilosc%s" name="koszyk_ilosc" value="1">
            <button type="button" onclick="increase(%s)">+</button>
            <button type="button" onclick="decrease(%s)"><span>-</span></button>
            <div style="clear: both;"></div>
            <div id="book-status">
                %s
            </div>

            <button type="submit" name="your_name" value="your_value" class="btn-link" %s>Dodaj ko koszyka</button>
        </form>










    </div>

    <div style="clear: both;"></div>
    <!--<header><h1>Lorem ipsum</h1></header>-->
    <!--<script src="js/tabs.js"></script>-->
</div>
