<?php
require_once ('db.php');
include "clean.php";

$mycon = new mysqli($host, $username, $password, $database);
//gets id parameter from url
$id = $_GET['id'];

// If not empty, cleaning id value and deleting row from datebase with preped statement
if (!empty($id))
{
    $id = Clean($id);
    $statement = $mycon->prepare("DELETE FROM movies WHERE id=?");
    $statement->bind_param('i', $id);
    $statement->execute();
}

//Sending user back to startpage
header("Location: index.php");

?>
