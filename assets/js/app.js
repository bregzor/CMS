const drawBlogForm = () => {
	const form = document.querySelector("#addPost");
	if (form.style.display == "none") {
		form.style.display = "flex";
		//For transitions
		//form.classList.add("");
	} else {
		form.style.display = "none";
		//form.classList.remove("");
	}
}


const showEditForm = () => {
		//Edit vyn för admin > fetcha mot edit.php
}


document.querySelector('.iconPlusFrame').addEventListener('click', drawBlogForm);




