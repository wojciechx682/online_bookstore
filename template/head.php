<?
    // meets the Separation of Concerns principle
    // https://en.wikipedia.org/wiki/Separation_of_concerns
?>

<head>
    <meta charset="UTF-8"> <!-- Character encoding - UTF-8 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- rendering the page in the highest version of IE, will help to display the page in IE browsers; https://stackoverflow.com/questions/6771258/what-does-meta-http-equiv-x-ua-compatible-content-ie-edge-do -->

    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- https://developer.mozilla.org/en-US/docs/Web/HTML/Viewport_meta_tag -->
    <meta name="description" content="Online bookstore Web Application">
    <meta name="keywords" content="Online bookstore, Web Application, Księgarnia internetowa, Zamówienia online, Rejestracja, Zakup książek, E-commerce, Handel elektroniczny">

    <title>Online bookstore</title>

    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="slider.css">


    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <!--<link href="css/fontello.css" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">



        <!--<script src="jquery-3.6.3.js"></script>-->

    <!-- Include latest jQuery from a CDN -->
    <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"></script>

    <script src="display-nav.js"></script>

    <script src="change-quantity.js"></script>


    <link rel="stylesheet" href="jquery-outsider.css">

    <script>
        window.addEventListener("load", function() {
            var selectedValue = localStorage.getItem("theme");

            console.log("selectedValue -> ", selectedValue)
            if (selectedValue == "white") {

                setWhiteTheme();

            } else {
                setBlackTheme();
            }
        });
    </script>

</head>