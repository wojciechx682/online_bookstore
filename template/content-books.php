
                        <div class="outer-book">

                            <div class="book" id="book%s">

                                <div class="book-cover">

                                    <form method="post" action="../user/___book.php">
                                        <input type="hidden" name="book-id" value="%s">
                                        <button type="submit" class="book-img-button">
                                            <img src="../assets/books/%s" alt="%s" title="%s">
                                        </button>
                                    </form>

                                </div>

                                <div class="book-info">

                                    <form method="post" action="../user/___book.php">
                                        <input type="hidden" name="book-id" value="%s">
                                        <button class="submit-book-form" type="submit">
                                            <h3 class="book-title" title="%s">%s</h3>
                                        </button>
                                    </form>

                                    <div class="book-price">%s</div>
                                    <div class="book-price">PLN</div>
                                    <div style="clear: both;"></div>
                                    <div class="book-year">%s</div>
                                    <div class="book-author">%s %s</div>
                                    <div class="book-status">%s</div>

                                    <form action="add_to_cart.php" method="post">
                                        <input type="hidden" name="book-id" value="%s">
                                        <input type="hidden" name="book-amount" class="book-amount" value="1">
                                        <button type="submit" class="btn-link" %s>Dodaj do koszyka</button>
                                    </form>

                                </div>

                            </div>

                        </div>

