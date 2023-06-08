
function showOptions(id) { // admin/orders.php

    const button = document.querySelector(`#${id}`);
    const options = button.nextElementSibling.querySelector('.order-action-options');
    const icon = button.querySelector('i');

    /*console.log("8 i -> ", icon)*/

    if(options.style.display === "block") {
        options.style.display = "none";
        icon.classList.remove('icon-up-open');
        icon.classList.add('icon-down-open');
    } else {
        options.style.display = "block";
        icon.classList.remove('icon-down-open');
        icon.classList.add('icon-up-open');
    }
}
