
<!-- template used on admin page (admin.php) to display nav -->

<aside id="admin-nav">

    <div id="nav" class="nav-visible admin-nav">

        <div id="admin-data">

            <img src="../assets/admin/left-nav-header-admin-picture.png" alt="admin-profile-picture" title="<?= $_SESSION["imie"] . " " . $_SESSION["nazwisko"]?>">

            <div id="admin-name">
                <span><?= $_SESSION["imie"] . " " . $_SESSION["nazwisko"] . "</span>" ?>
                <span><?= $_SESSION["stanowisko"] ?></span>
            </div>

        </div>

        <a href="admin.php"><h3>Panel główny</h3><hr></a>
        <a href="orders.php"><h3>Zamówienia</h3><hr></a>
        <a href="books.php"><h3>Produkty</h3><hr></a>
        <a href="categories.php"><h3>Kategorie</h3><hr></a>
        <!--<a href="books-pagination-test.php"><h3 style="text-decoration: line-through; color: gray;">Produkty - paginacja - test</h3><hr></a>-->

    </div>

</aside>
