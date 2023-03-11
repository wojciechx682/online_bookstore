
<div>
    <p>Wprowadź nowe hasło dla konta <strong> <?php echo $_SESSION["emai"]; ?> </strong></p>
    <form method="post">
        <label>
            Nowe hasło:
            <input type="text" name="new-password">
        </label>
            <br>
        <label>
            Powtórz hasło:
            <input type="text" name="confirm-password">
        </label>
        <input type="submit" value="Zmień hasło">
    </form>
</div>
