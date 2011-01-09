<?php

/**
 * 
 * Représente la table Prog
 *
 */
class Prog {
	
	private $day;
	
	private $hour;
	
	private $film;
	
	/**
	 * 
	 * Enter description here ...
	 */
	function __construct($day, $hour, Film $film){
		$this->day = $day;
		$this->hour = $hour;
		$this->film = $film;
	}
	
	/* GETTER / SETTER */
	function getDay(){
		return $this->day;
	}
	
	function getHour(){
		return $this->hour;
	}
	
	function getFilm(){
		return $this->film;
	}
}