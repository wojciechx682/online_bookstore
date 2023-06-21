
// reset-password-form.php ;

function hideResetForm() { // ukrycie pierwszego formularza do wprwowadzenia adresu e-mail;
    let form = document.getElementById("reset-form"); // "Podaj e-mail";
    form.style.display = "none";
}

/*function hideForm() {
    let div = document.getElementById("get-email");
    div.style.display = "none";
}*/

function hideTokenForm() {
    let form = document.getElementById("send-token");
    form.style.display = "none";
}
