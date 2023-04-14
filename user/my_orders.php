<?php
	session_start();
	include_once "../functions.php";
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>


<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<style>
    .order {
        border: 1px dashed black;
        border-radius: 15px;
        margin: 10px auto 10px auto;
        padding: 10px 0 10px 10px;
        /*background-color: #606686;*/
        overflow: auto;
        text-align: left !important;
    }
    .order-date-title, .order-status-title, .order-id-title,
    .order-date, .order-status, .order-id {
        border: 1px dashed black;

        float: left;
        width: 33.33%;
        text-align: left;
    }
    .book-no {
        border: 1px dashed black;

        float: left;
        width: 35px;
        height: 150px;

        text-align: left;
        padding-top: 68px;
    }
    .book-url {
        border: 1px dashed black;

        float: left;
        width: 150px;
        height: 150px;

        text-align: left;
    }

    .book-url img {
        width: 100px;
    }

    .book-desc {
        border: 1px dashed black;

        float: left;
        width: 270px;
        height: 150px;

        text-align: left;

    }

    .book-quan {
        border: 1px dashed black;
        float: left;
        width: 112px;
        height: 150px;
        text-align: left;
    }
    .book-price {
        border: 1px dashed black;
        float: left;
        width: 112px;
        height: 150px;
        text-align: left;
    }

    .order-sum {
        border: 1px dashed black;

        padding: 20px 20px 20px 0px;
        text-align: right;
    }

</style>

<body>

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>
        <aside class="account-data">
            <div id="nav">
                <!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->
                <a href="account.php"> ← </a><br><br>
                <a href="my_orders.php">Zamówienia</a>
            </div>
        </aside>

		<div id="content">

			<!-- <h3>Zamówienia</h3><hr> -->
            <h3>Historia zamówień</h3><hr>

			<?php
				echo '<script> displayNav(); </script>';

                //echo "<hr>" . print_r($_SESSION) . "<hr>";

				query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", $_SESSION['id']);
			?>

			<br><br><a href="logout.php">[ Wyloguj ]</a>






		</div>


        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</body>
</html>