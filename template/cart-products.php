<div id="book%s"> <span class="book-details">
	<div class="title">%s</div>
	<div class="price">%s</div>
    <div class="year">%s</div></span>

	<form class="change_quantity_form" id="change_quantity_form%s" action="change_cart_quantity.php" method="post">
		<input type="hidden" name="id_ksiazki" value="%s">
		<b>Ilosc: </b>
		<input type="text" id="koszyk_ilosc%s" name="koszyk_ilosc" value="%s">
		<button type="button" onclick="increase(%s)">+</button>
		<button type="button" onclick="decrease(%s)">-</button>
	</form>

	<form id="remove_book_form" action="remove_book.php" method="post">
		<input type="hidden" name="id_klienta" value="%s">
		<input type="hidden" name="id_ksiazki" value="%s">
		<input type="hidden" name="ilosc" value="%s">
		<input type="submit" value="Usuń">
	</form>

	<br><hr><br>
</div>

<? // template used on the cart page (cart.php) to display the products currently in the cart of a given customer ?>