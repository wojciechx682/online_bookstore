
<div id="application-error-message" class="hidden">

    <h2>Wystąpił bład</h2>
    <hr>
    <button id="confirm-message" class="btn-link btn-link-static">
        Potwierdź
    </button>
</div>

<div class="background">

</div>


<?php if ( isset($_SESSION["application-error"]) && $_SESSION["application-error"] ) : ?>

    <?php unset($_SESSION["application-error"]); ?>
    <?php //session_unset(); ?>

    <script>
        let statusBox = document.getElementById("application-error-message");
        let container = document.querySelector(".background");
        statusBox.classList.toggle("hidden");
        container.classList.toggle("bright");
        let confirmBtn = document.getElementById("confirm-message");
        confirmBtn.addEventListener("click", function() {
            //console.log("\nclicked ! ");
            statusBox.classList.toggle("hidden");
            container.classList.toggle("bright");
            container.style.pointerEvents = "none"; // ✓
        });
    </script>

<?php else: ?>

    <script>
        let container = document.querySelector(".background");
        container.style.pointerEvents = "none"; // ✓
    </script>

<?php endif; ?>