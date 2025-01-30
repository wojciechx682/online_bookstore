function displayNav() {

	const nav = document.querySelector("#nav");
	const content = document.querySelector("#content");
	const mcontent = document.querySelector("#main-content");

	nav.classList.add("nav-visible");
	content.classList.add("content-short");

	if(mcontent) {
		mcontent.classList.add("content-invisible");
	}
}