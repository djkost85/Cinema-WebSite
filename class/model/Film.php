<?php

require_once("class/model/Prog.php");

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
	
	/// Titre original du film
	private $originalTitle;
	
	/// Nationalité du film
	private $nationality;
	
	/// Résumé du film
	private $resume;
	
	/// Chemin vers l'image correspondant à l'affiche du film
	private $poster; 
	
	/// Année du film
	private $year;
		
	/// Les contenus sont "VF" ou "VOST"
	private $soundVersion;
	
	/// Age minimum pour voir le film 
	private $oldForbade;
	
	/// Id référence Allociné
	private $allocineId;
	
	/// Liste des programations du film
	private $prog;
	
	/**
	 * 
	 * Constructeur
	 *  
	 * @param $title
	 * @param $originalTitle
	 * @param $resume
	 * @param $poster
	 * @param $year
	 * @param $allocineId
	 * @param $id
	 */
	function __construct($title, $originalTitle ="", $resume = "", $poster ="", $year = 0, $allocineId = 0, $id = 0 ){
		$this->title = $title;
		$this->originalTitle = $originalTitle;
		$this->resume = $resume;
		$this->poster = $poster;
		$this->year = $year;
		$this->allocineId = $allocineId;
		$this->id = $id;		
		$this->prog = array();
		
	}	
	
	function addProg(Prog $prog){
		$this->prog[] = $prog;
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
	 
	/**
	 * 
	 * Fonction utilisé par array_unique
	 */
 	function __toString(){
		return $this->title;
	}
	
	
}