<div id="book%s" class="book">
    <div class="title">%s</div><br>
    <div class="price">%s</div><br>
    <div class="year">%s</div><br>
    <form action="add_to_cart.php" method="post">
        <input type="hidden" name="id_ksiazki" value="%s">
        <input type="hidden" name="koszyk_ilosc" id="koszyk_ilosc"  value="1">
        <button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>
    </form>
</div>

<? // template used on main page (index.php) to display books ?>