<?php 

require_once 'db.php';

$headline  = htmlspecialchars($_POST["headline"]);
$text  = htmlspecialchars($_POST["textarea"]);
$isPublished = htmlspecialchars($_POST{"publ"});
$embed  = htmlspecialchars($_POST["embed"]);
$image = "path";
$date = date("F d, Y h:i:s");
$id = htmlspecialchars($_POST["id"]);

$update = "UPDATE posts 
    SET 
	    headline = :headline,
        textarea = :textarea,
        image = :image,
        isPublished = :isPublished,
        embed = :embed,
        date = :date
WHERE
    ID = :id";

$stmt = $db->prepare($update);
$stmt->bindParam(':headline' , $headline);
$stmt->bindParam(':textarea'  , $text);
$stmt->bindParam(':image'  ,  $image);
$stmt->bindParam(':isPublished'  , $isPublished);
$stmt->bindParam(':embed'  , $embed);
$stmt->bindParam(':date'  , $date);
$stmt->bindParam(':id' , $id);
$stmt->execute();
echo "row updated!";
?>