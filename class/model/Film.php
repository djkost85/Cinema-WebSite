<?php

require_once("class/sql/DbField.php");
require_once("class/model/Projection.php");

/**
 * 
 * Cette classe représente un enregistrement 
 * de la table Film
 *
 */
class Film extends DbField {

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
	
	/// Message d'avertissement associé au film 
	private $avertissementMsg;
	
	/// Id référence Allociné
	private $allocineId;
	
	/// Liste des projections programmée du film
	private $projection;
	
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
		parent::__construct("Film",$id);
		
		$this->title = $title;
		$this->originalTitle = $originalTitle;
		$this->resume = $resume;
		$this->poster = $poster;
		$this->year = $year;
		$this->allocineId = $allocineId;		
		$this->projection = array();	
		
	}	
	
	function addProjection(Projection $projection){
		$this->projection[] = $projection;
	}
	
	function getProjection(){
		return $this->projection;	
	}
	/*GETTER*/
	
	function getTitle(){
		return $this->title;
	}
	
	function getOriginalTitle(){
		return $this->originalTitle;
	}
	
	function setOriginalTitle($originalTitle){
		$this->originalTitle = $originalTitle;
	}
	
	function getNationality(){
		return $this->nationality;
	}
	
	function setNationality($nationality){
		$this->nationality = $nationality;
	}
	
	function getResume(){
		return $this->resume;
	}
	
	function setResume($resume){
		$this->resume = $resume;
	}
	
	function getYear() {
		return $this->year;
	}
	
	function setYear($year){
		$this->year = $year;
	}
	
	function getPoster(){
		return $this->poster;
	}
	
	function setPoster($poster){
		$this->poster = $poster;
	}
	
	function getAvertissementMsg(){
		return $this->avertissementMsg;
	}
	
	function setAvertissementMsg($avertissementMsg){
		$this->avertissementMsg = $avertissementMsg; 
	}
	
	function getAllocineId(){
		return $this->allocineId;
	}
	
	function setAllocineId($allocineId){
		$this->allocineId = $allocineId;
	}
	
	
	/**
	 * Stocke les nouvelles données dans la base de donnée
	 */
	function storeInDb(){
		
		//On stocke le film
		$fields = array(	$this->title => new DbEntry("title", "string"), 
							$this->originalTitle => new DbEntry("originalTitle","string"),
							$this->nationality => new DbEntry("nationality", "string"),
							$this->resume => new DbEntry("resume", "string"),
							$this->poster => new DbEntry("poster", "string"),
							$this->year => new DbEntry("year", "int"),
							$this->soundVersion => new DbEntry("soundVersion", "enum"),
							$this->avertissementMsg => new DbEntry("avertissementMsg", "string"),
							$this->allocineId => new DbEntry("allocineId", "string")
			);
	
		parent::makeStoreRequest($fields);

		//On stocke les projections en base
		foreach($this->projection as $projection){
			$projection->storeInDb();
		}
		
				
	}
	
	/**
	 * 
	 * Fonction utilisé par array_unique
	 */
 	function __toString(){
		return $this->title;
	}
	
	
}