<?php
	set_include_path(get_include_path().":../../..");

	require_once("class/kernel/AllocineAPI.php");
	
	class TestAllocineAPI extends PHPUnit_Framework_TestCase {
		
		/*function testSearchFilm(){
			$filmMgr = new FilmMgr();
			$allocineApi = new AllocineAPI($filmMgr);
			
			$result = $allocineApi->searchFilms("Titanic", 5);
			
			$this->assertEquals(5,count($result));
			
		}*/
		
		function testGetProg(){
			$filmMgr = new FilmMgr();
			$allocineApi = new AllocineAPI($filmMgr);
			$prog = $allocineApi->getProgCine(35130,"W0419","2011-02-13");
			print_r($prog);
		}
		
		/*function testEnrichFilm(){
			$film = new Film("A bout portant", "", "", "", 0, 177854);
			$filmMgr = new FilmMgr();
			$allocineApi = new AllocineAPI($filmMgr);
			$allocineApi->enrichFilm($film);
			print_r($film);
		}*/
		
		
		
	}
