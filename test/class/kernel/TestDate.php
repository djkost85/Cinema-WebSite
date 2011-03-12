<?php
	set_include_path(get_include_path().":../../..");

	require_once("class/kernel/Date.php");
	
	class TestDate extends PHPUnit_Framework_TestCase {
		
		function testGetCorrespondingWeek(){		
			
			$date = new Date();

			$this->assertEquals("2011-01-12",$date->getCorrespondingWeek("2011-01-13"));
			
			$this->assertEquals("2010-12-15",$date->getCorrespondingWeek("2010-12-20"));

			$this->assertEquals("2010-08-18",$date->getCorrespondingWeek("2010-08-21"));
			
		}
		
		
		
	}
	
?>
