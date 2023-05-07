
<!-- template used on order page (order.php) to display orders made by client -->

<!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<div class="order order-content">
    <div class="order-det-lp">%s</div>
    <div class="order-det-product">%s</div>
    <div class="order-det-quan">%s</div>
    <div class="order-det-price">%s</div>

    <div style="clear:both;"></div>
</div>
