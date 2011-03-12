<?php

require_once("class/sql/DbField.php");

/**
 * 
 * Représente la table Prog
 *
 */
class Projection extends DbField {
	
	private $day;
	
	private $time;
	
	private $film;
	
	/**
	 * 
	 * Enter description here ...
	 */
	function __construct($day, $time, Film $film, $id = 0){
		
		parent::__construct("Projection", $id);
		
		$this->day = $day;
		$this->time = $time;
		$this->film = $film;
	}
	
	/* GETTER / SETTER */
	function getDay(){
		return $this->day;
	}
	
	function getTime(){
		return $this->time;
	}
	
	function getFilm(){
		return $this->film;
	}

	function storeInDb(){
			$fields = array(	$this->day => new DbEntry("day", "date"), 
								$this->time => new DbEntry("time","time"),
								$this->film->getId() => new DbEntry("film_id", "int"));
			
			parent::makeStoreRequest($fields);
	}
	
}
