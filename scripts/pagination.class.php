<?php
class PerPage {
	public $perpage;
	
	function __construct() {
		$this->perpage = 2;
	}
	
	function perpage($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if(($_GET["page"]-3)>0) {
				if($_GET["page"] == 1)
					$output = $output . '<span id=1 class="current-page">1</span>';
				else				
					$output = $output . '<input type="button" class="perpage-link" onclick="getresult(\'' . $href . '1\')" value=1 />';
			}
			if(($_GET["page"]-3)>1) {
					$output = $output . '...';
			}
			
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_GET["page"] == $i)
					$output = $output . '<span id='.$i.' class="current-page">'.$i.'</span>';
				else				
					$output = $output . '<input type="button" class="perpage-link" onclick="getresult(\'' . $href . $i . '\')"  value=' . $i . ' />';
			}
			
			if(($pages-($_GET["page"]+2))>1) {
				$output = $output . '...';
			}
			if(($pages-($_GET["page"]+2))>0) {
				if($_GET["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="current">' . ($pages) .'</span>';
				else				
					$output = $output . '<input type="button"  class="perpage-link" onclick="getresult(\'' . $href .  ($pages) .'\')"  value=' . $pages . ' />';
			}			
		}
		return $output;
	}
}
?>