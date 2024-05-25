
<section class="book-page">

    <div class="book-tabs">

        <ul class="tab-list">

            <li>
                <a class="tab-control" href="#tab-1">
                    <h3>Opis</h3>
                </a>
            </li>
            <li>
                <a class="tab-control" href="#tab-2" id="tab-2-li">
                    <h3>Dane szczegółowe</h3>
                </a>
            </li>
            <li class="active">
                <a class="tab-control" href="#tab-3">
                    <h3>Recenzje</h3>
                </a>
            </li>

        </ul>

        <div class="tab-panel" id="tab-1">

            <p>%s</p>
        </div>

        <div class="tab-panel" id="tab-2">
            <p><span class="book-details-tab">Tytuł</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Autor</span><strong>%s %s</strong></p>
            <p><span class="book-details-tab">Wydawnictwo</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Ilość stron</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Rok wydania</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Wymiary (mm)</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Oprawa</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Stan</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Kategoria</span><strong>%s</strong></p>
            <p><span class="book-details-tab">Podkategoria</span><strong>%s</strong></p>
        </div>

        <div class="tab-panel active" id="tab-3">

        <div id="circle-plot">

            <svg viewBox="0 0 100 100">

                <circle cx="15" cy="17" r="10" stroke="#D3D3D3" stroke-width="1" fill="none" />

                <circle id="rating-circle" cx="15" cy="17" r="10" stroke="#ffc107" stroke-width="1" fill="none"></circle>

                <text x="15" y="18.5" text-anchor="middle" font-size="3">
                    <tspan x="15" dy="-0.5em">średnia</tspan>
                    <tspan x="15" dy="1.2em">%s</tspan>
                </text>
            </svg>

        </div>


            <div id="book-rating-details">

                <div class="book-rating-details" id="five">

                    <div class="rate">5</div>

                    <div class="line">
                        <div class="rated"></div>
                        <div class="unrated"></div>
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="four">

                    <div class="rate">4</div>

                    <div class="line">
                        <div class="rated"></div>
                        <div class="unrated"></div>
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="three">

                    <div class="rate">3</div>

                    <div class="line">
                        <div class="rated"></div>
                        <div class="unrated"></div>
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="two">

                    <div class="rate">2</div>

                    <div class="line">
                        <div class="rated"></div>
                        <div class="unrated"></div>
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="one">

                    <div class="rate">1</div>

                    <div class="line">
                        <div class="rated"></div>
                        <div class="unrated"></div>
                    </div>
                    <div class="no-rates"></div>

                </div>

            </div> <!-- #book-rating-details -->

            <div style="clear: both;"></div>

            <!--<hr>-->

            <div id="add-review">

                <h3>Dodaj recenzję</h3>

                <form method="post" action="add-comment.php">

                    <div>
                        <div>
                            <label for="textarea-comment" id="textarea-label">Twoja opinia</label>
                        </div>
                        <textarea id="textarea-comment" name="comment" required rows="4" cols="80" maxlength="255" minlength="5" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non facilisis risus, a condimentum ipsum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; In hac habitasse platea dictumst."></textarea>
                    </div>

                    <!--<hr>-->

                    <div id="add-rate"> <!-- pojemnik na gwiazdki (przy dodawaniu nowej opinii) -->

                        <div class="add-rate-outer">
                                <!-- <div class="rate-inner-base"></div> -->
                            <span class="star" id="star-1">
									1 <input type="hidden" value="1">
                                      <!-- po kliknięciu na gwiazdkę dodany zostaje do niej (do inputa) atrybut name="star" -->
                            </span>
                            <span class="star" id="star-2">
									2 <input type="hidden" value="2">
								</span>
                            <span class="star" id="star-3">
									3 <input type="hidden" value="3">
								</span>
                            <span class="star" id="star-4">
									4 <input type="hidden" value="4">
								</span>
                            <span class="star" id="star-5">
									5 <input type="hidden" value="5">
								</span>
                        </div> <!-- .add-rate-outer -->

                    </div> <!-- #add-rate -->

                    <input type="submit" value="wyślij" id="add-rate-button">

                </form>

                    <div id="error-message">%s</div>

            </div>

            <article id="book-comments">
                    %s
            </article>

        </div>
    </div>

</section>
