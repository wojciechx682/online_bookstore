$(document).ready(function() {
    let NavY = $('#main-nav').offset().top;

    let stickyNav = function() {
        let ScrollY = $(window).scrollTop();

        if(ScrollY+1 > NavY) {
            $('#main-nav').addClass('sticky');
            $('#advanced-search').addClass('sticky-adv-search');

            let container = document.getElementById("container");
            container.classList.add("stickyContainer");

        } else {
            $('#main-nav').removeClass('sticky');
            $('#advanced-search').removeClass('sticky-adv-search');


            let container = document.getElementById("container");
            container.classList.remove("stickyContainer");
        }
    };

    stickyNav();

    $(window).scroll(function() {
        stickyNav();
    });
});