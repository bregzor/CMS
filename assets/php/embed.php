<?php
function embed()
{
    require 'db.php';
    if (isset($_POST['embed']) !== "") {
        // Find elements
        ob_start();
        $embeddedCode = $_POST['embed'];
        echo $embeddedCode;
        // Get embeddedCode
        $output = ob_get_contents();
        ob_end_clean();
        // Find every iframe element   
        preg_match_all('/<iframe[^>]+src="([^"]+)"/', $output, $match);
        $urls = $match[1];
        $src = $urls[0];
        return "<iframe src='$src' width='560' height='315' allowfullscreen frameborder='0'></iframe>";
    }
}
