<?php 

require_once 'db.php';
include 'clean.php';

if(isset($_GET["headline"])) {
      $headline  = Clean($_GET["headline"]);
      $text  = Clean($_GET["textarea"]);
      $isPublished = Clean($_GET{"publ"});
      $embed  = Clean($_GET["embed"]);
      $image = "path";
      $date = date("F d, Y h:i:s");
    
      $query = "INSERT INTO posts (headline, textarea, image, isPublished, embed, date)
              VALUES ( :headline , :textarea, :image, :isPublished, :embed, :date ) ";
    
      $stmt = $db->prepare($query);
      $stmt->bindParam(':headline' , $headline);
      $stmt->bindParam(':textarea'  , $text);
      $stmt->bindParam(':image'  ,  $image);
      $stmt->bindParam(':isPublished'  , $isPublished);
      $stmt->bindParam(':embed'  , $embed);
      $stmt->bindParam(':date'  , $date);
      $stmt->execute();
      header('Location:../../admin.php');
    }

  ?>