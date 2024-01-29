
function showBooksOptions(id) { // admin/orders.php

    let bookActionOptions = document.querySelectorAll('div.book-action');

    for(let i = 1; i < bookActionOptions.length; i++) {

        let bookActionButton = bookActionOptions[i].querySelector('.book-action-button');

        if(bookActionButton.id !== id) {

            let icon = bookActionOptions[i].querySelector('i');
            let options = bookActionOptions[i].querySelector('.book-action-options');

            if(icon.classList.contains('icon-up-open')) {
                icon.classList.replace('icon-up-open', 'icon-down-open');
            }

            options.classList.toggle("hidden", true);
        }
    }

    const button = document.querySelector(`#${id}`);
    const options = button.nextElementSibling.querySelector('.book-action-options');
    const icon = button.querySelector('i');

    if(!options.classList.contains("hidden")) {
        options.classList.add("hidden");
        icon.classList.replace('icon-up-open', 'icon-down-open');
    } else {
        options.classList.remove("hidden");
        icon.classList.replace('icon-down-open', 'icon-up-open');
    }
}
