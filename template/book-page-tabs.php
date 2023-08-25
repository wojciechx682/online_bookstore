
<!-- // template used on the book page (book.php) to display the book tabs -->

<section class="book-page"> <!-- book-page-tabs -->

    <div class="book-tabs">

        <ul class="tab-list"> <!-- .tab-list -->

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

        </ul> <!-- ul.tab-list -->

        <div class="tab-panel" id="tab-1"> <!-- tab-panel -->
            <p>Java jest dojrzałym językiem programowania, który pozwala na pisanie kodu dla wielu rodzajów komputerów służących do różnych celów i działających na różnych platformach. Jest świetnym wyborem dla programistów, którym zależy na tworzeniu bezpiecznych aplikacji o wyjątkowej jakości. Wokół Javy skupia się duża społeczność, dzięki której język ten wciąż się rozwija, unowocześnia i wzbogaca o nowe elementy. Osoby, które swoje zawodowe życie wiążą z pisaniem programów w Javie, muszą poznać zaawansowane zagadnienia i mniej oczywiste funkcjonalności Javy, również te niedawno zaimplementowane. To konieczność dla każdego profesjonalnego programisty Javy.</p>

            <p>Oto kolejne, przejrzane, zaktualizowane i uzupełnione wydanie znakomitego podręcznika dla zawodowych programistów Javy. Znalazł się tu dokładny opis sposobów tworzenia interfejsu użytkownika, stosowania rozwiązań korporacyjnych, sieciowych i zabezpieczeń, a także nowości wprowadzonych w JDK 11. Przedstawiono techniki programowania baz danych oraz umiędzynarodowiania aplikacji Javy. Sporo uwagi poświęcono bibliotece Swing oraz jej wykorzystaniu do tworzenia realistycznej grafiki i efektów specjalnych. Ponadto w książce zostały pokazane nowe możliwości języka - zademonstrowano, jak dzięki nim uzyskać wyjątkową jakość aplikacji, a zamieszczone przykłady opracowano pod kątem zrozumiałości i wartości praktycznej.</p>

            <p>%s</p> <!-- $row["opis"] -->
        </div>

        <div class="tab-panel" id="tab-2">
            <p><span class="book-details-tab">Tytuł</span><strong>%s</strong></p> <!-- $row["tytul"] -->
            <p><span class="book-details-tab">Autor</span><strong>%s %s</strong></p> <!--  $row["imie"], $row["nazwisko"] -->
            <p><span class="book-details-tab">Wydawnictwo</span><strong>%s</strong></p> <!-- $row["nazwa_wydawcy"] -->
            <p><span class="book-details-tab">Ilość stron</span><strong>%s</strong></p> <!-- $row["ilosc_stron"] -->
            <p><span class="book-details-tab">Rok wydania</span><strong>%s</strong></p> <!-- $row["rok_wydania"] -->
            <p><span class="book-details-tab">Wymiary (mm)</span><strong>%s</strong></p> <!-- $row["wymiary"] -->
            <p><span class="book-details-tab">Oprawa</span><strong>%s</strong></p> <!-- $row["oprawa"] -->
            <p><span class="book-details-tab">Stan</span><strong>%s</strong></p> <!-- $row["stan"] -->
            <!--<p><span class="book-details-tab">Numer (id) książki</span><strong>s</strong></p>--> <!-- $row["id_ksiazki"] -->
            <p><span class="book-details-tab">Kategoria</span><strong>%s</strong></p> <!-- $row["id_ksiazki"] -->
            <p><span class="book-details-tab">Podkategoria</span><strong>%s</strong></p> <!-- $row["id_ksiazki"] -->
        </div>

        <div class="tab-panel active" id="tab-3">

            <!-- <div id="book-page-rate-circle">
                <div id="book-page-rate-circle">
                    <div class="rating-circle"></div>
                    <span class="rating-num-circle"></span>
                </div>
            </div> -->

<div id="circle-plot">

    <svg viewBox="0 0 100 100">

        <circle cx="15" cy="17" r="10" stroke="#D3D3D3" stroke-width="1" fill="none" /> <!-- szare kółko -->

        <circle id="rating-circle" cx="15" cy="17" r="10" stroke="#ffc107" stroke-width="1" fill="none"> <!-- stroke-dasharray="100"
                           stroke-dashoffset="100" -->
        </circle>

        <!--  stroke-dasharray - określa DŁUGOŚCI przerywanych ODCINKÓW oraz DŁUGOŚCI PRZERW między nimi -->

        <text x="15" y="18.5" text-anchor="middle" font-size="3">
            <tspan x="15" dy="-0.5em">średnia</tspan>
            <tspan x="15" dy="1.2em">%s</tspan> <!-- $row["rating"] -->
        </text>
    </svg>

</div>
           <!-- <svg>
                <circle cx="50" cy="50" r="40" stroke="black" stroke-width="1" fill="none"
                        stroke-dasharray="20" />
            </svg> -->

            <div id="book-rating-details">

                <div class="book-rating-details" id="five">

                    <div class="rate">5</div>

                    <div class="line">
                        <div class="rated"></div>   <!-- żółty pasek -->
                        <div class="unrated"></div> <!-- cały pasek (szary) -->
                    </div>
                    <div class="no-rates"></div> <!-- JS -> (0) / (15) / (63) ... -->

                </div>

                <div class="book-rating-details" id="four">

                    <div class="rate">4</div>

                    <div class="line">
                        <div class="rated"></div>   <!-- żółty pasek -->
                        <div class="unrated"></div> <!-- szary pasek -->
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="three">

                    <div class="rate">3</div>

                    <div class="line">
                        <div class="rated"></div>   <!-- żółty pasek -->
                        <div class="unrated"></div> <!-- szary pasek -->
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="two">

                    <div class="rate">2</div>

                    <div class="line">
                        <div class="rated"></div>   <!-- żółty pasek -->
                        <div class="unrated"></div> <!-- szary pasek -->
                    </div>
                    <div class="no-rates"></div>

                </div>

                <div class="book-rating-details" id="one">

                    <div class="rate">1</div>

                    <div class="line">
                        <div class="rated"></div>   <!-- żółty pasek -->
                        <div class="unrated"></div> <!-- szary pasek -->
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
                    <!-- $message - komunikat informujący czy udało się dodać komentarz (success/fail) -->

            </div> <!-- #add-review -->

            <article id="book-comments"> <!-- article - html5 -->
                <!--<hr>-->
                    %s
                <!--<hr>-->             <!-- /template/book-comment.php <-- $_SESSION["comments"]  -->
            </article>

        </div> <!-- .tab-panel #tab-3 -->

    </div> <!-- .book-tabs -->

    <!--</div> ? -->

</section> <!-- .book-page -->
