<!-- (!) template used on book-details page (admin/book-details.php) to display book details page -->

<!-- ---------------------------------------------------------------------------------- -->

<article id="book-details">

    <div id="section-container">
        <figure id="book-details-figure">
            <img src="../assets/books/%s" alt="%s">
        </figure>

        <section id="basic-data">
            <!-- dane podstawowe -->

            <div id="book-title">Tytuł</div> <div id="book-title-content">%s</div> <div style="clear:both;"></div>
            <div id="book-author">Autor</div> <div id="book-author-content">%s %s</div> <div style="clear:both;"></div>
            <div id="book-year">Rok wydania</div> <div id="book-year-content">%s</div> <div style="clear:both;"></div>
            <div id="book-price">Cena</div> <div id="book-price-content">%s</div> <div style="clear:both;"></div>
            <div id="book-publisher">Wydawnictwo</div> <div id="book-publisher-content">%s</div> <div style="clear:both;"></div>

        </section> <!--<div style="clear:both;"></div>-->
    </div>

    <div style="clear:both;"></div>

    <hr id="book-details-hr">

        <!-- dane szczegółowe -->

        <h4 class="section-header">Dane szczegółowe</h4>

    <section id="detailed-information">

        <div id="book-dimensions">Wymiary</div><div id="book-dimensions-content">%s</div> <div style="clear:both;"></div>
        <div id="book-pages">Ilość stron</div><div id="book-pages-content">%s</div> <div style="clear:both;"></div>
        <div id="book-cover">Oprawa</div><div id="book-cover-content">%s</div> <div style="clear:both;"></div>
        <div id="book-state">Stan</div><div id="book-state-content">%s</div> <div style="clear:both;"></div>
        <div id="book-description">Opis</div><div id="book-description-content">%s</div> <div style="clear:both;"></div>


    </section>

    <!--<div style="clear: both;"></div>-->

    <section id="statistics-information">
        <div id="book-category-name">Kategoria</div><div id="book-category-name-content">%s</div> <div style="clear:both;"></div>
        <div id="book-subcategory-name">Podkategoria</div><div id="book-subcategory-name-content">%s</div> <div style="clear:both;"></div>
        <div id="book-avg-rating">Średnia ocen</div><div id="book-avg-rating-content">%s</div> <div style="clear:both;"></div>
        <div id="book-ratings-amount">Liczba ocen</div><div id="book-ratings-amount-content">%s</div> <div style="clear:both;"></div>
        <div id="book-orders-count">Liczba zamówień, w których wystąpiła (conajmniej raz)</div><div id="book-orders-count-content">%s</div> <div style="clear:both;"></div>
        <div id="book-cart-count">Ilość klietnów posiadających w koszyku</div><div id="book-cart-count-content">%s</div> <div style="clear:both;"></div>
        <div id="book-items-sold">Ilość sprzedanych sztuk</div><div id="book-items-sold-content">%s</div> <div style="clear:both;"></div>

    </section>

    <div style="clear: both;"></div>

    Magazyn -->

</article>