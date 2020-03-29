<?php
require_once 'db.php';
include "clean.php";

$id = $_GET['id'];

if (!empty($id))
{       
        $id = Clean($id);
        $query = "DELETE FROM posts WHERE ID = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id' , $id);
        $stmt->execute();
    }

header("Location: ../../admin.php");

?>
