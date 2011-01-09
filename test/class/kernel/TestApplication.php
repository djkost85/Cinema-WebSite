<?php
	set_include_path(get_include_path().":../../..");

	require_once("class/kernel/Application.php");
	
	class TestApplication extends PHPUnit_Framework_TestCase {
		
		function testApplication(){		
			
			$app = new Application();
			$this->assertTrue($app->getCurrentPage() != null);
			$app->display("../../../tpl/");
			
		}
		
		
		
	}
	
?>