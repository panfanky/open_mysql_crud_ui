<?php

// this app has been removed


$thistable=$_GET['thistable'];
require_once("dbcontroller.php");
$db_handle = new DBController();
$result = mysqli_query($conn, "SELECT * FROM $thistable WHERE id='" . $_GET["id"] . "'");
?>
<td colspan=6 class="edit-form">
<form name="frmToy" method="post" action="" id="frmToy">
<div>
<label style="padding-top:20px;">Name</label>
<span id="name-info" class="info"></span><br/>
<input type="text" name="name" id="add-name" class="demoInputBox" value="<?php echo $result[0]["name"]; ?>">
</div>
<div>
<label>Code</label>
<span id="code-info" class="info"></span><br/>
<input type="text" name="code" id="add-code" class="demoInputBox" value="<?php echo $result[0]["code"]; ?>">
</div>
<div>
<label>Category</label> 
<span id="category-info" class="info"></span><br/>
<input type="text" name="category" id="category" class="demoInputBox" value="<?php echo $result[0]["category"]; ?>">
</div>
<div>
<label>Price</label> 
<span id="price-info" class="info"></span><br/>
<input type="text" name="price" id="price" class="demoInputBox" value="<?php echo $result[0]["price"]; ?>">
</div>
<div>
<label>Stock Count</label> 
<span id="stock_count-info" class="info"></span><br/>
<input type="text" name="stock_count" id="stock_count" class="demoInputBox" value="<?php echo $result[0]["stock_count"]; ?>">
</div>
<div>
<input type="button" name="submit" id="btnAddAction" value="Save" onClick="edit(<?php echo $result[0]["id"].", '$thistable'"; ?>);" />
</div>
</form>
</td>