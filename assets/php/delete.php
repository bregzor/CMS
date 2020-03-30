<?php
require_once 'db.php';

$id = $_POST['ID'];
if (!empty($id))
{       
        $id = htmlspecialchars($id);
        $query = "DELETE FROM posts WHERE ID = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id' , $id);
        $stmt->execute();
    }
?>
