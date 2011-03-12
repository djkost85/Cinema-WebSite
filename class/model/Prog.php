<?php

require_once("class/sql/DbField.php");

class Prog extends DbField  {
	
	///Date de début de semaine
	private $date_begin;
	
	///Date de fin de semaine
	private $date_end;
	
	///Contenu généré de la page
	private $pagecontent;
	
	function __construct($date_begin, $date_end, $pagecontent, $id=0){
		parent::__construct("Prog", $id);
	}
	
	function storeInDB(){
		$fields = array(	$this->date_begin => new DbEntry("date_begin","date"),
							$this->date_end => new DbEntry("date_end", "date"),
							$this->pagecontent => new DbEntry("pagecontent", "string"));

		parent::makeStoreRequest($fields);				
			
	}
	
	
	
	

}
