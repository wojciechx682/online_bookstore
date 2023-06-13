<!-- template used on order page (order.php) to display orders made by client -->

<!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<div class="admin-books admin-books-content"> <!-- (?) admin-books ? -->
    <div class="a-book-id">%s</div>
    <div class="a-book-title">%s</div>
    <div class="a-book-category">%s</div>
    <div class="a-book-price">%s</div>
    <div class="a-book-author">%s %s</div>
    <div class="a-book-magazine">%s</div>
    <div class="a-book-quantity">%s</div>

    <div class="book-action">

        <div class="book-action-button" id="book-action-button%s" onclick="showBooksOptions(this.id)">Zarządzaj <i class="icon-down-open"></i></div>

        <div class="book-options-container">
            <div class="book-action-options">
                <div class="book-option">
                    <a href="book-details.php?book=%s&warehouse=%s">Przeglądaj</a>
                </div>
                <div class="book-option">
                    <a href="edit-book.php?book-id=%s" onclick="">Edytuj</a>
                </div>
                <div class="book-option">
                    <a href="#" onclick="removeOrder(%s)">Usuń</a>
                </div>
            </div>
        </div>
    </div>

</div>
