<?php
    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ../user/___index2.php?login-error");
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<style>
    /* (~) temporary ! */

    #all-container {
        border: 1px solid red !important;
    }

    #container {
        border: 1px solid purple;
    }

    #content {
            font-weight: normal !important;
        border: 1px solid #14ffab;
    }

    /* -------------------------------------------------------- */

    /*form#edit-book-data div {
        border: 1px solid lightgreen;
    }*/
    form#edit-book-data div p span {
        display: inline-block;
        min-width: 125px;

        border: 1px solid lightblue;
    }

</style>

<body>

<div id="all-container">

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <div id="admin-books-header-container">

                    <h3 class="section-header section-header-books">Edytuj książkę</h3>

                </div>

                <hr id="book-details-hr-edit-books">

                <div id="books-content">
                    <!-- (?) -->
                </div>

                <!-- ---------------------------------------------------------------------------------------------- -->


                <?php
                   /* if($bookId = filter_var($_GET["book-id"], FILTER_VALIDATE_NUMBER_INT)) {
                        query("SELECT ks.id_ksiazki, ks.tytul, ks.id_autora, ks.rok_wydania, ks.cena, ks.id_wydawcy, ks.opis, ks.oprawa, ks.ilosc_stron, ks.wymiary, ks.id_subkategorii, kt.id_kategorii FROM ksiazki AS ks, subkategorie AS subkt, kategorie AS kt WHERE ks.id_subkategorii = subkt.id_subkategorii AND subkt.id_kategorii = kt.id_kategorii AND ks.id_ksiazki=35", "createEditForm", $bookId);
                    }*/
                ?>



                <!-- ---------------------------------------------------------------------------------------------- -->

                <!-- Edytowanie danych o książce -->

                <form action="edit-book-data.php" method="post" id="edit-book-data" class="edit-book-data" name="edit-book-data"
                      enctype="multipart/form-data">

                    <!-- form       (!) label           fieldset + legend      -->

                    <!-- input      text
                                password
                                number                      -> step=""
                                search
                                checkbox                    checked
                                radio                       selected
                                tel                         disabled    required
                                email
                                date                        placeholder
                                month
                                week
                                time                        submit
                                color                       button
                                                            -->
                    <!-- <select>   size=""
                         <select multiple>     <textarea>
                                    <button>   submit       -->

                    <!-- ------------------------------------------------------------------------------------------- -->

                    <!--<label>
                        tytuł <input type="text" name="book-title">
                    </label>-->

                    <div> <!-- tytuł - varchar(255) -->
                        <p>
                            <span>
                                <label for="edit-book-title">
                                    Tytuł książki
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-title" id="edit-book-title" value="tytuł książki">
                        </p>
                    </div>

                    <div> <!-- autor - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-change-author">
                                    Autor
                                </label>
                            </span>

                            <select id="edit-book-change-author"
                                    name="edit-book-change-author">
                                <?php
                                    query("SELECT au.id_autora, au.imie, au.nazwisko FROM autor AS au", "createAuthorSelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <div> <!-- rok_wydania - year(4) -->
                        <p>
                            <span>
                                <label for="edit-book-release-year">
                                    Rok wydania
                                </label>
                            </span>
                            <input type="number" min="1900" max="2023"
                                   name="edit-book-release-year" id="edit-book-release-year" value="1999">
                        </p>
                    </div>

                    <div> <!-- cena - float-->
                        <p>
                            <span>
                                <label for="edit-book-price">
                                    Cena
                                </label>
                            </span>
                            <input type="number" min="1" max="500" step="0.01"
                                   name="edit-book-price" id="edit-book-price" value="85">
                        </p>
                    </div>

                    <div> <!-- wydawnictwo - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-change-publisher">
                                    Wydawnictwo
                                </label>
                            </span>

                            <select id="edit-book-change-publisher"
                                    name="edit-book-change-publisher">
                                <?php
                                    query("SELECT wd.id_wydawcy, wd.nazwa_wydawcy FROM wydawcy AS wd", "createPublisherSelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <hr id="book-details-hr">

                        <!-- image_url -->

                       <!-- <label for="edit-book-image" class="edit-book-image btn-link btn-link-static">
                            Wybierz plik (JPEG, PNG, GIF)
                        </label>
                        <input type="file" name="edit-book-image" id="edit-book-image"
                        accept="image/*">-->
                                    <!-- accept=".jpg, .jpeg, .png" --> <!-- WEWNĄTRZ LABEL - WSTAWIĆ TUTAJ MOJEGO BUTTONA .btn ... (!) -->
                                    <!-- Zdjęcie książki <br><br>--> <!--<button >Wybierz plik</button>-->
                        <input type="file" name="edit-book-image" id="edit-book-image">

                        <div class="preview">
                            <p>No files currently selected for upload</p>
                        </div>

                        <!-- Walidacja + Sanityzacja -->

                    <hr id="book-details-hr">

                    <div> <!-- opis - varchar(1000) -->
                        <p>
                            <span>
                                <label for="edit-book-desc">
                                    Opis
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-desc" id="edit-book-desc" value="opis książki">
                        </p>
                    </div>

                    <div> <!-- oprawa - varchar(255) -->
                        <p>
                            <span>
                                <label for="edit-book-cover">
                                    Oprawa
                                </label>
                            </span>

                            <select id="edit-book-cover"
                                    name="edit-book-cover">
                                <option value="twarda">Twarda</option>
                                <option value="miekka">Miękka</option>
                            </select>
                        </p>
                    </div>

                    <div> <!-- ilość_stron - int(11) -->
                        <p>
                            <span>
                                <label for="edit-book-pages">
                                    Ilość stron
                                </label>
                            </span>
                            <input type="number" min="1" max="1500" step="1"
                                   name="edit-book-pages" id="edit-book-pages" value="450">
                        </p>
                    </div>

                    <div> <!-- Wymiary - varchar(25) -->
                        <p>
                            <span>
                                <label for="edit-book-dims">
                                    Wymiary (!) JS -> Validation
                                </label>
                            </span>
                            <input type="text"
                                   name="edit-book-dims" id="edit-book-dims" value="255 x 746 x 982">
                        </p>
                    </div>

                    <hr id="book-details-hr">

                    <div> <!-- kategoria - (to pole nie istnieje w tablie książki) -->
                        <p>
                            <span>
                                <label for="edit-book-category">
                                    Kategoria
                                </label>
                            </span>

                            <select id="edit-book-category"
                                    name="edit-book-category"
                                    onchange="getSubcategories(this)">
                                <?php
                                    query("SELECT kt.id_kategorii, kt.nazwa FROM kategorie AS kt", "createCategorySelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <div> <!-- podkategoria -->
                        <p>
                            <span>
                                <label for="edit-book-subcategory">
                                    Podkategoria
                                </label>
                            </span>

                            <select id="edit-book-subcategory"
                                    name="edit-book-subcategory">
                                <?php
                                query("SELECT subkt.id_subkategorii, subkt.nazwa, subkt.id_kategorii FROM subkategorie AS subkt", "createSubcategorySelectList", "");
                                ?>
                            </select>
                        </p>
                    </div>

                    <input type="submit">

                </form>

                <div class="result">

                </div>

            </div> <!-- #content -->

        </main>
    </div> <!-- #container -->

</div> <!-- #all-container -->

<script>
    // input type file - validation and sanitization;
        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file;

    let input = document.querySelector('#edit-book-image');
    let div = document.querySelector('.preview');

    //input.style.opacity = "0"; // display: none; ?    visibility: hidden; ?

    // Note: opacity is used to hide the file input instead of visibility: hidden or display: none, because assistive technology interprets the latter two styles to mean the file input isn't interactive;

    input.addEventListener("change", validateImage); // when file is selected (uploaded);

    function validateImage() {

        console.log("\n305");

        while(div.firstChild) {
            div.removeChild(div.firstChild);
        }

        const curFiles = input.files; // FileList object;

        if (curFiles.length === 0) { // check if any file was selected;
            const p = document.createElement('p');
            p.textContent = 'No files currently selected for upload';
            div.appendChild(p);

            // ... myFun("errorMessage");

        } else { // file was selected;
            const ol = document.createElement('ol');
            ol.style.listStyleType = "none";
            div.appendChild(ol); // ?

            for (const file of curFiles) {
                const li = document.createElement('li');
                const p = document.createElement('p');
                if (validFileType(file)) { // CHECK IF FILE IS IN PROPER IMG TYPE !
                    p.textContent = `File name ${file.name}, file size ${returnFileSize(file.size)}.`;
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file); // generate a thumbnail preview of the image;
                    //li.appendChild(image);
                    li.appendChild(p);
                } else { // file not valid - validFileType() - NOT VALID IMAGE TYPE! ;
                    p.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
                    li.appendChild(p);

                    // myFun (?)
                }

                ol.appendChild(li);
            }
        }
    }

    /*const fileTypes = [ // https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types;
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
    ];*/

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
    }

    // other fields validation;
        // in "category.js" file;



</script>


<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="category.js"></script> <!-- (!) nazwa robocza !!! -->









</body>
</html>