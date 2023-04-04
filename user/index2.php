<?php

session_start();

include_once "../functions.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

    <link rel="stylesheet" href="../css/new.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>

<style>
    #test {
        margin: 0;
        padding: 0 40px 0 0;
        float:right;
        text-align: right;

       /* position: relative;
        top: 80px;*/
    }

    pre {
        font-family: Verdana, sans-serif;
        /*font-family: initial;*/
    }
</style>


<body>


<!-- header -->

<div id="n-header">


    <div id="n-top-header">

        <!-- top-header -->
            <div id="header-title"> Księgarnia internetowa </div>
            <div id="btn-parent">
                <div class="btn from-center">Zaloguj</div>
                <div class="btn from-center">Zarejestruj</div>
                <div id="div-cart-header">
                    <a class="top-nav-right" href="koszyk.php" >Koszyk
                    </a>
                </div>
                <!-- <div style="height: 25px; width: 25px; margin: 0 auto 0 auto; border: 1px dashed red;"> if you want to have content in center -->
            </div>

        <!-- header -->









    </div>

    <div id="div-search">
        <form id="search-form" action="index.php" method="get" >
            <input type="search" name="input-search" id="input-search" > <!-- placeholder="tytuł książki" -->

            <input type="submit" value=" ">

            <!--<img id="search-arrow" src="../assets/arrow.png" alt="advanced filtering">--> <!-- advanced search -->
        </form>
        <br><br>



    </div>



    <div id="div-logo">
        <img id="main-logo" src="../assets/logo3.png" alt="logo">
    </div>

    <!--<div id="div-cart">-->
    <div class="div-cart">
        <a class="top-nav-right" href="koszyk.php" >Koszyk
        </a>
    </div>



    <div id="header"></div>





</div>

<!-- end header -->





</body>
</html>