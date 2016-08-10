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


if(!empty($_GET["id"])) {
	if($result = mysqli_query($conn,"DELETE FROM ".$thistable." WHERE ".$r['COLUMN_NAME']."='".$_GET["id"]."'")) echo "deleted";
}
?>