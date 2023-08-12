
// price range - noUISlider (jQ) ;  // książka jQuery - strona 544 - 549;

(function() {

    $min = $('#value-min'); // input type number - input#value-min - minimum price value input;
    $max = $('#value-max'); // input type number - input#value-max - maximum price value input;

        console.log("\n#value-min --> ", $min);
        console.log("\n#value-max --> ", $max);

    let books = document.querySelectorAll("#content-books .book"); // kolekcja elementów DOM (NodeList) - divy z książkami;
        //let books = document.querySelectorAll("#content-books .book:not(.hidden)");

        console.log("\n books -> ", books);
        console.log("\n typeof books -> ", typeof books);
        console.log("\n books instanceof NodeList -> ", books instanceof NodeList); // true

    function update(min, max) { // update content-books

        for(let i=0; i < books.length; i++) { // for every book <div>;

            let price = parseFloat(DOMPurify.sanitize(books[i].querySelector(".book-price").innerHTML)); // get the price of that book;

            min = parseInt(min); // min input-value from slider (number)
            max = parseInt(max); // max input-value from slider (number)
            //price = parseInt(price);

            console.log("\n price -> ", price);
            console.log("\n typeof price -> ", typeof price);


            if((price >= min) && (price <= max)) {   // add or remove "hidden" clsas;
                books[i].classList.remove('hidden');
            } else {
                books[i].classList.add('hidden');
            }
        }
    }

    function initFun() {                            // Tasks when script first runs
        $('#slider').noUiSlider({                   // Set up the slide control
            range: [5, 150], start: [10, 135], handles: 2, margin: 1, connect: true,
            serialization: { to: [$min, $max], resolution: 1 }
        }).change(function() {
            update($min.val(), $max.val());         // Update content-books every time after slider values change
        });
        //makeRows();                               // Create table rows and rows array
        //appendRows();                             // Add the rows to the table
        update($min.val(), $max.val());             // Update content-books at first load
    }

    $(initFun);                                     // Call init() when DOM is ready

    $("#value-min, #value-max").change(function() { // update content-book after input value will change
        update($min.val(), $max.val());
    });

}());

