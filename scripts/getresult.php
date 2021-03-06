<?php
require_once("dbcontroller.php");
require_once("pagination.class.php");


//list tables

$db_handle = new DBController();
$i=0;
$tabresult = $conn->query ("show tables");

//for each table
while($row=$tabresult->fetch_row()){

$thistable=$row[0];
$omit="no";
if($_GET['onlytables']){
	$onlytables=explode(",",$_GET['onlytables']);
	if(!in_array($thistable, $onlytables)) $omit="yes";
	
}
if($omit=="no"){

if($_GET['ordertable']==$thistable && $_GET['ordercol']!=""){
//orderby clause should be protected against strange input
	$ordercol=$_GET['ordercol'];
	$orderdir=$_GET['orderdir'];
	if(!$orderdir)$orderdir="desc";
	$orderby = " ORDER BY $ordercol $orderdir";
}else{
	
//find primary
$keyres=$conn->query("SELECT `COLUMN_NAME`
FROM `information_schema`.`COLUMNS`
WHERE (`TABLE_SCHEMA` = '$database')
  AND (`TABLE_NAME` = '$thistable')
  AND (`COLUMN_KEY` = 'PRI')");
$r=mysqli_fetch_array($keyres);
	
	$ordercol=$r['COLUMN_NAME'];
	$orderdir="desc";
}

$orderby = " ORDER BY $ordercol $orderdir";



echo "<h2>$thistable</h2>";
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
}

$sql = "SELECT * FROM $thistable " . $queryCondition;
$paginationlink = "scripts/getresult.php?onlytables=".$_GET['onlytables']."&searchintable=$thistable&page=";	
$page = 1;
if(!empty($_GET["page"])&&$thistable==$_POST['operatingontable']) {
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
<form id="frmSearch<?echo$thistable;?>" name="frmSearch<?echo$thistable;?>" method="post" action="index.php">
			<div class="search-box">
			<p><input type="hidden" id="rowcount" name="rowcount" value="<?php echo $_GET["rowcount"]; ?>" /><input type="text" placeholder="Search" name="name" class="name demoInputBox" value="<? if($thistable==$_GET['searchintable']) echo $_POST['name']; ?>"	/>
			<!--
			former script supported searching in more fields but not live
			<input type="text" placeholder="Code" name="code" class="code demoInputBox" value="<?php echo $code; ?>"	/>
			<input type="button" name="go" class="btnSearch" value="Search" onclick="getresult('<?php echo 'scripts/getresult.php'.$paginationlink . $page; ?>&searchintable=<?echo$thistable;?>', '<?echo$thistable;?>')"><input type="reset" class="btnSearch" value="Reset" onclick="window.location='index.php'"></p>
			-->
			
			</div>
			
			<table id="tablecalled<?echo$thistable;?>" class="tbl" cellpadding="10" cellspacing="1">
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
						<th><a onclick="scripts/getresult('scripts/getresult.php?onlytables=<?echo$_GET['onlytables'];?>&ordertable=<?echo$thistable;?>&ordercol=<?echo$col;?>&orderdir=<?echo$neworderdir;?>')">
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

//PRESUPPOSES THE FIRST COL IS PRIMARY KEY!
$primary=reset($result[$k]);

?>
<tr class="row-<?php echo $primary; ?>">
<?
	for($i=0;$i<$numcols;$i++){


//don't split td and /td into lines	
?>
<td <?if ($cols[$thistable][$i]<>"id")echo'class="editabletd"';?>contenteditable="false" onBlur="saveToDatabase(this,'<?echo$cols[$thistable][$i];?>','<?php echo $primary; ?>','<?echo$thistable;?>')" onClick="showEdit(this,'<?php echo $primary; ?>', '<?echo$thistable;?>');"><?php echo nl2br($result[$k][$cols[$thistable][$i]]); ?></td>

<?php
	}//for (numcols)
?>
<td class="action">
<a class="btnEditAction" onClick="allowEdit('<?php echo $primary; ?>', '<?echo$thistable;?>')"></a> <a class="btnDeleteAction" onClick="del('<?php echo $primary;?>', '<?echo$thistable;?>')"></a>
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
</table>
</form>	

<script>
$('<?echo"#frmSearch$thistable";?> .name').keyup(function(){
	gettable('scripts/gettable.php?searchintable=<?echo$thistable;?>', '<?echo$thistable;?>', searchfocus('<?echo$thistable;?>'));
	
});

</script>

<?
}// omit=no
//listing tables end
$i++;
}

?>
