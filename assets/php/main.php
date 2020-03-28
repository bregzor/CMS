<?php
include($root . 'drawposts.php');
$path = $_SERVER['REQUEST_URI'];

if (strpos($path, 'admin') !== false) {
    $mainOutput = 
    "<section class='posts-wrapper'>
                <div class='posts'>
                     " . drawPosts("admin")  . "</div>
            </section>
    ";
    
} else {
    $mainOutput = 
    "<section class='posts-wrapper'>
                <div class='posts'>
                     " . drawPosts("front")  . "</div>
            </section>
    ";
}
echo $mainOutput . "</main>";
?>