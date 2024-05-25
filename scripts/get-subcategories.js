
// \user\index.php - top-nav - get subcategories after hover on category name in categories list; // najechanie na kategorię wyświetla listę podkategorii

let subcategories;

$.ajax({
    type: "GET",
    url: "get-subcategories.php",
    //data: data,
    timeout: 2000,
    beforeSend: function () {
    }
}).done(function(data) {

    subcategories = data;

}).fail(function(data) { // (xhr, status, error)

}).always(function() {

});


let listItems = document.querySelectorAll("#n-top-nav-content ol li ul#categories-list li");
let secondUl = document.querySelector('ul#subcategories-list');

function isMobileDevice() {
    return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

listItems.forEach((item) => {

    let button = item.querySelector('button');
    let eventType = "mouseenter";

    if (isMobileDevice()) {
        eventType = "click";
    }

    button.addEventListener(eventType, function(e) {

        let subcategoryItems = secondUl.querySelectorAll('li');
        subcategoryItems.forEach((item) => {
            item.remove();
        });

        if(isMobileDevice()) {
            e.preventDefault();

            let secondULLi = document.createElement('li');

            let secondUlForm = document.createElement('form');
                secondUlForm.setAttribute("method", "post");
                secondUlForm.setAttribute("action", "index.php");

            let secondUlInput = document.createElement('input');
                secondUlInput.setAttribute("type", "hidden");
                secondUlInput.setAttribute("name", "category");
                secondUlInput.setAttribute("value", item.querySelector("input").value);

            let secondUlButton = document.createElement('button');
                secondUlButton.setAttribute("class", "submit-book-form");
                secondUlButton.setAttribute("style", "width: 90%;");
                secondUlButton.setAttribute("type", "submit");
                secondUlButton.textContent = item.querySelector("input").value;

            secondUlForm.appendChild(secondUlInput);
            secondUlForm.appendChild(secondUlButton);
            secondULLi.appendChild(secondUlForm);

            secondUl.appendChild(secondULLi);
        }

        let data = DOMPurify.sanitize(item.querySelector('form > input[type="hidden"]').value);

        let result = [];

        subcategories.forEach((subcategory) => {

            if(subcategory[2] === data) {

                let li = document.createElement('li');

                let form = document.createElement('form');
                    form.method = "post";
                    form.action = "index.php";

                let category = document.createElement('input');
                    category.type = "hidden";
                    category.name = "category";
                    category.value = subcategory[2];

                let subcategoryInput = document.createElement('input');
                    subcategoryInput.type = "hidden";
                    subcategoryInput.name = "subcategory";
                    subcategoryInput.value = subcategory[1];

                let button = document.createElement('button');
                    button.className = "submit-book-form";
                    button.type = "submit";
                    button.innerHTML = subcategory[1];
                    button.style.width = "90%";

                form.append(category, subcategoryInput, button);
                li.append(form);
                secondUl.append(li);
                result.push(li);
            }
        })
    })
});