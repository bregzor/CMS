<?php 

require_once 'db.php';
require 'clean.php';

$headline  = Clean($_POST["headline"]);
$text  = Clean($_POST["textarea"]);
$isPublished = Clean($_POST{"publ"});
$embed  = Clean($_POST["embed"]);
$image = "path";
$date = date("F d, Y h:i:s");
$id = Clean($_POST["id"]);

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