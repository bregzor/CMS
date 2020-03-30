<?php

function uploadImage(){
  require 'db.php';
  if(isset($_POST['savePost'])){

    // Get images
    $images = $_FILES['image']['name'];

    // Temporary directory in php.ini
    $tmp_dir = $_FILES['image']['tmp_name'];

    // What the files should be put (MEDIA folder)
    $media_dir = $_SERVER['DOCUMENT_ROOT']. '/CMS/assets/media/';

    // Get image type and check if its valid
    $imgExt = strtolower(pathinfo($images,PATHINFO_EXTENSION));
    
    $imageName = rand(1000, 1000000).".". $imgExt;
    move_uploaded_file($tmp_dir, $media_dir.$imageName);

    // To bind and execute
    return $imageName;

  }
}