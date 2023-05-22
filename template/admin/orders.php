
<!-- template used on order page (order.php) to display orders made by client -->

<!-- echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>"; -->

<div class="order order-content" style="border: 3px solid red;">
    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s</div>
    <div class="order-payment">%s</div>
    <div class="order-status">%s</div>
    <div class="order-action">

        <div class="order-action-button" id="order-action-button%s" onclick="showOptions(this.id)">Zarządzaj <i class="icon-down-open"></i></div>

        <div class="order-options-container">
            <div class="order-action-options">
                <div class="order-option">
                    <a href="order-details.php?%s">Przeglądaj</a>
                </div>
                <div class="order-option">
                    <a href="order-details.php?%s&status=true" onclick=""><span style="color: red;">Zmień status</span></a>
                </div>
                <div class="order-option">
                    <a href="#" onclick="removeOrder()"><span style="color: red;">Archiwizuj</span></a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- --- -->

<div id="update-status" class="hidden">

    <h2>Archiwizuj zamówienie</h2>

    <i class="icon-cancel"></i><hr>

    <!--<h4 class="section-header status-title"><label for="status-list">Status:</label></h4>
    <select id="status-list">
        <option>Oczekujące na potwierdzenie</option>
        <option>W trakcie realizacji</option>
        <option>Wysłano</option>
        <option>Dostarczono</option>
    </select>
    <div style="clear: both;"></div>-->

    <!--  form (?) -->

    <div class="delivery-date">
        <form id="remove-order" action="remove-order.php" method="post">
            <!-- <label>
                 <span class="order-label">Termin dostawy</span><input type="date" name="order-date">
             </label>
             <div style="clear: both;"></div>
             <label>
                 <span class="order-label">Data wysłania</span><input type="date" name="dispatch-date">
             </label>
             <div style="clear: both;"></div>
             <label>
                 <span class="order-label">Dostarczono</span><input type="date" name="delivered-date">
             </label>
             <div style="clear: both;"></div>
             <span class="date-error">Podaj poprawną datę</span><div style="clear: both;"></div>-->
            <!--<input type-->

            <span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>
            <textarea name="comment" id="comment"  maxlength="50" minlength="10">
					</textarea> <!-- rows="4" cols="80" -->
            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
        </form>
        <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>
    </div>

</div>


