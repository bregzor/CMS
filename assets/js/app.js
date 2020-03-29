const drawBlogForm = () => {
	const form = document.querySelector("#addPost");
	if (form.style.display == "none") {
		form.style.display = "flex";
	} else {
		form.style.display = "none";
	}
}

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

const sendEditedFormdata = (id) => {
	let formData = new FormData(document.querySelector(`[data-id='${id}']`))
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
		});

}

const deleteRow = (id) => {
	let formData = new FormData(document.querySelector(`[data-id='${id}']`))
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
		});
}

document.querySelector('.iconPlusFrame').addEventListener('click', drawBlogForm);