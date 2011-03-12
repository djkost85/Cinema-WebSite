<?php

require_once("class/model/FilmMgr.php");

class ProjectionMgr {

	/**
	 * 
	 * Cette fonction s'occupe d'importer un fichier csv contenant la programmation
	 * 
	 * @param  $file chemin d'accès au csv
	 * @return tableau contenant la liste des fichiers importés avec leur programation
	 */
	function importProgrammation($file){
		
		$filmMgr = new FilmMgr();		
		$res = fopen($file,'r');
		//on passe la premier ligne
		fgets($res, 4096);
		
		$prog = array();
		$films = array();
		while(($buffer = fgets($res, 4096)) !== false){
			$register = split(";",$buffer);
			$film = $filmMgr->getFilm($register[2]);
			$projection = new Projection($register[0],$register[1], $film);			
			$film->addProjection($projection);
			$films[] = $film;
		}
		
		$films=array_unique($films);
		
		return $films ;
	}
	
	/**
	 * Recheche la dernière date de projection en base 
	 * si elle est plus vielle que la date du jour on retourne la date du jour
	 * sinon on retourne cette date
	 */
	function getLastProjectionDate(){
		$beginImportDate = date("Y-m-d");		
		$query = "SELECT DATE_FORMAT(day,'%Y-%m-%d') FROM Projection WHERE day > NOW() ORDER BY day DESC LIMIT 1";
		$result = MysqlManager::getSimpleResult($query);		

		
		if(empty($result)==false){	
			//on décale d'une journée car si la journée est en base, il faut partir sur la suivante pour ne pas la réimporter
			$dateTab = explode("-", $result);
			$beginImportDate = date("Y-m-d",mktime(0,0,0,$dateTab[1],$dateTab[2],$dateTab[0])+3600*24);
		}
		return $beginImportDate;
		
	}
	
	/**
	 * Retourne une liste ordonées des projections qui n'ont pas 
	 * importé encore été importé
	 */
	function getNotImportedProjections(){
		$query = "SELECT id, film_id, day, time, imported FROM Projection WHERE imported = 0 ORDER BY day, time;";
		$result = MysqlManager::getResult($query);
		$proj = array();

		$filmMgr = new FilmMgr();
		
		foreach($result as $projField){
			$film[$projField['film_id']] = $filmMgr->getFilmById($projField['film_id']);			
			$proj[] = new Projection($projField['day'],$projField['time'],$film,$projField['id']);
		}
		
		return $proj;
				
	}
	
	
}

?>
