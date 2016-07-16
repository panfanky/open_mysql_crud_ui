<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
$result = mysqli_query($conn, "UPDATE $thistable set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"]);
echo"UPDATE $thistable set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"];
?>