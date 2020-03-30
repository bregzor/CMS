<?php

function getDBData($query) {
		require_once "db.php";
		$statement = $db->prepare($query);
		$statement->execute();
		return $statement;
}

//Makes sure that published checkbox is selected
function isPublished($row) {
	$checked = "";
	if($row["isPublished"] >0 ) {
		$checked = "checked";
	} else {
		$checked = $checked;
	}
}

//Adds extra p tag for each rowbreak in string
function paragraphPerRowbreak($row) {
	$output = "";
	if(strpos($row["textarea"], PHP_EOL) !== FALSE) {
		$output = "";
	  }
	  else {
		$output = "";
	  }
}

//Gets correct admin and user elements (front,admin)
function getPostType($row = "", $mode) {
	$output = "";
	$postForm = "<form id='addPost' data-id='".  $row["ID"] . "' class='admin-form' action='assets/php/addposts.php'  method='POST' enctype='multipart/form-data'  style='display:none;'>
		<input type='file' name='' id=''>
		<label for='headline'><span>Headline</span><br><input name='headline' type='text'></label><br>
		<label for='text'><span>Text</span><br>
		<textarea name='textarea' id='' cols='30' rows='10'></textarea></label>
		<label for='embed'><span>Add youtube url / map</span><br>
		<textarea name='embed' id='' cols='30' rows='5'></textarea></label>
			<br>
		<label for='publ'><span>Publish?</span> <br>
		<input type='checkbox' value='1' name='publ'>
		</label>
		<button type='submit' name='savePost'>Save post</button>
		</form>";

		$editPostForm = "
		<form id='addPost' data-id='".  $row["ID"] . "' class='admin-form' action='assets/php/addposts.php' style='display:none;'>
			<input type='file' name='image' id='image'>
			<label for='headline'>
				<span>Headline</span><br>
				<input name='headline' type='text' value='" . $row["headline"] . " '>'
			</label><br>
			<label for='text'><span>Text</span><br>
				<textarea name='textarea' id='' cols='30' rows='10' value=''>" . $row["textarea"] . "</textarea>
			</label>
			<label for='embed'><span>Add youtube url / map</span><br>
				<textarea name='embed' id='' cols='30' rows='5'>" . $row["embed"] . "</textarea>¨
			</label>
			<br>
			<label class='admin-form-published' for='publ'><span>Publish?</span>
				<input type='checkbox' value='1' checked='". isPublished($row) . "' name='publ'>
			</label>
			<button type='submit' onclick='sendEditedFormdata(". $row["ID"] . ")'>UPDATE POST	</button>
		</form>";

	if($mode === "edit") {
		$output = $postForm;
	} else {
		if($mode === "front") {
			$output =  
				"<article class='posts posts__item'>
					<img class='posts__item-img' src='/CMS/assets/media/" . $row["image"] . "' alt=''>
					<h2>". $row["headline"] . "</h2>
					<p>" . $row["textarea"] . "</p>
					<div class='posts__item-embedarea'>" .  $row["embed"] . "</div>
					<span class='posts__item-date'> ". $row["date"] . "</span>
			</article>";	
		} else {
			$output = "
			<article class='posts posts__item admin-form'>
			<section class='admin-form__change-section'><a onclick='editView(". $row["ID"] . ")'href='javascript:void(0)'><i class='fas fa-edit'></i></a><a href='/cms/assets/php/delete.php?id=". $row["ID"] . "'><i class='fas fa-trash-alt'></a></i></section>
				<img class='posts__item-img' src='/CMS/assets/media/" . $row["image"] . "' alt=''>
				<h2>". $row["headline"] . "</h2>
				<p>" . $row["textarea"] . "</p>
				<div class='posts__item-embedarea'>".$row["embed"]."</div>
				<span class='posts__item-date'> ". $row["date"] . "</span>
			</article>
			$editPostForm";	
		}
	}
	return $output;
}

//Handles front and admin draw mode
function drawPosts($mode) {

	$frontQuery = "SELECT * FROM posts WHERE isPublished > 0 ORDER BY ID DESC";
	$adminQuery = "SELECT * FROM posts";

	$adminSection = "<section class='adminPostsWrapper'><div class='iconPlusFrame'><i class='fas fa-plus'></i></div>"; 
	$frontSection = "<section class='posts-wrapper'><div class='posts'>";

	if($mode === "admin") {
		$stmt = getDBData($adminQuery);
		echo $adminSection; 
		echo getPostType("", "edit");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{	
			echo getPostType($row, "admin");
		}

	} else {
		$stmt = getDBData($frontQuery);
		echo $frontSection;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
				echo getPostType($row, "front");		
		}
		echo "</div></section>";
	}
}
