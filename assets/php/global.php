<?php



function getDBData($query) {
		require_once "db.php";
		$statement = $db->prepare($query);
		$statement->execute();
		return $statement;
}

function editRow() {}

function uploadImage() {

}

function getPostType($row = "", $mode) {
	$output = "";
	if($mode === "edit") {
		$output = "<form id='addPost' class='admin-form' action='assets/php/addposts.php' style='display:none;'>
		<input type='file' name='' id=''>
		<label for='headline'>Headline<br><input name='headline' type='text'></label><br>
		<label for='text'>Text<br>
		<textarea name='textarea' id='' cols='30' rows='10'></textarea>
		</label>
		<label for='embed'>Add youtube url / map<br>
		<input name='embed' type='text'></label>
		<br>
		<label for='publ'>Publish? <br>
			<input type='checkbox' value='1' name='publ'>
		</label>
		<button type='submit'>Save post</button>
		</form>";	

	} else {
		if($mode === "front") {
			$output =  "<article class='posts posts__item'>
				<img class='posts__item-img' src='./assets/media/bg.jpg' alt=''>
				<h2>". $row["headline"] . "</h2>
				<p>" . $row["textarea"] . "</p>
				<div class='posts__item-embedarea'>" .  $row["embed"] . "</div>
				<span class='posts__item-date'> ". $row["date"] . "</span>
			</article>";	
		} else {
			$output = "
		<article class='posts posts__item admin-form'>
		<section class='admin-form__change-section'><a href='/cms/assets/edit.php?id=". $row["ID"] . "''><i class='fas fa-edit'></i></a><a href='/cms/assets/php/delete.php?id=". $row["ID"] . "'><i class='fas fa-trash-alt'></a></i></section>
		<img class='posts__item-img' src='./assets/media/bg.jpg' alt=''>
		<h2>". $row["headline"] . "</h2>
		<p>" . $row["textarea"] . "</p>
		<div class='posts__item-embedarea'>". $row["embed"] . "</div>
		<span class='posts__item-date'> ". $row["date"] . "</span>
	</article>";	

		}
			}

	return $output;
}


//Handles front and admin draw mode
function drawPosts($mode) {

	$frontQuery = "SELECT * FROM posts WHERE isPublished > 0";
	$adminQuery = "SELECT * FROM posts";

	if($mode === "admin") {
		$stmt = getDBData($adminQuery);
		echo "<section class='adminPostsWrapper'><div class='iconPlusFrame'><i class='fas fa-plus'></i></div>";
		echo getPostType("", "edit");
			
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{	
			echo getPostType($row, "admin");
			}
			echo "</section>";
	} else {
		$stmt = getDBData($frontQuery);
		echo "<section class='posts-wrapper'>
		<div class='posts'>";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo getPostType($row, "front");		
		}
		echo "</div></section>";
	}
}
