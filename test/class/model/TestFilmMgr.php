<?php

set_include_path(get_include_path().":../../..");

require_once("class/model/FilmMgr.php");

class TestFilmMgr extends PHPUnit_Framework_TestCase {
	
	function testGetFilmById(){
		$filmMgr = new FilmMgr();
		$film = $filmMgr->getFilmById(24);
		print_r($film);
		$this->assertTrue(empty($film) == false);
	}
	
}

?>
