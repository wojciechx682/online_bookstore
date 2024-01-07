
function showOptions(id) {

    let orderActionOptions = document.querySelectorAll('div.order-action');

    for(let i = 1; i < orderActionOptions.length; i++) {

        let orderActionButton = orderActionOptions[i].querySelector('.order-action-button');

        if(orderActionButton.id !== id) {

            let icon = orderActionOptions[i].querySelector('i');
            let options = orderActionOptions[i].querySelector('.order-action-options');

            if(icon.classList.contains('icon-up-open')) {
                icon.classList.replace('icon-up-open', 'icon-down-open');
            }
            options.classList.toggle("hidden", true);
        }
    }

    const button = document.querySelector(`#${id}`);
    const options = button.nextElementSibling.querySelector('.order-action-options');
    const icon = button.querySelector('i');

    if(!options.classList.contains("hidden")) {
        options.classList.add("hidden");
        icon.classList.replace('icon-up-open', 'icon-down-open');
    } else {
        options.classList.remove("hidden");
        icon.classList.replace('icon-down-open', 'icon-up-open');
    }
}
