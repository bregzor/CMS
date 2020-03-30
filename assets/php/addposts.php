<?php

require_once 'db.php';
include 'imageupload.php';

if (isset($_POST["headline"])) {
  $headline  = htmlspecialchars($_POST["headline"]);
  $text  = htmlspecialchars($_POST["textarea"]);
  $isPublished = htmlspecialchars($_POST["publ"]);
  $embed  = htmlspecialchars($_POST["embed"]);
  $image = uploadImage();
  $date = date("F d Y h:i:s");

  $query = "INSERT INTO posts (headline, textarea, image, isPublished, embed, date)
              VALUES ( :headline , :textarea, :image, :isPublished, :embed, :date ) ";

  $stmt = $db->prepare($query);
  $stmt->bindParam(':headline', $headline);
  $stmt->bindParam(':textarea', $text);
  $stmt->bindParam(':image', $image);
  $stmt->bindParam(':isPublished', $isPublished);
  $stmt->bindParam(':embed', $embed);
  $stmt->bindParam(':date', $date);
  // uploadImage();
  if ($stmt->execute()) {
?>
    <script>
      alert('New file uploaded');
    </script>
  <?php
  } else {
  ?>
    <script>
      alert('Error');
    </script>
<?php
  }
  header('Location:../../admin.php');
}

?>