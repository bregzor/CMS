<?php

function getDBData($query) {
		require_once "db.php";
		$statement = $db->prepare($query);
		$statement->execute();
		return $statement;
}


function isPublished($row) {
	$checked = "";
	if($row["isPublished"] >0 ) {
		$checked = "checked";
	} else {
		$checked = $checked;
	}
}

function getPostType($row = "", $mode) {
	$output = "";


	$postForm = "<form id='addPost' data-id='".  $row["ID"] . "' class='admin-form' action='assets/php/addposts.php' style='display:none;'>
		<input type='file' name='' id=''>
		<label for='headline'>Headline<br><input name='headline' type='text'></label><br>
		<label for='text'>Text<br>
		<textarea name='textarea' id='' cols='30' rows='10'></textarea></label>
		<label for='embed'>Add youtube url / map<br>
		<textarea name='embed' id='' cols='30' rows='5'></textarea></label>
			<br>
		<label for='publ'>Publish? <br>
		<input type='checkbox' value='1' name='publ'>
		</label>
		<button type='submit'>Save post</button>
		</form>";

		$editPostForm = "<form id='addPost' data-id='".  $row["ID"] . "' class='admin-form' action='assets/php/addposts.php' style='display:none;'>
		<input type='file' name='' id=''>
		<label for='headline'>Headline<br><input name='headline' type='text' value='" . $row["headline"] . " '></label><br>
		<label for='text'>Text<br>
		<textarea name='textarea' id='' cols='30' rows='10' value=''>" . $row["textarea"] . "</textarea></label>
		<label for='embed'>Add youtube url / map<br>
		<textarea name='embed' id='' cols='30' rows='5'>" . $row["embed"] . "</textarea></label>
			<br>
		<label for='publ'>Publish? <br>
		<input type='checkbox' value='1' checked='". isPublished($row) . "' name='publ'>
		</label>
		<button type='submit' onclick='sendEditedFormdata(". $row["ID"] . ")'>Update post</button>
		</form>";

	if($mode === "edit") {
		$output = $postForm;
	} else {
		if($mode === "front") {
			$output =  
				"<article class='posts posts__item'>
					<img class='posts__item-img' src='./assets/media/bg.jpg' alt=''>
					<h2>". $row["headline"] . "</h2>
					<p>" . $row["textarea"] . "</p>
					<div class='posts__item-embedarea'>" .  $row["embed"] . "</div>
					<span class='posts__item-date'> ". $row["date"] . "</span>
			</article>";	
		} else {
			$output = "
			<article class='posts posts__item admin-form'>
			<section class='admin-form__change-section'><a onclick='editView(". $row["ID"] . ")'href='javascript:void(0)'><i class='fas fa-edit'></i></a><a href='/cms/assets/php/delete.php?id=". $row["ID"] . "'><i class='fas fa-trash-alt'></a></i></section>
				<img class='posts__item-img' src='./assets/media/bg.jpg' alt=''>
				<h2>". $row["headline"] . "</h2>
				<p>" . $row["textarea"] . "</p>
				<div class='posts__item-embedarea'>".$row["embed"]."</div>
				<span class='posts__item-date'> ". $row["date"] . "</span>
			</article>
			$editPostForm;
		";	

		}
			}
	return $output;
}

//$path = "/CMS/assets/php/edit.php?id=". $row["ID"] . "'";

//Handles front and admin draw mode
function drawPosts($mode) {

	$frontQuery = "SELECT * FROM posts WHERE isPublished > 0 ORDER BY ID DESC";
	$adminQuery = "SELECT * FROM posts";

	if($mode === "admin") {
		$stmt = getDBData($adminQuery);
		echo "<section class='adminPostsWrapper'><div class='iconPlusFrame'><i class='fas fa-plus'></i></div>";
		echo getPostType("", "edit");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{	
			echo getPostType($row, "admin");
			}

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
