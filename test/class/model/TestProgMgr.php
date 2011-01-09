<?php

set_include_path(get_include_path().":../../..");

require_once("class/model/ProgMgr.php");

class TestProgMgr extends PHPUnit_Framework_TestCase {
	
	function testImportProg(){
		$progMgr = new ProgMgr();
		$films = $progMgr->importProg("prog_test_website.csv");
		//print_r($films);
		$this->assertEquals(12,count($films));
		
	}
	
}