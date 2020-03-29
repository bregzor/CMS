<?php 
function Clean($s)
{
    if (get_magic_quotes_gpc())
    {
        $s = stripslashes($s);
    }
    $s = strip_tags($s);
    return $s;
}
?>