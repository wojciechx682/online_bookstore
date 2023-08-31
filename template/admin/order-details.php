
<!-- template used on order page (order-details.php) to display orders details made by client -->

<div class="order order-content">
    <div class="order-det-lp">%s</div>
    <div class="order-det-product">
            <!--<span>s</span>--> <!-- ks.tytul -->
            <!--<span>s</span>--> <!-- id_ksiazki -->
        <form method="post" action="book-details.php">
            <input type="hidden" name="book-id" value="%s">
            <input type="hidden" name="warehouse-id" value="%s">
            <button class="submit-book-form" type="submit">
                <h3 title="%s">%s</h3>
            </button>
        </form>
        <span>%s %s, %s</span> <!-- au.imie, au.nazwiskom, ks.rok_wydania -->
    </div>
    <div class="order-det-quan">%s</div>
    <div class="order-det-price">%s PLN</div>
        <!--<div style="clear:both;"></div>-->
</div>
