<?php
class DBController {
	private $host = "localhost";
	private $user = "ana";
	private $password = "Nik0muT0Nerikej";
	private $database = "ana";
	
	function __construct() {
		global $conn;
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		global $conn;
		$conn = new mysqli($this->host,$this->user,$this->password);
		return $conn;
	}
	
	function selectDB($conn) {
		mysqli_select_db($conn,$this->database);
	}
	
	function runQuery($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		global $conn;
		$result  = mysqli_query($conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
?>