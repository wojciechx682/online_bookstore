<?php
    session_start();
    include_once "../functions.php";
?>

<!DOCTYPE HTML>
<html lang="pl">
    <body>
        <div id="container">
            <div id="nav"></div>
            <div id="content">
                <form action="logowanie-main.php" method="post">
                    <!-- Login: <br> <input type="text" name="login"> <br> -->
                    user: <input type="text" name="email"><br><br>
                    pass: <input type="password" name="haslo"><br><br>
                    <input type="submit" value="Log in">
                </form>

                <?php
                    // pokazujemy zawartość tej zmiennej tylko jeśli podano nieprawidłowy login lub hasło
                    // czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI

                    // normalne logowanie, podany złe hasło
                    if(isset($_SESSION['blad']))
                    {
                        echo '<br>'.$_SESSION['blad'];
                    }
                ?>

            </div>
        </div>
    </body>
</html>