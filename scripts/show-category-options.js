
function showCategoryOptions(id) {

    let categoryActionOptions = document.querySelectorAll('div.category-action');

    for(let i = 1; i < categoryActionOptions.length; i++) {

        let categoryActionButton = categoryActionOptions[i].querySelector('.category-action-button');

        if(categoryActionButton.id !== id) {

            let icon = categoryActionOptions[i].querySelector('i');
            let options = categoryActionOptions[i].querySelector('.category-action-options');

            if(icon.classList.contains('icon-up-open')) {
                icon.classList.replace('icon-up-open', 'icon-down-open');
            }
            options.classList.toggle("hidden", true);
        }
    }

    const button = document.querySelector(`#${id}`);
    const options = button.nextElementSibling.querySelector('.category-action-options');
    const icon = button.querySelector('i');

    if(!options.classList.contains("hidden")) {
        options.classList.add("hidden");
        icon.classList.replace('icon-up-open', 'icon-down-open');
    } else {
        options.classList.remove("hidden");
        icon.classList.replace('icon-down-open', 'icon-up-open');
    }
}