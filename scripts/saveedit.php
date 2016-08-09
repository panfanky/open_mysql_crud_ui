<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
$result = mysqli_query($conn, "UPDATE $thistable set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"]);

$result = mysqli_query($conn, "SELECT " . $_POST["column"] . " FROM $thistable WHERE  id=".$_POST["id"]);
$row=mysqli_fetch_array($result);
echo $row[$_POST['column']];
?>