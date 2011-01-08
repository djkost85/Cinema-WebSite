<?php
	
/**
 * 
 * Cette classe se charge des échanges entre la table
 * Film et l'application
 *
 */
class FilmMgr {
	
	function __construct(){
		
	}
	
	/**
	 * 
	 * Cette fonction s'occupe d'importer un fichier csv contenant la programmation
	 * 
	 * @param  $file chemin d'accès au csv
	 * @return tableau contenant la liste des fichiers importés 
	 */
	function importProg(string $file){
		
		$res = fopen($file,'r');
		//on passe la premier ligne
		fgets($res, 4096);
		while(($buffer = fgets($res, 4096)) !== false){
			$register = split(";",$buffer);
			$registe
		}
	}
		
} 

?>