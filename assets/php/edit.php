<?php
//includes header html
include "header.php";
//adding database login info to be used in obect connection
require_once "db.php";
//including a function that sanitises input
include "clean.php";

//Sanitizes parameters from url
$ID = Clean($_GET['id']);
$orgTitle = Clean($_GET['title']);
$orgDirector = Clean($_GET['director']);
$orgYear = Clean($_GET['year']);
$catID	= Clean($_GET['cat']);

if (!empty($ID))
{
  //if declared or not empty
    if (isset($_POST['title']) && isset($_POST['director']) && isset($_POST['year']))
    {
        //Creating new object connection
        $mycon = new mysqli($host, $username, $password, $database);
        //preparing query with placeholders
        $stmt = $mycon->prepare("
		    UPDATE `movies` 
		    SET `title` = ?, `director` = ?, `year` = ?, `c_id` = ?
		    WHERE `movies`.`ID` = ?");
        //Sanitizes input from malicious content
        $utitle = Clean($_POST['title']);
        echo $utitle;
        $udirector = Clean($_POST['director']);
        $uyear = Clean($_POST['year']);
        $uc_id = Clean($_POST['movie']);
        //binding variables to query
        $stmt->bind_param('ssiii', $utitle, $udirector, $uyear, $uc_id, $ID);
        //executes query
        $stmt->execute();
        //Sending back user to startpage
        header("Location: index.php");
        }
      }
?>
<body>
<table><tr><td><form method="post">
	<h2>Update item </h2>
 <input type='text' name='title' <?php echo "value='". $orgTitle . "'"; ?> >
 <input type='text' name='director' <?php echo "value='". $orgDirector  . "'"; ?> >
 <input type='text' name='year' <?php echo "value='". $orgYear  . "'"; ?> >
 <br>
  <input type="radio" name="movie" value="0" <?php if ($catID == 0) echo "checked='checked'"; //Assigns checked value to radiobutton ?> required="required"><b>Thriller</b>
	<input type="radio" name="movie" value="1" <?php /*Assigns checked value based on category ID value */ if ($catID == 1) echo "checked='checked'"; ?>  required="required"><b>Romantic</b>
	<input type="radio" name="movie" value="2" <?php if ($catID == 2) echo "checked='checked'"; ?> required="required"><b>Swedish</b>
	<input type="radio" name="movie" value="3" <?php if ($catID == 3) echo "checked='checked'"; ?>  required="required" ><b>Animated</b>
	<input type="radio" name="movie" value="4" <?php if ($catID == 4) echo "checked='checked'"; ?>  required="required" ><b>Comedy</b>
  	<input type="submit" name="save" value="Update">
</form></td></tr></table>
  
</body>

</html>