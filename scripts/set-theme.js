
    whiteBtn = document.getElementById("white");
    blackBtn = document.getElementById("black");

    body = document.body
    header = document.getElementById("header");
    divCart = document.getElementsByClassName("top-nav-right");
    content = document.getElementById("content");
    mcontent = document.getElementById("main-content");
    books = Array.from(document.querySelectorAll(".book"));

    if(content) {
        console.log("content -> ", content);
    }

function setBlackTheme() {
    header.style.backgroundColor = "#565656FF";
    divCart[0].style.color = "#ffffff";
    if(content) {
        content.style.backgroundColor = "#565656";
        content.style.color = "#ffffff";
    }
    if(mcontent) {
        mcontent.style.backgroundColor = "#565656";
        mcontent.style.color = "#ffffff";
    }

    body.style.backgroundImage = "url('../assets/3.png')";

    for (let i = 0; i < books.length; i++) {
        books[i].style.color = '#000000';
    }

    localStorage.setItem("theme", "black");
}

function setWhiteTheme() {
    header.style.backgroundColor = "#dedede";
    divCart[0].style.color = "#575757";

    if(content) {
        content.style.backgroundColor = "#e6e6e6";
        content.style.color = "#000000";
    }

    if(mcontent) {
        mcontent.style.backgroundColor = "#e6e6e6";
        mcontent.style.color = "#000000";
    }

    body.style.backgroundImage = "url('../assets/2.png')";

    for (let i = 0; i < books.length; i++) {
        books[i].style.color = '#000000';
    }

    localStorage.setItem("theme", "white");
}

