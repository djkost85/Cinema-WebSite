<?php

require_once("class/sql/MysqlManager.php");

require_once("class/model/Film.php");

/**
 *
 * Cette classe se charge des échanges entre la table
 * Film et l'application
 *
 */
class FilmMgr {

	/// Tableau RAM rassemblant les films actuellement chargés 
	private $films;
	
	public function __construct(){

	}

	public function getFilm($title){

		if(empty($this->films[$title])){
			$result = MysqlManager::getRowResult("SELECT id, resume, poster FROM Film WHERE title = '".mysql_escape_string($title)."'");
			if(empty($result)){
				$film = new Film($title);
				$this->films[$title] = $film;
				return $film;
			}else{
				$film = new Film($title);
				$this->films[$title] = $film;
				return $film;
			}
		}else{
			return $this->films[$title];
		}
	}

}

?>