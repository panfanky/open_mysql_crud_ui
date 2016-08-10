<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();

//find primary
$keyres=$conn->query("SELECT `COLUMN_NAME`
FROM `information_schema`.`COLUMNS`
WHERE (`TABLE_SCHEMA` = '$database')
  AND (`TABLE_NAME` = '$thistable')
  AND (`COLUMN_KEY` = 'PRI')");
$r=mysqli_fetch_array($keyres);


$result = mysqli_query($conn, "UPDATE $thistable set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE ".$r['COLUMN_NAME']."='".$_POST["id"]."'");

$result = mysqli_query($conn, "SELECT " . $_POST["column"] . " FROM $thistable WHERE ".$r['COLUMN_NAME']."='".$_POST["id"]."'");
$row=mysqli_fetch_array($result);
echo $row[$_POST['column']];
?>