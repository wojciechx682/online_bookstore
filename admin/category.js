
// admin/edit-books.php;

function getSubcategories(categorySelect) {

    //let categoryId = document.getElementById('edit-book-category').value;
    let categoryId = categorySelect.value; // "2" - string;

    let xhr = new XMLHttpRequest(); // send an AJAX request to fetch the subcategories based on the selected category;
    xhr.onreadystatechange = function() {           // xhr.onload = function()
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {              // after response from server

                let subcategories = JSON.parse(xhr.responseText); // (!)
                //  object

                // Update the subcategories select list
                let subcategorySelect = document.getElementById('edit-book-subcategory');
                subcategorySelect.innerHTML = ''; // Clear previous options

                for (let i = 0; i < subcategories.length; i++) {
                    let option = document.createElement('option');
                    option.value = subcategories[i].id; // object
                    option.textContent = subcategories[i].name;
                    subcategorySelect.appendChild(option); // .html() ? - nie bo dodajemy elementy <option> do listy <select> !
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };

    xhr.open('GET', 'get_subcategories.php?category_id=' + categoryId, true);
    xhr.send();
}




































        /*$(document).ready(function() {               // after page load/reload - send <form>;

            $("form#change-magazine-form").submit(); // submit the <form>;
        });*/

/*$("select#edit-book-category").on("change", function(e) { // after changing <option> element in <select> list;

    //$("form#change-magazine-form").submit(); // submit the <form>;

    console.log($(this));
});*/

        /*$("form#change-magazine-form").on("submit", function(e) { // after submitting form;
            e.preventDefault();
            let data = $(this).serialize(); // dane formularza do przesłania metodą post; // let data = $(this);
            let postData = parseInt($(this).serialize().slice(16).trim()); // "change-magazine=1" => "1" (id_maazynu);
            console.log("\ndata => ", data); // String;
            console.log("\npost_data (id_magazynu) =>", postData); // atrybut value elementu <option> (jest to id_magazynu);
            console.log("\ntypeof(post data) (id_magazynu) =>", typeof(postData)); // atrybut value elementu <option> (jest to id_magazynu);
            console.log("\ntypeof form => ", typeof(form)); // Object;
            if((data !== '') && (typeof(postData) === 'number') && (!isNaN(postData))) { // nie pusta, liczba, nie jest to "NaN";
                $.ajax({
                    type: "POST",                    // GET or POST;
                    url: "change-magazine.php",      // Path to file (that process the <form> data);
                    data: data,                      // serialized <form> data;
                    timeout: 2000,                   // Waiting time;
                    beforeSend: function() {         // Before Ajax - function called before sending the request;
                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    },
                    complete: function() {           // Once finished - function called always after sending request;
                        $("img#loading-icon").toggleClass("not-visible");
                    },
                    success: function(data) {        // Show content;
                        let booksHeader = document.querySelector('.admin-books');
                        if(booksHeader.style.display === 'none') {
                            booksHeader.style.display = "block";
                        }
                        $("#books-content").html(data); // Show content (data returned from server);
                    },
                    error: function(data) {          // Show error msg
                            // cal$content.html('<div id="container">Please try again soon.</div>');
                        // (!) Error - obsługa błędów;
                        $("#books-content").html(data);
                    }
                });
            } else {  // błąd z id-magazynu (!) ;
                $("div.admin-books").css('display', 'none');
                $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');
            }


        });*/


