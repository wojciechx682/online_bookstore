
<div>
    <p id="insert-token">
        Wprowadź nowe hasło dla konta <strong>%s</strong>
    </p>

    <form method="post" id="password-reset-input">

<!--        <span>-->
<!--            <label for="new-password">-->
<!--                Nowe hasło:-->
<!--            </label>-->
<!--        </span>-->
<!--        <input type="password" name="new-password" id="new-password">-->
<!--            <br>-->
<!--        <span>-->
<!--            <label for="confirm-password">-->
<!--                Powtórz hasło:-->
<!--            </label>-->
<!--        </span>-->

        <div class="login-form-section">

            <span class="login-row">
                    <label>
                        Nowe hasło <input type="password" name="newPassword" id="newPassword" required maxlength="255">
                    </label>
            </span>

            <span class="login-row">
                    <label>
                        Powtórz hasło <input type="password" name="confirmPassword" id="confirmPassword" required maxlength="255">
                    </label>
            </span>

            <input type="submit" value="Zmień hasło">

        </div>

        <!-- <div>
            <p>
                <span class="reset-password-form">
                    <label for="new-password">
                       Nowe hasło:
                    </label>
                </span>
                <input type="password" name="new-password" id="new-password" reqiured>
            </p>
        </div>

        <div>
            <p>
                <span class="reset-password-form">
                    <label for="confirm-password">
                       Powtórz hasło:
                    </label>
                </span>
                <input type="password" name="confirm-password" id="confirm-password" reqiured>
            </p>
        </div>-->

    </form>
</div>
