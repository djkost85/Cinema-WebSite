<?php
	set_include_path(get_include_path().":../../..");

	require_once("class/kernel/AllocineAPI.php");
	
	class TestAllocineAPI extends PHPUnit_Framework_TestCase {
		
		function testSearchFilm(){
			
			$allocineApi = new AllocineAPI();
			
			$allocineApi->searchFilms("Titanic", 5);
			
		}
		
		
		
	}