<?php 

require_once 'db.php';
include 'imageupload.php';

$headline  = htmlspecialchars($_POST["headline"]);
$text  = htmlspecialchars($_POST["textarea"]);
$isPublished = htmlspecialchars($_POST{"publ"});
$embed  = htmlspecialchars($_POST["embed"]);
$image = "";
$date = date("F d, Y h:i:s");
$id = htmlspecialchars($_POST["ID"]);
$file = htmlspecialchars($_POST["file"]);

//Using fetch when only updating text, when uploading file should return as a regular POST
$useFetch = false;
// if(!empty($file)) {
//     $image =  htmlspecialchars($_POST["path"]);
// } else {
//     $image = uploadImage();
//     $useFetch = false;
// }

if(isset($_POST["headline"])) {

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
header('Location:../../admin.php');


}

if(!$useFetch) {
   header('Location:../../admin.php');
}
?>