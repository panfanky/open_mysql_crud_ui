<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
if($result = mysqli_query($conn,"INSERT INTO `$thistable` () VALUES()")) echo mysqli_insert_id($conn);

?>