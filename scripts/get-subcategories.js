
// \user\index.php - top-nav - get subcategories after hover on category name in categories list;
// najechanie na kategorię wyświetla listę podkategorii
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  get list of all subcategories (object);

let subcategories;

    $.ajax({
        type: "GET",                    // GET or POST;
        url: "get-subcategories.php",   // Path to file (that process the <form> data);
        //data: data,                      // category-name (string);
        timeout: 2000,                   // Waiting time;
        beforeSend: function () { // Before Ajax - function called before sending the request;
            //$("img#loading-icon").toggleClass("not-visible"); // show loading animation;
        }
    }).done(function(data) {
        // Success handler; // Handle the response data;
        /*let booksHeader = document.querySelector('.admin-books'); // table header;
        if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
            booksHeader.style.display = "block";
        }
        $("#books-content").html(data); // show content (data returned from server) - books;*/
    //console.log("\n\n 52 - data (sub-categories) -> \n", data);
        subcategories = data;
        //console.log("\n\n 52 - subcategories  --> \n\n", subcategories);
    }).fail(function(data) { // (xhr, status, error)
            /*!// Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server*/
            //console.log("\n\n 52 - data (server) --> \n\n", data);
    }).always(function() {
            //$("img#loading-icon").toggleClass("not-visible");
    });

    //console.log("\n subcategories ->  \n", subcategories);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// get all list elements (list items);

let listItems = document.querySelectorAll("#n-top-nav-content ol li ul#categories-list li"); // <li> items
//console.log("\nlistItems -> ", listItems);

    //document.querySelectorAll('form#update-order-date').addEventListener("submit", function(e) {
    /*document.querySelectorAll('#n-top-nav-content ol li ul#categories-list li').addEventListener("mouseover", function(e) {
    });*/

let secondUl = document.querySelector('ul#subcategories-list');
//console.log("\nsecondUl -> ", secondUl);

//let secondUlfirstItem = secondUl.querySelector("li:first-child");
//console.log("\nsecondUlfirstItem -> ", secondUlfirstItem);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function isMobileDevice() {
    return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

/*if (isMobileDevice()) {
    console.log("This website is being accessed from a mobile device.");
    categoryButton.addEventListener("click", showCategories);
}*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

listItems.forEach((item) => { // for every listItem;    // usunąć kategorię "Wszystkie"

    //console.log("\n item --> ", item, "\n");

    let button = item.querySelector('button');
    let eventType = "mouseenter";

    if (isMobileDevice()) {
        eventType = "click";
    }

    button.addEventListener(eventType, function(e) {  // after hover on that listItem;  // po najechaniu na niego kursorem !
        //console.log("\n item --> ", item, "\n");
        //let data = item.querySelector('form > input[type="hidden"]').value;



        let subcategoryItems = secondUl.querySelectorAll('li');
        subcategoryItems.forEach((item) => {
            item.remove();
        });

        if(isMobileDevice()) {
            e.preventDefault(); // Zatrzymaj domyślną akcję (wysłanie formularza)

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

            /*<li>
                <form method="post" action="index.php">
                    <input type="hidden" name="kategoria" value="Informatyka">
                        <button className="submit-book-form" type="submit">Informatyka</button>
                </form>
            </li>*/

        //console.log("\n new secondULLi --> \n\n", secondULLi);

            secondUl.appendChild(secondULLi);

            //return;

        }

        let data = DOMPurify.sanitize(item.querySelector('form > input[type="hidden"]').value); // get name of the category (string) rom listItem;
        //console.log("\n data --> ", data, "\n"); // nazwa kategorii (string);

        let result = []; // docelowe podkategorie należące do kategorii po najechaniu myszą;

        subcategories.forEach((subcategory) => { // for every subcategory (object)
        //console.log("\n subcategory -> ", subcategory[1]);

            if(subcategory[2] === data) {  // if subcategory-name belongs to that category (data)

                //result.push(subcategory[1]); // add subcategory to new array;

                let li = document.createElement('li');
                    //span.classList.add("subcategory-item"); // li
                //li.textContent = subcategory[1];

                // to ma być wewnątrz <li> -->

                /*<form method="post" action="index.php">
                    <input type="hidden" name="kategoria" value="'.$row[" nazwa"].'">
                        <button className="submit-book-form" type="submit">'.$row["nazwa"].'</button>
                </form>*/

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

                //secondUl.append(li);
                secondUl.append(li);

                //let row = document.createElement('div');
                //row.classList.add("break-row");
                //firstLi.after(span, row);
                // echo '<span style="float: left;">abc</span>';
                // echo '<div style="clear: both;"></div>';
                result.push(li); // add element to the result array
            }
        })

    //console.log("\n result -> ", result);
        //console.log("\n result -> ", result);

        //////////////////////////////////////////////////////////////////////////////////
        // get sub-categories based on category name -->

        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "get-subcategories.php",      // Path to file (that process the <form> data);
            data: data,                      // category-name (string);
            timeout: 2000,                   // Waiting time;
            beforeSend: function () { // Before Ajax - function called before sending the request;
                //$("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {
            // Success handler; // Handle the response data;

            /!*let booksHeader = document.querySelector('.admin-books'); // table header;
            if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
                booksHeader.style.display = "block";
            }
            $("#books-content").html(data); // show content (data returned from server) - books;*!/

            console.log("\n\n 52 - data (server) --> \n\n", data);

        }).fail(function(data) { // (xhr, status, error)
            /!*!// Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server*!/

            console.log("\n\n 52 - data (server) --> \n\n", data);

        }).always(function() {
            //$("img#loading-icon").toggleClass("not-visible");
        });*/

    /*for(let i = 0; i < result.length; i++) {
        console.log("\n result[", i, "] = ", result[i]);
    }*/

    })

});


/*for(let i = 0; i < result.length; i++) {
    console.log("\n result[", i, "] = ", result[i]);
}*/

/*
    <ul id="second-list">
        <!-- tutaj chcę wstawić nowy element listy ! -->
        <li>
            <form method="post" action="index.php"><input type="hidden" name="kategoria" value="Informatyka"><input
                type="hidden" name="subcategory" value="Programowanie">
                <button className="submit-book-form" type="submit" style="width: 90%;">Programowanie</button></form>
        </li>
    </ul>
*/












