<style>
    .login-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f5f5f5;
    }

    h2 {
        text-align: center;
        margin-top: 0;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 10px;
    }

    label {
        font-weight: bold;
    }

    input {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button[type="submit"] {
        padding: 10px;
        border-radius: 5px;
        border: none;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0069d9;
    }


</style>

<div class="login-container">


    <h2>Login</h2>



    <form action="login.php" method="post">




        <div class="form-group">




            <label for="username">Username:</label>




            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Log In</button>
    </form>
</div>