<?php
include($root . 'global.php');
$path = $_SERVER['REQUEST_URI'];

if (strpos($path, 'admin') !== false) {
    $mainOutput = drawPosts("admin");
      
} else {
    $mainOutput = drawPosts("front");
  }

echo $mainOutput . "</main>";
?>