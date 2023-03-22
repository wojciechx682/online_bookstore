
<? // template used on the book page (book.php) to display the book tabs ?>

<section class="book-page">
    <div class="book-tabs">

        <ul class="tab-list">
            <li class="active"><a class="tab-control" href="#tab-1"><h3>Opis</h3></a></li>
            <li><a class="tab-control" href="#tab-2" id="tab-2-li"><h3>Dane szczegółowe</h3></a></li>
            <li><a class="tab-control" href="#tab-3"><h3>Recenzje</h3></a></li>
        </ul>

        <div class="tab-panel active" id="tab-1" style="padding: 10px;">
        </div>

        <div class="tab-panel" id="tab-2">
            <p><span class="book-details-tab">tytuł</span><strong>%s</strong></p>
            <p><span class="book-details-tab">autor</span><strong>%s %s</strong></p>
            <p><span class="book-details-tab">wydawnictwo</span><strong>%s</strong></p>
            <p><span class="book-details-tab">ilość stron</span><strong>%s</strong></p>
            <p><span class="book-details-tab">rok wydania</span><strong>%s</strong></p>
            <p><span class="book-details-tab">wymiary</span><strong>%s</strong></p>
            <p><span class="book-details-tab">oprawa</span><strong>%s</strong></p>
            <p><span class="book-details-tab">stan</span><strong>%s</strong></p>
            <p><span class="book-details-tab">numer (id) książki</span><strong>%s</strong></p>
        </div>

        <div class="tab-panel" id="tab-3">

            <!--<div id="book-page-rate-circle">
                <div id="book-page-rate-circle">
                    <div class="rating-circle"></div>
                    <span class="rating-num-circle"></span>
                </div>
            </div>-->

            <div id="circle-plot">
                <svg viewBox="0 0 100 100">
                    <circle cx="15" cy="17" r="10" stroke="#D3D3D3" stroke-width="1" fill="none" />
                    <circle id="rating-circle" cx="15" cy="17" r="10" stroke="#ffc107" stroke-width="1" fill="none"
                            stroke-dasharray="62.8"
                            stroke-dashoffset="62.8" class="filled">
                    </circle>
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
            </div>

            <div style="clear: both;"></div>

            <hr>

            <div id="add-review">

                <h3>Dodaj recenzję</h3>

                <form method="post" action="add-comment.php">

                    <div>
                        <div><label for="textarea-comment" id="textarea-label"> Twoja opinia </label></div>
                        <textarea id="textarea-comment" name="comment" rows="4" cols="80" maxlength="255" minlength="5">Super książka polecam :)</textarea>
                    </div>

                    <hr>

                    <div id="add-rate">
                        <div class="add-rate-outer">
                            <!--<div class="rate-inner-base"></div>-->

                            <span class="star" id="star-1">
									1 <input type="hidden" value="1">
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
                        </div>
                    </div>
                    <input type="submit" value="wyślij" id="add-rate-button">
                </form>

                    <div id="error-message">%s</div>
            </div>

            <article id="book-comments">
                <hr>
                    %s
                <hr>
            </article>

        </div>

    </div> <!-- .tabs -->

    <!--</div> ? -->

</section> <!-- .page -->