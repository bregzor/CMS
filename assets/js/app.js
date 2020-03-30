//Shows main form container
const drawBlogForm = () => {
	const form = document.querySelector("#addPost");
	if (form.style.display == "none") {
		form.style.display = "flex";
		//form.classList.add("grow-post");
	} else {
		form.style.display = "none";
	}
}


//Handles editview for all forms / only keeps one tab open /
const editView = (id) => {
	const editForm = document.querySelector(`[data-id='${id}']`)
	if (editForm.style.display === "none") {
		editForm.style.display = "flex";
		editForm.previousElementSibling.style.display = "none";
	} else {
		editForm.style.display = "none";
		editForm.previousElementSibling.style.display = "flex";
	}
	const inactiveForms = document.querySelectorAll(`[data-id]`);
	inactiveForms.forEach(form => {
		const isCurrent = form.dataset.id == id;
		if (!isCurrent) {
			form.style.display = "none";
			form.previousElementSibling.style = "flex";
		}
	});
}

const deleteRow = (id) => {
}

const updateText = (data = "", element) => {
	console.log("editet data");
	for (let i = 0; i < element.children.length; i++) {
		const row = element.children[i];
		//Update elements here
	}
}

//Sending update data to backend edit.php
const sendEditedFormdata = (id) => {
	const formElement = document.querySelector(`[data-id='${id}']`);
	let formData = new FormData(formElement);
	formData.append('id', id);
	event.preventDefault();
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


document.querySelector('.iconPlusFrame').addEventListener('click', drawBlogForm);
