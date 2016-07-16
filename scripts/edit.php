<?php
$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
mysql_query("UPDATE $thistable set name = '".$_POST["name"]."', code = '".$_POST["code"]."', category = '".$_POST["category"]."', price = '".$_POST["price"]."', stock_count = '".$_POST["stock_count"]."' WHERE  id=".$_GET["id"]);
$result = $db_handle->runQuery("SELECT * FROM $thistable WHERE id='" . $_GET["id"] . "'");
?>
<td class="name"><?php echo $result[0]["name"]; ?></td>
<td class="code"><?php echo $result[0]["code"]; ?></td>
<td class="category"><?php echo $result[0]["category"]; ?></td>
<td class="price"><?php echo $result[0]["price"]; ?></td>
<td class="stock_count"><?php echo $result[0]["stock_count"]; ?></td> 
<td class="action">
<a class="btnEditAction" onClick="showEdit(<?php echo $_GET["id"]; ?>)">Edit</a> <a class="btnDeleteAction" onClick="del(<?php echo $_GET["id"]; ?>)">Delete</a>
</td>