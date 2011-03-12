<?php

require_once('class/sql/DbEntry.php');
require_once('class/sql/DbField.php');
require_once('class/sql/MysqlManager.php');

/**
 * Il s'agit de l'objet dont chaque element de la base de donnée 
 * doit hériter pour 
 *
 */
abstract class DbField {
	
	private $id;
	
	private $tableName;
	
	/**
	 * Constructeur
	 * 
	 * @param[in] $tableName nom de la table correspondante
	 * @param[in] $id correspondant au champ id que l'on impose si il est égale à 0, 
	 * on considère que le champ n'est pas inséré en base
	 */
	function __construct($tableName, $id){
		
		$this->id = $id;
		
		$this->tableName = $tableName;
	}
	 
	function getId(){
		return $this->id;
	}
	
	function setId($id){
		$this->id = $id;
	}
	
	/**
	 * 
	 * Cette fonction s'occupe de faire une sauvegarde de l'enregistrement dans la base de donnée
	 */
	abstract function storeInDb();
	
	/**
	 * Construit une requete de sauvegarde dans la base de l'item en cours
	 *  
	 * @param $fields tableau dont la clé est égale au champ et la valeur 
	 * à la valeur à sauver dans la base 
	 */
	protected function makeStoreRequest($fields){
		$nbFields = count($fields);
		if($this->id == 0){	//id égale à  on crée une reque d'insertion
			$query = "INSERT INTO ".$this->tableName." (";
			$values = "VALUES (";
			$i = 0;
			foreach($fields as $value => $field){
				$query .= $field->getName();
				$values .= $field->formatValue($value);
				$i++;
				if($i < $nbFields){
					$query .= ",";
					$values .= ",";
				}				
			}
			
			$query = $query.") ".$values.")";
			$this->id = MysqlManager::insert($query);
		}else{ //update
			$i = 0;
			$query = "UPDATE ".$this->tableName." SET ";
			foreach($fields as $value => $field){
				$query .= $field->getName()."=".$field->formatValue($value);
				$i++;
				if($i < $nbFields){
					$query .= ",";
				}
			}
			$query .= " WHERE id = ".$this->id;		
			MysqlManager::query($query);	
		}
		
		
		
	} 
 	
}

?>