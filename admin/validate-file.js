
// edit-book.php, add-book.php
// JS file to validate uploaded file in input type="file";

// input type file - validation and sanitization (JS);
// https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file ;

let input = document.querySelector('input[type="file"]');
let div = document.querySelector('.preview');

input.addEventListener("change", validateImage);

function validateImage() {

    while(div.firstChild) {
        div.removeChild(div.firstChild); // clear current content of div ".preview";
    }

    let curFiles = input.files; // FileList object - contains information about file;

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
            if (validFileType(file)) { // check if file is in proper img type (accept)
                p.innerHTML = `Nazwa pliku - ${file.name}`+"<br>";
                p.innerHTML += `Rozmiar - ${returnFileSize(file.size)}`;
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file); // generate a thumbnail preview of the image;
                    li.appendChild(image);
                li.appendChild(p);
            } else { // file not valid - validFileType() - not valid image type;
                p.innerHTML = `Nazwa pliku - ${file.name} <br> Nieprawidłowy typ pliku. Wybierz inny`;
                li.appendChild(p);
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
    "image/png"
];

function validFileType(file) {
    // check if file is correct type (e.g. the image types specified in the accept attribute);
    // takes a File object as a parameter, then uses Array.prototype.includes() to check if any value in the fileTypes matches the file's type property. If a match is found, the function returns true. If no match is found, it returns false.
    return fileTypes.includes(file.type);
}

function returnFileSize(number) {
    // returns a nicely-formatted version of the size in bytes/KB/MB (by default the browser reports the size in absolute bytes).
    // number - number (of bytes, taken from the current file's size property);
    if (number < 1024) {
        return `${number} bytes`;
    } else if (number >= 1024 && number < 1048576) {
        return `${(number / 1024).toFixed(1)} KB`;
    } else if (number >= 1048576) {
        return `${(number / 1048576).toFixed(1)} MB`;
    }
}
