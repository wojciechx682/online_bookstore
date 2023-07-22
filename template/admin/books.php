<!-- template used on books page (book.php) to display books; -->

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
            <div class="book-action-options hidden">
                <div class="book-option">
                    <a href="book-details.php?book=%s&warehouse=%s">Przeglądaj</a>
                </div>
                <div class="book-option">

                    <form action="edit-book.php" method="post">
                            <input type="hidden" value="%s" name="book-id">
                        <!--<label for="submit-form">Edytuj</label>-->
                        <input type="submit" value="Edytuj"> <!-- id="submit-form" -->
                    </form>

                </div>
                <div class="book-option">
                    <a href="#" onclick="removeOrder(%s)">Usuń</a>
                </div>
            </div>
        </div>
    </div>

</div>
