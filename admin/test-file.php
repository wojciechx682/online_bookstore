<!--
<style>
    body {
        margin: 20px;
    }
    div {
        margin-bottom: 10px;
    }
    label:hover {
        cursor: pointer;
    }
</style>

<div>
    <label for="avatar">Choose a profile picture:</label>
</div>

<input type="file" id="avatar" name="avatar"
       accept="image/png, image/jpeg">

<br><hr><br>

<form method="post" enctype="multipart/form-data" action="asd.php">
    <div>
        <label for="file">Choose file to upload</label>
    </div>
    <div>
        <input type="file" id="file" name="file"
               multiple />
    </div>
    <div>
        <button>Submit</button>
    </div>
</form>

<br><hr><br>

<form method="post" enctype="multipart/form-data">
    <div>
        <label for="profile_pic">Choose file to upload</label>
    </div>
    <div>
        <input
            type="file" id="profile_pic" name="profile_pic"
            accept=".jpg, .jpeg, .png" />
    </div>
    <div>
        <button>Submit</button>
    </div>
</form>
<br><hr><br>

<script>
    let inputs = document.querySelectorAll('input[type="file"]');

    inputs.forEach(function(input, i, parent) {
        console.log(input, i, parent);
    });

    for(let i = 0; i < inputs.length; i++) {
        inputs[i].onchange = function() {
            console.log(inputs[i].value);
        }
    }

</script>

-->

<?php
include "../functions.php";
session_start();

    query("SELECT id_ksiazki FROM books WHERE id_ksiazki = '%s'", "cart_verify_book", "1");
?>