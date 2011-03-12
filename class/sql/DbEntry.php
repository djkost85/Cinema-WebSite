<?php

/**
 * 
 * Représente un champ de base de donnée
 * 
 *
 */
class DbEntry {
	///nom du champ
	private $name;
	
	///type du champ attendu enum, string, int, float, sql (si le formatage est déjà fait) 
	//date (format attendu YYYY-MM-DD), time (format attendu HH:MM:SS) 
	private $type;
	
	function __construct($name, $type){
		$this->name = $name;
		$this->type = $type;	
	}
	
	function getName(){
		return '`'.$this->name.'`';
	}
	
	/**
	 * Cette fonction formate la valeur passé en argument 
	 * pour que l'insertion se passe bien 
	 * @param $value valeur à formater
	 */
	function formatValue($value){		
		switch($this->type){
			case "enum" :
				$result = "'".$value."'";
			break;
			case "string" :
				$result = "'".mysql_real_escape_string($value)."'";
			break;
			case "int" :
				$result = intval($value);
			break;
			case "float" :
				$result = doubleval($value);
			break;
			case "sql" :
				$result = $value;
			break;
			case "date" : 
				$result = "'".$value."'";
			break;
			case "time" :
				$result = "'".$value."'";
			break;
		}
		
		return $result;
	}
	
	function __toString(){
		return $this->name;
	}
}

?>