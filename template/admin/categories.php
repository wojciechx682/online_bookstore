
<div class="category category-content">

    <div class="category-id">%s</div>
    <div class="category-name">%s</div>

    <div class="category-action">

        <div class="category-action-button" id="category-action-button%s" onclick="showCategoryOptions(this.id)">
            <!-- ✓ wyświetlenie / ukrycie listy opcji -->
            <!-- scripts\show-order-options.js -->
            Zarządzaj <i class="icon-down-open"></i>
        </div>

        <div class="category-options-container">

            <div class="category-action-options hidden">

                <div class="category-option">
                    <!-- <a href="order-details.php? s">Przeglądaj</a> -->
                    <!-- PRG - GET -> na POST <form> <-- ------------------ -->

                    <!--<form method="post" action="order-details.php">
                        <input type="hidden" name="s">
                        <button type="submit" class="book-img-button">
                            <img src="../assets/books/s" alt="s" title="s">
                        </button>
                    </form>-->

                    <form method="post" action="edit-category.php"> <!-- POST -> category -->
                        <input type="hidden" name="category-id" value="%s"> <!-- category-id -->
                        <input type="hidden" name="category-name" value="%s"> <!-- category-name -->
                        <button class="submit-order-form" type="submit">
                            <!--<h3 class="book-title">Przeglądaj</h3>-->
                            Edytuj
                        </button>
                    </form>

                </div>

                <div class="category-option">
                    <!--<a href="order-details.php?s status=true" onclick="">Zmień status</a>-->

                    <form method="post" action="category-details.php"> <!-- POST -> orderId -->
                        <input type="hidden" name="%s"> <!-- order-id -->
                        <input type="hidden" name="true"> <!-- "Zmień status" -> true -->
                        <button class="submit-order-form" type="submit">
                            <!--<h3 class="book-title">Przeglądaj</h3>-->
                            Usuń
                        </button>
                    </form>

                </div>

                <!--<div class="order-option">
                    <a href="#" onclick="removeOrder(s)">Archiwizuj</a>
                </div>-->

            </div> <!-- .order-action-options -->

        </div> <!-- .order-options-container -->

    </div> <!-- .order-action -->

</div> <!-- .order order-content -->
