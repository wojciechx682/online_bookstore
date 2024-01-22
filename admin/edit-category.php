<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;
    require_once "../authenticate-admin.php";

    $categoryId = filter_var($_POST["category-id"], FILTER_VALIDATE_INT); // validate category-id (POST);
    $categoryName = filter_var($_POST["category-name"], FILTER_SANITIZE_STRING); // validate category-id (POST);


    // check if that category exists (id);
        //unset($_SESSION["category-exists"]);
    $categoryExists = query("SELECT kt.nazwa FROM categories AS kt WHERE kt.id_kategorii = '%s' AND kt.nazwa = '%s'", "verifyCategoryExists", [$categoryId, $categoryName]); // $_SESSION["category-exists"] --> true / null;

    if (empty($categoryId) || empty($categoryExists)) {

        $_SESSION["application-error"] = true;

        unset($_POST);
            header('Location: categories.php', true, 303);
                exit();
    }

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

    <div id="main-container">

        <div id="container">

            <main>

                <?php require "../template/admin/nav.php"; ?>

                <?php require "../template/admin/top-nav.php"; ?>

                <div id="content">

                        <!--<div id="admin-books-header-container">
                            <h3 class="section-header section-header-books">Edytuj książkę</h3>
                        </div>-->

                    <header>
                        <h3 class="section-header">Edytuj kategorię</h3>
                    </header>


                    <!-- Zmiana nazwy kategorii -->

                    <form method="post"
                          action="edit-category.php"
                              id="edit-category"
                              class="edit-category"
                              name="edit-category">


                        <div> <!-- tytuł - varchar(255) -->
                            <p>
                                <span>
                                    <label for="edit-category-name">
                                        Nazwa kategorii
                                    </label>
                                </span>
                                <input type="text" required maxlength="100" size="100" autofocus
                                       name="edit-category-name"
                                       id="edit-category-name"
                                       value="<?= $categoryName; ?>" >
                            </p>
                        </div>

                        <input type="hidden" value="<?= $categoryId; ?>" name="edit-category-id" id="edit-category-id"> <!-- id_kategorii - int(11) -->

                        <input type="submit" id="input-submit-edit-category" value="Edytuj dane">

                    </form>

                    <div class="result edit-book-result"></div>




                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

    </div> <!-- #all-container -->

<script>
    // input type file - validation and sanitization (JS);
        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file ;

        //let input = document.querySelector('#edit-book-image');
    /*let input = document.querySelector('input[type="file"]'); // get input by type "file", to make it work more universal (there is only one input type file on the page!);
    let div = document.querySelector('.preview');

    console.log('\n input type="file" --> \n', input)

    // input.style.opacity = "0"; // display: none; ? visibility: hidden; ?
        // Note: opacity is used to hide the file input instead of visibility: hidden or display: none, because assistive technology interprets the latter two styles to mean the file input isn't interactive;

    input.addEventListener("change", validateImage); // when file is selected (uploaded);

    function validateImage() {

        while(div.firstChild) {
            div.removeChild(div.firstChild);
        }

        let curFiles = input.files; // FileList object;

        if (curFiles.length === 0) { // check if any file was selected;
            const p = document.createElement('p');
            p.textContent = 'Nie wybrano żadnego pliku';
            div.appendChild(p);
        } else { // file was selected;
            const ol = document.createElement('ol');
            ol.style.listStyleType = "none";
            ol.style.paddingLeft = "0";
            div.appendChild(ol);

            for (const file of curFiles) {
                const li = document.createElement('li');
                const p = document.createElement('p');
                if (validFileType(file)) { // CHECK IF FILE IS IN PROPER IMG TYPE !
                    p.textContent = `Nazwa pliku - ${file.name}, rozmiar - ${returnFileSize(file.size)}.`;
                    //const image = document.createElement('img');
                    //image.src = URL.createObjectURL(file); // generate a thumbnail preview of the image;
                    //li.appendChild(image);
                    li.appendChild(p);
                } else { // file not valid - validFileType() - NOT VALID IMAGE TYPE! ;
                    p.textContent = `File name - ${file.name}: Not a valid file type. Update your selection.`;
                    li.appendChild(p);
                }
                ol.appendChild(li);
            }
        }
    }

    /!*const fileTypes = [ // https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types;
        "image/apng",
        "image/bmp",
        "image/gif",
        "image/jpeg",
        "image/pjpeg",
        "image/png",
        "image/svg+xml",
        "image/tiff",
        "image/webp",
        "image/x-icon"
    ];*!/

    const fileTypes = [ // https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types;
        "image/jpeg",
        "image/png",
        "image/gif"
    ];

    function validFileType(file) { // check if file is correct type (e.g. the image types specified in the accept attribute);
        // takes a File object as a parameter, then uses Array.prototype.includes() to check if any value in the fileTypes matches the file's type property. If a match is found, the function returns true. If no match is found, it returns false.
        return fileTypes.includes(file.type);
    }

    function returnFileSize(number) { // returns a nicely-formatted version of the size in bytes/KB/MB (by default the browser reports the size in absolute bytes).
        // number - number (of bytes, taken from the current file's size property);
        if (number < 1024) {
            return `${number} bytes`;
        } else if (number >= 1024 && number < 1048576) {
            return `${(number / 1024).toFixed(1)} KB`;
        } else if (number >= 1048576) {
            return `${(number / 1048576).toFixed(1)} MB`;
        }
    }*/

    // other fields validation; - in "category.js" file;

    /*$("#edit-book-title").val(bookData[0]["tytul"]); // Fill form data with book data retrieved from DB;
    $("#edit-book-id").val(bookData[0]["id_ksiazki"]); // used jQ because performance difference is minimal;
    $("#edit-book-change-author").val(bookData[0]["id_autora"]); // Change to the value attribute for <option>;
    $("#edit-book-release-year").val(bookData[0]["rok_wydania"]);
    $("#edit-book-price").val(bookData[0]["cena"]);
    $("#edit-book-change-publisher").val(bookData[0]["id_wydawcy"]);
    $("#edit-book-desc").val(bookData[0]["opis"]);
    $("#edit-book-pages").val(bookData[0]["ilosc_stron"]);
    $("#edit-book-dims").val(bookData[0]["wymiary"]);
    $("#edit-book-category").val(bookData[0]["id_kategorii"]);
    $("#edit-book-subcategory").val(bookData[0]["id_subkategorii"]);
        $("#edit-book-image_url").val(bookData[0]["image_url"]); // ?

    $("#edit-book-select-magazine").val(bookData[0]["id_magazynu"]); // input type hidden
    $("#edit-book-select-magazine-readonly").val(bookData[0]["id_magazynu"]);
    $("#edit-book-quantity").val(bookData[0]["ilosc_egzemplarzy"]);*/

    /*$("#edit-category-name").val(categoryData[0]["nazwa"]); // Fill form data with book data retrieved from DB;
    $("#edit-category-id").val(categoryData[0]["id_kategorii"]); // Fill form data with book data retrieved from DB;*/


</script>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="edit-category.js"></script> <!-- (!) nazwa robocza !!! -->


</body>
</html>