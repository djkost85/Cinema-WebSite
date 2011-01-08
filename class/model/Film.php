<?php


/**
 * 
 * Cette classe représente un enregistrement 
 * de la table Film
 *
 */
class Film {
	
	/// id unique du champ dans la base
	private $id;

	/// Titre du film
	private $title;
	
	/// Résumé du film
	private $resume;
	
	/// Chemin vers l'image correspondant à l'affiche du film
	private $poster;
	
	function __construct(){
		
	}	
	
	/*GETTER*/
	
	function getId(){
		return $this->id;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	function getResume(){
		return $this->resume;
	}
	
	function getPoster(){
		return $this->poster;
	}
	
	
	
}