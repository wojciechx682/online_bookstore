
<? // template used on the book page (book.php) to display the book details ?>

<div id="book-page">

    <div id="book-page-image">
        <img src="../assets/books/%s" alt="%s" title="%s">
    </div>
    <div id="book-page-details">
        <div id="book-page-title">Tytuł - %s</div>
        <div id="book-page-author">Autor - %s %s</div>
        <div id="book-page-year">Rok wydania - %s</div>
        <div id="book-page-rate">

            <span id="book-rate" style="display: none;">%s</span>

            <div id="rate-container">
                <div class="rate-outer">
                    <div class="rate-inner-base"></div>
                    <div class="rate-inner"></div>
                </div>
            </div>

            <span class="rating-num"></span>

            %s ocen, %s komentarzy

        </div>

        <div id="book-page-publ">Wydawnictwo - %s</div>
        <div id="book-page-nopg">ilość stron - %s</div>

        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
        molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
        numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
        optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
        obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
        nihil, eveniet aliquid culpa officia aut.



    </div>
    <div style="clear: both;"></div>

    <!--<header><h1>Lorem ipsum</h1></header>-->

    <section class="book-page">

        <div class="book-tabs">

            <ul class="tab-list">
                <li class="active"><a class="tab-control" href="#tab-1"><h3>Opis</h3></a></li>
                <li><a class="tab-control" href="#tab-2" id="tab-2-li"><h3>Dane szczegółowe</h3></a></li>
                <li><a class="tab-control" href="#tab-3"><h3>Recenzje</h3></a></li>
            </ul>

           <!-- <div class="tab-panel active" id="tab-1">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                    molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                    numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                    optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                    obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                    nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                    tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                    quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
                    sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
                    recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
                    minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
                    quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
                    fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
                    consequuntur! Commodi minima excepturi repudiandae velit hic maxime
                    doloremque. Quaerat provident commodi consectetur veniam similique ad
                    earum omnis ipsum saepe, voluptas, hic voluptates pariatur est explicabo
                    fugiat, dolorum eligendi quam cupiditate excepturi mollitia maiores labore
                    suscipit quas? Nulla, placeat. Voluptatem quaerat non architecto ab laudantium
                    modi minima sunt esse temporibus sint culpa, recusandae aliquam numquam
                    totam ratione voluptas quod exercitationem fuga. Possimus quis earum veniam
                    quasi aliquam eligendi, placeat qui corporis.
                    <strong>Elderberry</strong>, <strong>Rose Petal</strong>, and <strong>Chrysanthemum</strong>
                    - all edible and all naturally flavored - they will have you dreaming of butterflies and birdsong in no time.</p>
            </div>-->

            <div class="tab-panel active" id="tab-1" style="padding: 10px;">
                <!--  <p><strong>Lorem ipsum dolor sit amet</strong>-->


                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
                sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
                recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
                minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
                quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
                fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
                consequuntur! Commodi minima excepturi repudiandae velit hic maxime
                doloremque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
                sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
                recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
                minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
                quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
                fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
                consequuntur! Commodi minima excepturi repudiandae velit hic maxime
                doloremque.

                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
                sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
                recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
                minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
                quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
                fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
                consequuntur! Commodi minima excepturi repudiandae velit hic maxime
                doloremque.


            </div>



            <div class="tab-panel" id="tab-2">
              <!--  <p><strong>Lorem ipsum dolor sit amet</strong>-->

                <p><span class="book-details-tab">tytuł</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">autor</span> <strong>%s %s</strong></p>
                <p><span class="book-details-tab">wydawnictwo</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">ilość stron</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">rok wydania</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">wymiary</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">oprawa</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">stan</span> <strong>%s</strong></p>
                <p><span class="book-details-tab">numer (id) książki</span> <strong>%s</strong></p>

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
                        <circle cx="15" cy="15" r="10" stroke="#D3D3D3" stroke-width="1" fill="none" />
                        <circle id="rating-circle" cx="15" cy="15" r="10" stroke="#ffc107" stroke-width="1" fill="none"
                                stroke-dasharray="62.8"
                                stroke-dashoffset="62.8" class="filled" >

                        </circle>
                        <text x="15" y="16.5" text-anchor="middle" font-size="3">
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
                        <div class="no-rates">45</div>


                    </div>
                    <div class="book-rating-details" id="four">
                        <div class="rate">4</div>
                        <div class="line">
                            <div class="rated"></div>
                            <div class="unrated"></div>



                        </div>
                        <div class="no-rates">35</div>



                    </div>
                    <div class="book-rating-details" id="three">
                        <div class="rate">3</div>
                        <div class="line">
                            <div class="rated"></div>
                            <div class="unrated"></div>
                        </div>
                        <div class="no-rates">62</div>

                    </div>
                    <div class="book-rating-details" id="two">
                        <div class="rate">2</div>
                        <div class="line">
                            <div class="rated"></div>
                            <div class="unrated"></div>
                        </div>
                        <div class="no-rates">31</div>
                    </div>
                    <div class="book-rating-details" id="one">
                        <div class="rate">1</div>
                        <div class="line">
                            <div class="rated"></div>
                            <div class="unrated"></div>
                        </div>
                        <div class="no-rates">16</div>
                    </div>


                </div>

                <div style="clear: both;"></div>

                <br><br>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
                optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
                obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
                nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
                tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
                sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
                recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
                minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
                quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
                fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
                consequuntur! Commodi minima excepturi repudiandae velit hic maxime
                doloremque.<br>

                <hr>

                <div id="add-review">

                    <h3>Dodaj recenzję</h3>

                    <form method="post" action="add-comment.php">

                        <div>
                            <div><label for="komentarz"> Komentarz </label></div>
                            <textarea id="textarea-comment" name="komentarz" id="komentarz" rows="4" cols="80" maxlength="255" minlength="10"></textarea>
                        </div>

                        <hr>

                        <div id="add-rate">
                            <div class="add-rate-outer">
                                <!--<div class="rate-inner-base"></div>-->

                                    <span class="star" id="star-1">
                                        1 <input type="hidden" value="1" name="star">
                                    </span>
                                    <span class="star" id="star-2">
                                        2 <input type="hidden" value="2" name="star">
                                    </span>
                                    <span class="star" id="star-3">
                                        3 <input type="hidden" value="3" name="star">
                                    </span>
                                    <span class="star" id="star-4">
                                        4 <input type="hidden" value="4" name="star">
                                    </span>
                                    <span class="star" id="star-5">
                                        5 <input type="hidden" value="5" name="star">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <input type="submit" value="wyślij">

                    </form>

                    <!--<form>
                        <label for="comments">Enter your comments:</label><br>
                        <textarea id="comments" name="comments" rows="4" cols="50"></textarea><br>
                        <label for="rating">Rate this:</label><br>
                        <div class="stars">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                        </div>
                        <br><br>
                        <input type="submit" value="Submit">
                    </form>-->

                </div>


                <!-- <svg viewBox="0 0 100 100">
                     <circle cx="50" cy="50" r="8" stroke="#D3D3D3" stroke-width="1" fill="none" />
                     <circle cx="50" cy="50" r="8" stroke="#ffc107" stroke-width="1" fill="none"
                             stroke-dasharray="62.8"
                             stroke-dashoffset="15.7" />
                 </svg>
 -->














            </div>

        </div> <!-- .tabs -->

    </section> <!-- .page -->

    <!--<script src="js/tabs.js"></script>-->

    <script>
       /* el = document.getElementById("tab-2");

        el.addEventListener("click", setSpanWidthv2);*/
    </script>
</div>