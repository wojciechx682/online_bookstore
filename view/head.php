<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online bookstore Web Application">
    <meta name="keywords" content="Online bookstore, Web Application, Księgarnia internetowa, Zamówienia online, Rejestracja, Zakup książek, E-commerce, Handel elektroniczny">
    <title>Online bookstore</title>
        <link rel="stylesheet" href="../css/new.css">
            <link rel="stylesheet" href="../css/book-page-tabs.css">
            <link rel="stylesheet" href="../css/book-page.css">
            <link rel="stylesheet" href="../node_modules/nouislider/dist/nouislider.css">
            <link rel="stylesheet" href="../css/jquery-outsider2.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">  <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
        <link href="../assets/fontello/css/fontello.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="../scripts/display-nav.js"></script>
    <script src="../node_modules/dompurify/dist/purify.min.js"></script>
    <style>
        .sticky {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 3000;
            width: 100% !important;
        }

        .stickyContainer {
            position: relative;
            top: 37px;
        }

        div.sticky-adv-search {
            position: initial !important;
            margin: 0 auto;
        }
    </style>

    <script>

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

    </script>

</head>
