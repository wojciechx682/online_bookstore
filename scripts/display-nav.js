
function displayNav() {
	// const nav = document.getElementById("nav");
	// const content = document.getElementById("content");
	// nav.style.display = "block";
	// nav.style.width = "25%";
	// content.style.width = "75%";

	// const nav = $("#nav");
	// const content = $("#content");
	// nav.css("display", "block");
	// nav.css("width", "25%");
	// content.css("width", "75%");

	const nav = document.querySelector("#nav");
	const content = document.querySelector("#content");
	const mcontent = document.querySelector("#main-content");
	//const main_content = document.getElementById("main-content");

	console.log("nav -> ", nav);
	console.log("content -> ", content);
	console.log("main content -> ", mcontent);

	nav.classList.add("nav-visible");
	content.classList.add("content-short");
	mcontent.classList.add("content-invisible");

	// main_content.style.display = "none";
}