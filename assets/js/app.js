"use strict"

//Shows main form container
const closeButton = (element) => {
	let closeBtn = document.createElement("button");
	closeBtn.innerText = "X";
	closeBtn.classList.add("close-btn");
	closeBtn.classList.add("fadeIn");
	element.append(closeBtn);
	return closeBtn;
}

const drawBlogForm = () => {
	const form = document.querySelector("#addPost");
	if (form.style.display == "none") {
		form.classList.add("fadeIn");
		form.style.display = "flex";
	} else {
		form.style.display = "none";
	}
}

//Handles editview for all forms / only keeps one tab open /
const editView = (id) => {

	let closeBtn = document.createElement("button");
	closeBtn.innerText = "X";
	closeBtn.classList.add("close-btn");
	closeBtn.classList.add("fadeIn");
	//Shows clicked form
	const editForm = document.querySelector(`[data-id='${id}']`)
	if (editForm.style.display === "none") {
		editForm.style.display = "flex";
		editForm.append(closeBtn);
		editForm.previousElementSibling.style.display = "none";
		//Adding possibility to exit edit mode
		closeBtn.addEventListener("click", () => {
			event.preventDefault();
			editForm.classList.toggle("fadeOut");
			setTimeout(() => {
				editForm.style.display = "none";
				editForm.previousElementSibling.style.display = "flex";
				}, 250);
		})

	} else {
		editForm.style.display = "none";
		editForm.previousElementSibling.classList.add("fadeIn");
		editForm.previousElementSibling.style.display = "flex";
	}

	//Closes all forms except current one
	const inactiveForms = document.querySelectorAll(`[data-id]`);
	inactiveForms.forEach(form => {
		const isCurrent = form.dataset.id == id;
		if (!isCurrent) {
			form.style.display = "none";
			form.previousElementSibling.style = "flex";
		}
	});
}

//Deletes element in DOM and database
const deleteView = (id) => {
	const formElement = document.querySelector(`[data-id='${id}']`);
	const formData = new FormData();
	formData.append('ID', id);
	event.preventDefault();
	fetch("./assets/php/delete.php", {
			method: 'POST',
			body: formData
		})
		.then(response => {
			if (response.ok) {
				formElement.previousElementSibling.classList.toggle("fadeOut");
				formElement.classList.toggle("fadeOut");
				setTimeout(() => {
					formElement.previousElementSibling.remove();
					formElement.remove();
				}, 250);
			}
		});
}

//Updates DOM text
const updateText = (data = "", element) => {
	//Finds correct element and sets formdata value..
	for (let i = 0; i < element.children.length; i++) {
		const row = element.children[i];
		switch (row.tagName) {
			case "H2":
				row.innerText = data.get('headline');
				break;

			case "P":
				row.innerText = data.get('textarea');
				break;

			case "IMAGE":
				row.src = data.get('image');
			default:
				break;
		}
	}
}

//Sending updated formdata to backend
const sendEditedFormdata = (id) => {
	const formElement = document.querySelector(`[data-id='${id}']`);
	const file = formElement.children[1].children[1].files[0];
	event.preventDefault();

	console.log(file);

	
	let formData = new FormData(formElement);
	let imagePath = formElement.firstElementChild.getAttribute("src");
	console.log(imagePath);

	formData.append('id', id);
	imagePath = imagePath.replace("/CMS/assets/media/", "");
	formData.append("path", imagePath);

	//For handling files in the future
	//formData.append("file", file);
	if (file.name.length === "UNDEFINED") {
		console.log("yes");
	} 


	//If file is selected use default action instead for fetch..

	if(file.name.length < 1) {
		fetch("./assets/php/edit.php", {
			method: 'POST',
			body: formData
		})
		.then(response => {
			return response.status;
		})
		.then(body => {
			editView(id);
			updateText(formData, formElement.previousElementSibling)
		});

	}
	 

}


document.querySelector('.iconPlusFrame').addEventListener('click', drawBlogForm);
