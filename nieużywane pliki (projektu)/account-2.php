
<!-- ten plik nie jest nigdzie używany ! -->

<?php

	session_start();	

	include_once "functions.php";	
	
	if(!(isset($_SESSION['zalogowany'])))
	{
		header('Location: index.php');
		exit();
	}
?>


<?php

	
?>

<!DOCTYPE HTML> <!-- HTML5 template consistent with the latest W3C standards -->
<html lang="pl">
<head>
    <meta charset="UTF-8"> <!-- Character encoding - UTF-8 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- rendering the page in the highest version of IE, will help to display the page in IE browsers; https://stackoverflow.com/questions/6771258/what-does-meta-http-equiv-x-ua-compatible-content-ie-edge-do -->

    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- https://developer.mozilla.org/en-US/docs/Web/HTML/Viewport_meta_tag -->
    <meta name="description" content="Online bookstore Web Application">
    <meta name="keywords" content="Online bookstore, Web Application, Księgarnia internetowa, Zamówienia online, Rejestracja, Zakup książek, E-commerce, Handel elektroniczny">

    <title>Online bookstore</title>

    <link rel="stylesheet" href="style2.css">

    <!-- Google fonts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
    <link href="css/fontello.css" rel="stylesheet"> -->

    <script src="display-nav.js"></script>
    <script src="change-quantity.js"></script>

</head>

<body>

	<div id="header-container">
		
		<!-- <div id="header_content"> -->

			<div id="sticky">

				<div id="top-header">

					<div id="top-header-content">

						<div id="header-title">
							
							Księgarnia internetowa

						</div>		
						
						<!--<div id="div_register">
							
							<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
							
						</div> -->

						<!-- <div id="div_log_in">
							
							<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

						</div> -->

						<ol>	

							<li>
								<a href="zarejestruj.php">Zarejestruj</a>
							</li>

							<li>									
								<?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) { echo '<a href="../account.php">Moje konto</a>';} else { echo '<a href="../zaloguj.php">Zaloguj</a>';} ?>
							</li>

						</ol>

					</div>

				</div>

				<div id="header">

					<div id="header-content">

						<!-- <a href="index.php">Strona główna</a> -->

						 <div id="div-search">

							<form action="index.php" method="get">
								
								<input type="search" name="input_search">

								<input type="submit" value="Szukaj">

							</form>	

						</div>

						<div id="div-logo">
							
							<img src="logo.png" width="100px">

						</div>

						<!-- 
							<div id="div_log_in">
								
								<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

							</div> 
						-->
						
						<!--
							<div id="div_register">
								
								<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
								
							</div>
						-->

						<div id="div-cart">
							
							<a class="top-nav-right" href="koszyk.php">Koszyk</a>
							
						</div>

						<!--
							<div id="div_my_account">
								
								<a class="top-nav-right" href="account.php">Moje konto</a>
								
							</div> 
						-->
						
						<div style="clear: both;"></div>

					</div>

				</div>

			</div>

			<div id="top-nav">
				
				<div id="top-nav-content">

					<ol>
						
						<li><a href="index.php">Strona główna</a></li>
						<li><a href="#">Kategorie</a>
							
							 <!-- <ul id="double"> -->
							 <ul>

								<!-- 
									<li class="double"><a href="#">Informatyka</a></li>
									<li class="double"><a href="#">Poezja</a></li>
									<li class="double"><a href="#">Horror</a></li>
									<li class="double"><a href="#">Komiks</a></li> 
								-->

								<?php 
									echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // wypis kategorii - wewnątrz listy rozwijanej ul
								?>

							</ul> 

						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a></li>

					</ol>
			
				</div>

			</div>

		<!-- </div> -->

	</div>

	<div id="container">	

		<?php include 'account-3.php'; ?>

		

	</div>
		
</body>
</html>