
<!-- template used on admin page (admin.php) to display nav -->

<aside id="admin-nav">

    <div id="nav" class="nav-visible admin-nav"> <!-- html5 nav -->

        <div id="admin-data">

            <img src="../assets/admin/left-nav-header-admin-picture.png" alt="admin-profile-picture" title="<?= $_SESSION["imie"] . " " . $_SESSION["nazwisko"]?>">

            <div id="admin-name">
                <span><?= $_SESSION["imie"] . " " . $_SESSION["nazwisko"] . "</span><br>" ?>
                <span><?= $_SESSION["stanowisko"] ?></span>
            </div>

        </div>

        <a href="admin.php"><h3>Panel główny</h3><hr></a>
        <a href="orders.php"><h3>Zamówienia</h3><hr></a>

    </div>
</aside>
