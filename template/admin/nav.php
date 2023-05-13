
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

        <!-- <h3><a href="orders.php">Zamówienia</a></h3><hr> -->

        <!-- <h3>Sortowanie</h3>
            <select id="sortuj_wg">
                <option value="1">ceny rosnąco</option>
                <option value="2">ceny malejąco</option>
                <option value="3">nazwy A-Z</option>
                <option value="4">nazwy Z-A</option>
                <option value="5">Najnowszych</option>
                <option value="6">Najstarszych</option>
            </select>
            <h3>Cena</h3>
            <div id="price-range">
                <label>
                    <span>
                        Min
                    </span>
                        <input type="number" id="value-min">
                </label>
                <label>
                    <span>
                        Max
                    </span>
                        <input type="number" id="value-max">
                </label>
                <div id="slider"></div>
            </div>
            <div id="input-search-nav">
                <h3>Tytyuł</h3>
                <form action="___index2.php" method="get">
                    <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                    <input type="submit" value="">
                </form>
            </div>
            <button id="filter-authors">Zastosuj</button> -->
    </div>
</aside>
