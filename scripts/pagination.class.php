<?php
class PerPage {
	public $perpage;
	
	function __construct() {
		$this->perpage = 10;
	}
	
	function perpage($count,$href,$thistable) {
		$output = '';
		if(!isset($_GET['page']) || $thistable<>$_POST['operatingontable']) $page = 1; else $page=$_GET['page'];
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if(($page-3)>0) {
				if($page == 1)
					$output = $output . '<span id="'.$thistable.'_p1" class="current-page">1</span>';
				else				
					$output = $output . '<input type="button" class="perpage-link" onclick="getresult(\'' . $href . '1\',\''.$thistable.'\', searchfocus(\''.$thistable.'\'))" value=1 />';
			}
			if(($page-3)>1) {
					$output = $output . '...';
			}
			
			for($i=($page-2); $i<=($page+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($page == $i)
					$output = $output . '<span id='.$thistable.'_p'.$i.' class="current-page">'.$i.'</span>';
				else				
					$output = $output . '<input type="button" class="perpage-link" onclick="getresult(\'' . $href . $i . '\',\''.$thistable.'\', searchfocus(\''.$thistable.'\'))"  value=' . $i . ' />';
			}
			
			if(($pages-($page+2))>1) {
				$output = $output . '...';
			}
			if(($pages-($page+2))>0) {
				if($page == $pages)
					$output = $output . '<span id='.$thistable.'_p' . ($pages) .' class="current">' . ($pages) .'</span>';
				else				
					$output = $output . '<input type="button"  class="perpage-link" onclick="getresult(\'' . $href .  ($pages) .'\',\''.$thistable.'\', searchfocus(\''.$thistable.'\'))"  value=' . $pages . ' />';
			}			
		}
		return $output;
	}
}
?>