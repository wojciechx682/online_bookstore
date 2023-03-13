<?php
	session_start();
	include_once "../functions.php";
	if(!isset($_SESSION['zalogowany']))	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <aside>
                <div id="nav">
                    <a href="my_orders.php"> ← </a><br><br>
                    <a href="my_orders.php">Zamówienia</a>
                </div>
            </aside>

            <div id="content">

                <h3>Zamówienia</h3><hr>

                <?php

                    echo '<script> displayNav(); </script>';

                    //$id_klienta = $_SESSION['id'];

                    //echo query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", "$_SESSION["id"]"); // Książki, które zamówił klient o danym ID

                    if((isset($_GET['order_id'])) && (!empty($_GET['order_id'])))
                    {
                        echo "<br> order_id id = " . $_GET['order_id'] . "<br>";

                        $order_id = htmlentities($_GET['order_id'], ENT_QUOTES, "UTF-8");

                        query("SELECT id_zamowienia , id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", $order_id);

                        echo "<hr>";

                        $order_details_books_id = $_SESSION['order_details_books_id'];

                        echo "książki dla tego zamówienia -> <br><br>";

                        for($i = 0; $i < count($order_details_books_id); $i++) {
                            $book_id = $order_details_books_id[$i];
                            query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", $book_id);
                        }
                        unset($_SESSION['last_order_id']);
                        unset($_SESSION['order_details_books_id']);
                        unset($_SESSION['order_details_books_quantity']);
                        unset($_SESSION['suma_zamowienia']);
                    }
                ?>

                <br><br><a href="logout.php">[ Wyloguj ]</a>

            </div>

        </main>

	</div>

    <?php require "../template/footer.php"; ?>
		
</body>
</html>