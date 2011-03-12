<?php
	set_include_path("../../../");
	require_once("class/model/ProjectionMgr.php");

	class TestProjectionMgr extends PHPUnit_Framework_TestCase {
		function testGetLastProjectionDate(){
			$proj = new ProjectionMgr();
			echo $proj->getLastProjectionDate()."\n";
			$this->assertTrue($proj->getLastProjectionDate() != date("Y-m-d"));
		}
		
		function testGetNotImportedProjections(){
			$proj = new ProjectionMgr();
			$projList = $proj->getNotImportedProjections();
			print_r($projList);
		}
	}

?>
