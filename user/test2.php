<style>
    .stars-outer {
        display: inline-block;
        position: relative;
        font-size: 1.2rem;
        color: #ddd;
        text-shadow: 1px 1px #ccc;
    }

    .stars-inner {
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        overflow: hidden;
        width: 0;
    }

    .stars-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005";
        font-family: FontAwesome;
        font-weight: normal;
        font-size: 1.2rem;
        color: #f8ce0b;
    }

    .rating-num {
        font-size: 1.2rem;
        margin-left: 0.5rem;
    }

</style>


<div class="stars-outer">
    <div class="stars-inner"></div>
</div>
<span class="rating-num"></span>


<script>
    const rating = 4.25;
    const starsTotal = 5;
    const starPercentage = (rating / starsTotal) * 100;
    const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
    document.querySelector('.stars-inner').style.width = starPercentageRounded;
    document.querySelector('.rating-num').innerHTML = rating.toFixed(2);
</script>





