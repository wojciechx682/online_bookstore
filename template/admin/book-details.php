<!-- (!) template used on book-details page (admin/book-details.php) to display book details page -->

<!-- ---------------------------------------------------------------------------------- -->

<form action="edit-book.php" method="post">
    <input type="hidden" name="book-id" value="%s">
    <input type="hidden" name="warehouse-id" value="%s">
    <button class="edit-book-details-btn btn-link btn-link-static">Edytuj</button>
</form>



<article id="book-details">

    <div id="section-container">
        <figure id="book-details-figure">
            <img src="../assets/books/%s" alt="%s" title="%s">
        </figure>

        <section id="basic-data">
            <!-- dane podstawowe -->

            <div id="book-title">Tytuł</div> <div id="book-title-content">%s</div> <div style="clear:both;"></div>
            <div id="book-author">Autor</div> <div id="book-author-content">%s %s</div> <div style="clear:both;"></div>
            <div id="book-year">Rok wydania</div> <div id="book-year-content">%s</div> <div style="clear:both;"></div>
            <div id="book-price">Cena</div> <div id="book-price-content">%s PLN</div> <div style="clear:both;"></div>
            <div id="book-publisher">Wydawnictwo</div> <div id="book-publisher-content">%s</div> <div style="clear:both;"></div>
            <div id="book-category-name">Kategoria</div><div id="book-category-name-content">%s</div> <div style="clear:both;"></div>
            <div id="book-subcategory-name">Podkategoria</div><div id="book-subcategory-name-content">%s</div> <div style="clear:both;"></div>
        </section> <div style="clear:both;"></div>
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
        <!--<div id="book-category-name">Kategoria</div><div id="book-category-name-content">s</div> <div style="clear:both;"></div>
        <div id="book-subcategory-name">Podkategoria</div><div id="book-subcategory-name-content">s</div> <div style="clear:both;"></div>-->
        <div id="book-avg-rating">Średnia ocen</div><div id="book-avg-rating-content">%s</div> <div style="clear:both;"></div>
        <div id="book-ratings-amount">Liczba ocen</div><div id="book-ratings-amount-content">%s</div> <div style="clear:both;"></div>
        <div id="book-orders-count">Liczba zamówień, w których wystąpiła <del>(conajmniej raz)</del></div><div id="book-orders-count-content">%s</div> <div style="clear:both;"></div>
        <div id="book-cart-count">Ilość klietnów posiadających w koszyku</div><div id="book-cart-count-content">%s</div> <div style="clear:both;"></div>
        <div id="book-items-sold">Ilość sprzedanych sztuk</div><div id="book-items-sold-content">%s</div> <div style="clear:both;"></div>
    </section>

    <div style="clear: both;"></div>

    <section id="warehouse-information">
        <div id="warehouse-name">Nazwa magazynu</div>
            <div id="warehouse-name-content">%s</div>
            <div style="clear:both;"></div>

        <div id="warehouse-location-name">Lokalizacja</div>
            <div id="warehouse-location-name-content-country">%s - %s</div>
            <!--<div id="warehouse-location-name-content-province">(województwo)</div>-->
            <div style="clear:both;"></div>

        <div id="warehouse-address">Adres</div>
            <div id="warehouse-address-content-city">%s, %s %s</div>
            <!--<div id="warehouse-address-content-street"></div>-->
            <div style="clear:both;"></div>

        <div id="warehouse-post-code">Kod pocztowy</div>
            <div id="warehouse-post-code-content">%s, %s</div>
            <div style="clear:both;"></div>

        <div id="warehouse-number-of-books-available">Ilość dostępnych egzemplarzy</div>
            <div id="warehouse-number-of-books-available-content">%s</div>
            <div style="clear:both;"></div>

    </section>

</article>