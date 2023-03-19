
<? // template used on the book page (book.php) to display the book details ?>

<div id="book-page">

    <div id="book-page-image">
        <img src="../assets/books/%s" alt="%s" title="%s">
    </div>
    <div id="book-page-details">
        <div id="book-page-title">Tytuł - %s</div>
        <div id="book-page-author">Autor - %s %s</div>
        <div id="book-page-year">Rok wydania - %s</div>
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

        <div id="book-page-publ">Wydawnictwo - %s</div>
        <div id="book-page-nopg">ilość stron - %s</div>

    </div>
    <div style="clear: both;"></div>
    <!--<header><h1>Lorem ipsum</h1></header>-->
    <!--<script src="js/tabs.js"></script>-->
</div>
