
<!-- // meets the Separation of Concerns principle
     // https://en.wikipedia.org/wiki/Separation_of_concerns -->

<head>
    <meta charset="UTF-8">                                <!-- HTML5 template consistent with the latest W3C standards -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- rendering the page in the highest version of IE, will help to display the page in IE browsers; https://stackoverflow.com/questions/6771258/what-does-meta-http-equiv-x-ua-compatible-content-ie-edge-do -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- https://developer.mozilla.org/en-US/docs/Web/HTML/Viewport_meta_tag -->
    <meta name="description" content="Online bookstore Web Application">
    <meta name="keywords" content="Online bookstore, Web Application, Księgarnia internetowa, Zamówienia online, Rejestracja, Zakup książek, E-commerce, Handel elektroniczny">
    <title>Online bookstore</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/slider.css">
        <link rel="stylesheet" href="../css/book-page-tabs.css"> <!-- book-page-tabs -->
        <link rel="stylesheet" href="../css/book-page.css"> <!-- book-page -->

    <link rel="stylesheet" href="../css/jquery-outsider.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <!--<link href="css/fontello.css" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"><!-- font awesome -->




    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>



    <script src="../scripts/display-nav.js"></script>
    <script src="../scripts/change-quantity.js"></script>
    <script src="../scripts/load-theme.js"></script>

    <style>
        #rating-circle.filled {
            stroke-dashoffset: calc(62.8 - (62.8 * <?= $_SESSION["avg_rating"] ?> / 5));
        }
    </style>


</head>
