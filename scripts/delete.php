<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["id"])) {
	if($result = mysqli_query($conn,"DELETE FROM ".$thistable." WHERE id=".$_GET["id"])) echo "deleted";
}
?>