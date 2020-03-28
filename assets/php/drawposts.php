<?php

//Handles front and admin draw mode
function drawPosts($mode) {
	require_once "db.php";

	$frontQuery = "SELECT * FROM posts WHERE isPublished > 0";
	$adminQuery = "SELECT * FROM posts";

	if($mode == "admin") {
		$stmt = $db->prepare($adminQuery);
		$stmt->execute();
		echo "<form class='admin-form' action='addposts.php' action='post'>";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{	
			echo "
			<input type='file' name='' id=''>
			<label for='headline'>Headline<input name='headline' type='text'></label>
			<label for='text'>Text
			<textarea name='text' id='' cols='30' rows='10'></textarea>
			</label>";

			}
			echo "</form>";
	} else {
		$stmt = $db->prepare($frontQuery);
		$stmt->execute();
	
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<article class='posts posts__item'>
				<img class='posts__item-img' src='' alt=''>
				<h2>". $row["headline"] . "</h2>
				<p>" . $row["textarea"] . "</p>
				<div class='posts__item-embedarea'></div>
			</article>";		
		}
	}
}



?>