<?php

require_once("class/model/FilmMgr.php");

class ProgMgr {

	/**
	 * 
	 * Cette fonction s'occupe d'importer un fichier csv contenant la programmation
	 * 
	 * @param  $file chemin d'accès au csv
	 * @return tableau contenant la liste des fichiers importés avec leur programation
	 */
	function importProg($file){
		
		$filmMgr = new FilmMgr();		
		$res = fopen($file,'r');
		//on passe la premier ligne
		fgets($res, 4096);
		
		$prog = array();
		$films = array();
		while(($buffer = fgets($res, 4096)) !== false){
			$register = split(";",$buffer);
			$film = $filmMgr->getFilm($register[2]);
			$prog[] = new Prog($register[0],$register[1], $film);			
			$films[] = $film;
		}
		
		$films=array_unique($films);
		
		return $films ;
	}
	
}

?>