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

	/// Tableau RAM rassemblant les films actuellement chargés (indexé par titre) 
	private $films_byTitle;
	
	/// Tableau RAM rassemblant les films actuellement chargé (indexé par id)
	private $films_byId;
	
	public function __construct(){

	}

	public function getFilm($title){

		if(empty($this->films_byTitle[$title])){
			$result = MysqlManager::getRowResult("SELECT id, resume, poster FROM Film WHERE title = '".mysql_escape_string($title)."'");
			if(empty($result)){
				$film = new Film($title);
				$this->films_byTitle[$title] = $film;
				return $film;
			}else{
				$film = new Film($title);
				$this->films_byTitle[$title] = $film;
				return $film;
			}
		}else{
			return $this->films_byTitle[$title];
		}
	}

	public function getFilmById($id){
		if(empty($this->films_byId[$id])){
			$result = MysqlManager::getRowResult("SELECT id, title, originalTitle, nationality, resume, poster, year, soundVersion, avertissementMsg, allocineid FROM Film WHERE id = '".intval($id)."'");
			if(empty($result)){
				throw new OutOfBoundsException("'".$id."' not found in table Film");
			}else{
				$film = new Film($result['title'], $result['originalTitle'], $result['resume'], $result['poster'], $result['year'], $result['allocineid'], $id);
				$this->films_byId[$id] = $film;
				return $film;
			}
		}else{
			return $this->films_byId[$id];
		}
	}

}

?>
