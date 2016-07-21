<?php
$database="ana";

require_once("dbcontroller.php");
require_once("pagination.class.php");


$thistable=$_POST['operatingontable'];


$db_handle = new DBController();
$i=0;
$tabresult = $conn->query ("show tables");



if($_GET['ordertable']==$thistable && $_GET['ordercol']!=""){
//orderby clause should be protected against strange input
	$ordercol=$_GET['ordercol'];
	$orderdir=$_GET['orderdir'];
	if(!$orderdir)$orderdir="desc";
}else{
	$ordercol="id";
	$orderdir="desc";
	}




	$result_cols = mysqli_query($conn, "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$database' AND `TABLE_NAME`='".$thistable."'");
	while($row_cols=mysqli_fetch_array($result_cols)){
		$cols[$thistable][]= $row_cols['COLUMN_NAME'];
	}



$name = "";
$code = "";

$perPage = new PerPage();

$queryCondition = "";


if($thistable==$_GET['searchintable']){

if(!empty($_POST["name"])) {
	$queryCondition .= "WHERE ";
	$cou=0;
foreach($cols[$thistable] as $col){
	if($cou>0) $queryCondition .= " OR ";
	$queryCondition .= "$col like '%". $_POST["name"] . "%'";
	$cou++;
}



#$queryCondition .= " WHERE name LIKE '%" . $_POST["name"] . "%'";

}


//second search argument not in use

// if(!empty($_POST["code"])) {
// if(!empty($queryCondition)) {
	// $queryCondition .= " AND ";
// } else {
	// $queryCondition .= " WHERE ";
// }
// $queryCondition .= " code LIKE '" . $_POST["code"] . "%'";
// }

}//search




$orderby = " ORDER BY $ordercol $orderdir";
$sql = "SELECT * FROM $thistable " . $queryCondition;
$paginationlink = "scripts/getresult.php?searchintable=$thistable&page=";					
$page = 1;
if(!empty($_GET["page"])) {
$page = $_GET["page"];
}

$start = ($page-1)*$perPage->perpage;
if($start < 0) $start = 0;

$query =  $sql . $orderby .  " limit " . $start . "," . $perPage->perpage; 

#for testing uncomment
#echo $query;

$result = $db_handle->runQuery($query);

$rowcount = $db_handle->numRows($sql);
$perpageresult = $perPage->perpage($rowcount, $paginationlink, $thistable);

?>			
			<thead>
					<tr>

<!--list col names-->
					<? $numcols=0; 
					foreach ($cols[$thistable] as $col){
						if($_GET['ordertable']==$thistable && $ordercol==$col && $orderdir=="desc"){
						$neworderdir="asc";
						}else{
						$neworderdir="desc";	
						}
						?>
						<th><a onclick="scripts/getresult('scripts/getresult.php?ordertable=<?echo$thistable;?>&ordercol=<?echo$col;?>&orderdir=<?echo$neworderdir;?>')">
						<?
						if($_GET['ordertable']==$thistable && $ordercol==$col){
						if($orderdir=="asc"){
							?>
							<div class="orderasc"></div>
							<?}else{?>
							<div class="orderdesc"></div>
							<?}
						echo "<u><strong>$col</strong></u>";
						
							
							
						}else{
							echo"<strong>$col</strong>";
						}
						?>
						</a></th>
						<?
						$numcols++;
					}
					?>
					<th>
					<a class="btnAddAction" onclick="add('<?echo$thistable;?>')"></a>
					</th>
					</tr>
			</thead>
			<tbody>
<?php

if(!empty($result)) {
foreach($result as $k=>$v) {
?>
<tr class="row-<?php echo $result[$k]['id']; ?>">
<?
	for($i=0;$i<$numcols;$i++){
?>

<td <?if ($cols[$thistable][$i]<>"id")echo'class="editabletd"';?>contenteditable="false" onBlur="saveToDatabase(this,'<?echo$cols[$thistable][$i];?>',<?php echo $result[$k]['id']; ?>,'<?echo$thistable;?>')" onClick="showEdit(this,<?php echo $result[$k]["id"]; ?>, '<?echo$thistable;?>');">
<?php echo $result[$k][$cols[$thistable][$i]]; ?></td>

<?php
	}//for (numcols)
?>
<td class="action">
<a class="btnEditAction" onClick="allowEdit(<?php echo $result[$k]["id"]; ?>, '<?echo$thistable;?>')"></a> <a class="btnDeleteAction" onClick="del(<?php echo $result[$k]["id"].", '".$thistable."'";?>)"></a>
</td>
</tr>
<?		
}}
if(isset($perpageresult)) {
?>
<tr>
<td colspan="6" align=right> <?php echo $perpageresult; ?></td>
</tr>
<?php } ?>
<tbody>

