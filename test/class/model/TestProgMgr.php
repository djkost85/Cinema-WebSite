<?php

set_include_path(get_include_path().":../../..");

require_once("class/model/ProjectionMgr.php");

class TestProjectionMgr extends PHPUnit_Framework_TestCase {
	
	function testImportProg(){
		$projectionMgr = new ProjectionMgr();
		$films = $projectionMgr->importProgrammation("prog_test_website.csv");
		$this->assertEquals(12,count($films));
		
	}
	
}