
<!-- // template used on the book page (book.php) to display the book comments -->

<section class="comment">
    <div class="comment-author">%s</div>  <!-- $row["imie"] - autor komentarza (imie) -->
    <div class="comment-date">%s</div>    <!-- $row["data"] - 2021-01-01 15:22:34 -->
    <div class="comment-rate">
        <span>%s</span>                   <!-- $row["ocena"] - "4" -->
        <div class="comment-rate-inner"></div> <!-- (!!!) - JS - width -> 80 procent -->
        <div class="comment-rate-inner-base"></div>
    </div>
    <div style="clear: both;"></div>
    <div class="comment-content">%s</div> <!--  $row["tresc"] - "abc..." -->
</section>

