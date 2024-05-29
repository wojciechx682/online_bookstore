function showCategories() {

    let list = document.getElementById("categories-list");
    let sublist = document.getElementById("subcategories-list");
    if(list.style.display === "block") {
        list.style.display = "none";
        sublist.style.display = "none";
    } else {
        list.style.display = "block";
        sublist.style.display = "block";
    }
}

let categoryButton = document.getElementById("a-categories-top-nav");

function isMobileDevice() {
    return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
if (isMobileDevice()) {
    categoryButton.addEventListener("click", showCategories);
}

if(isMobileDevice()) {
    let styleSheet = document.styleSheets[0];

    for (let i = 0; i < styleSheet.cssRules.length; i++) {
        let rule = styleSheet.cssRules[i];
        if (rule.selectorText === "#n-top-nav-content ol li ul") {
            rule.style.visibility = "unset";
            rule.style.display = "none";
        } else if (rule.selectorText === "#n-top-nav ol > li:hover > ul") {
            rule.style.visibility = "visible";
        }
    }
}