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

<?php require "../view/___head.php"; ?>

<body>

<div id="all-container">

<!-- header -->

<?php require "../view/___header-container.php"; ?>

<!-- end header -->

	<div id="container">

        <main>
            <aside class="account-data">
                <div id="nav">
                    <!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->
                    <a href="___account.php"> ← </a><br><br>
                    <a href="___my_orders.php">Zamówienia</a>
                </div>
            </aside>

            <div id="content">

                <!-- <h3>Zamówienia</h3><hr> -->
                <!--<h3>Historia zamówień</h3><hr>-->
                <h3 class="account-header">Historia zamówień</h3>

                <?php
                    echo '<script> displayNav(); </script>';

                    /*echo "<hr>" . print_r($_SESSION) . "<hr>";*/

                    query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", $_SESSION['id']);
                ?>

                <br><br><a href="logout.php">[ Wyloguj ]</a>

            </div>
        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</div>

<script>
    content = document.getElementById("content");
    content.style.overflow = "auto";
</script>

</body>
</html>