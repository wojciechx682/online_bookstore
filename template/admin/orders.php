<div class="order order-content">

    <div class="order-id">%s</div>
    <div class="order-date">%s</div>
    <div class="order-client">%s %s</div>
    <div class="order-total-sum">%s PLN</div>
    <div class="order-payment">%s</div>
    <div class="order-status%s order-status">%s</div> <!-- order-id -->

    <div class="order-action">

        <div class="order-action-button" id="order-action-button%s" onclick="showOptions(this.id)">
            Zarządzaj <i class="icon-down-open"></i>
        </div>

        <div class="order-options-container">

            <div class="order-action-options hidden">

                <div class="order-option">

                    <form method="post" action="order-details.php">
                        <input type="hidden" name="order-id" value="%s">
                        <button class="submit-order-form" type="submit">
                            Przeglądaj
                        </button>
                    </form>

                </div>

                <div class="order-option">

                    <form method="post" action="order-details.php">
                        <input type="hidden" name="order-id" value="%s">
                        <input type="hidden" name="change-status" value="true">
                        <button class="submit-order-form" type="submit">
                            Zmień status
                        </button>
                    </form>

                </div>

                <div class="order-option">
                    <a href="#" onclick="removeOrder(%s)">Archiwizuj</a>
                </div>

            </div>

        </div>

    </div>

</div>
