<style>
    body {
        margin: 40px 20px 20px 20px;
        background-color: #0f395d;
        color: white;
    }
    div {
        margin-top: 20px;
        margin-bottom: 10px;
    }
    label:hover {
        cursor: pointer;
    }
    label {
        background-color: #5786af;
        padding: 10px;
        border: 1px solid #0f395d;
        border-radius: 5px;
    }
</style>

<!-- ---------------------------------------------------------------------------------------------------------- -->

<form method="post"
      enctype="multipart/form-data">

    <div>
        <label for="image_uploads">Choose images to upload (PNG, JPG)</label>
    </div>

    <div>
        <input type="file"
               id="image_uploads"
               name="image_uploads"
               accept=".jpg, .jpeg, .png"
               multiple>
    </div>

    <div class="preview">
        <p>No files currently selected for upload</p>
    </div>

    <div>
        <button>Submit</button>
    </div>

</form>

<!-- ---------------------------------------------------------------------------------------------------------- -->


<script>

    let input = document.querySelector("input");      console.log("\ninput -> ", input);     // <input type="file">
    let preview = document.querySelector(".preview"); console.log("\npreview -> ", preview); // <div class="preview">

        input.style.opacity = 0; // display: none;  visibility: hidden;

    input.addEventListener("change", updateImageDisplay);

    // ✓ 1. usunięcie bieżączej (poprzedniej) zawartości diva ".preview";
    // ✓ 2. zapisanie obiektu FileList w zmiennej "curFiles" - (zawiera informacje o wszystkich wybranych plikach);
    // 3. sprawdzenie, czy nie wybrano żadnych plików poprzez sprawdzenie właściwości curFiles.length; - jeśli nie wybrano żadnych plików, wyświetl wiadomość w divie ".preview" -> "Nie wybrano żadnych plików";
    // 4. jeśli pliki zostały wybrane, przeiteruj przez każdy z nich wyświetlając za kazdym razen informację o tym pliku -> div ".preview";

    // validFileType() - używamy tej funkcji w celu sprawdzenia poprawności typu pliku (czy typy plików są zgodne z tymi w atrybucie accept="");
    // jeśli tak, to -> wyświetlamy nazwę pliku oraz jego rozmiar -> do ELEMENTU LISTY (li)
        //                         (files.name,           files.size)

        // returnFileSize() - zwraca "ładnie" sformatowaną wersję rozmiaru w bajtach/KB/MB;
        // (!) generujemy podgląd minatury pliku poprzez wywołanie URL.createObjectURL(curFiles[i])
            // następnie, wstawiam yobraz do elementu listy, tworząc nowy element <img> i ustawiając jego atrybut "src";

    // Jeśli typ pliku jest nieprawidłowy, w elemencie listy wyświetlamy komunikat informujący użytkownika, że musi wybrać inny typ pliku.


    function updateImageDisplay() { // executed after "change" event in input type="file" / after uploading the file;

        // ✓ usunięcie bieżączej (poprzedniej) zawartości diva ".preview";
        while(preview.firstChild) {                  // if div ".preview" has any child nodes - in this case, the first child -> <p> ...
            preview.removeChild(preview.firstChild); // remove <p> element in <div> ".preview"
        }

        // zapisanie obiektu FileList w zmiennej "curFiles" - (zawiera informacje o wszystkich wybranych plikach) - object;
        let curFiles = input.files; // "files" property of "FileList" object;
            console.log("\ncurFiles -> ", curFiles);
            console.log("\n typeof curFiles -> ", typeof curFiles);

        // sprawdzenie, czy nie wybrano żadnych plików - poprzez sprawdzenie właściwości curFiles.length; - jeśli nie wybrano żadnych plików, wyświetl wiadomość w divie ".preview" -> "Nie wybrano żadnych plików";
        if(curFiles.length === 0) { // no files were selected;
            let para = document.createElement("p"); // create <p> element;
            para.textContent = "No files currently selected for upload";
            preview.appendChild(para);
        } else {
            // at least one file was selected;

            let list = document.createElement("ol"); // <ol> list;
            preview.appendChild(list);

            // for(let i=0; i<curFiles.length; i++) { ... }
            for(let file of curFiles) { // for every element (file) in "curFiles" object;

                let listItem = document.createElement("li"); // <li>
                let para = document.createElement("p"); // <p>

                if(validFileType(file)) { // valid type;    file - object "File";
                    // validFileType() - używamy tej funkcji w celu sprawdzenia poprawności typu pliku (czy typy plików są zgodne z tymi w atrybucie accept="");
                    para.textContent = `File name ${file.name}, file size ${returnFileSize(file.size)}.`; // returnFileSize() - zwraca "ładnie" sformatowaną wersję rozmiaru w bajtach/KB/MB;

                    let image = document.createElement("img"); // <img>
                    image.src = URL.createObjectURL(file); // generujemy podgląd minatury pliku poprzez wywołanie URL.createObjectURL(curFiles[i]), następnie, wstawiamy obraz do elementu listy, tworząc nowy element <img> i ustawiając jego atrybut "src";

                    listItem.appendChild(image);
                    listItem.appendChild(para);
                } else { // not valid type
                    para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
                    listItem.appendChild(para);
                }

                list.appendChild(listItem);
            }
        }
    }

    // https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types
    const fileTypes = [
        "image/apng",
        "image/bmp",
        "image/gif",
        "image/jpeg",
        "image/pjpeg",
        "image/png",
        "image/svg+xml",
        "image/tiff",
        "image/webp",
        "image/x-icon",
    ];

    console.log("\nfileTypes -> ", fileTypes);
    console.log("\ntypeof fileTypes -> ", typeof fileTypes);

    function validFileType(file) { // file - "File" object (as parameter);
        return fileTypes.includes(file.type); // true / false;  //Array.prototype.includes()
        // check if any value in the fileTypes matches the file's type property
    }

    function returnFileSize(number) { // number - number of bytes, taken from file.size property;
        if (number < 1024) {
            return `${number} bytes`;
        } else if (number >= 1024 && number < 1048576) {
            return `${(number / 1024).toFixed(1)} KB`;
        } else if (number >= 1048576) {
            return `${(number / 1048576).toFixed(1)} MB`;
        }
    }

















</script>