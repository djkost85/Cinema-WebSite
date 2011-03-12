<?php

/**
 * Cette classe permet de manipuler des dates
 * Le format attendu est YYYY-MM-DD
 * 
 */
class Date {

	/**
	 * Cette fonction retourne la date d mercredi
	 * de la semaine correspondante à la 
	 * date passée en argument.
	 *
	 * @param $date date à sonder
	 * @return la date de la semaine correspondante
	 */
	function getCorrespondingWeek($date){

		$timestamp = $this->getTimeStamp($date);

		//On récupère le jour numérique à laquelle la date correspond
		$numDay = date("w",$timestamp);
		
		//On identifie quelle est la semaine correspondante
		//a la date en cours
		
		//Pour cela on calcule le décalage correspondant
		if($numDay >= 3){
			//si il d'agit d'un jour entre mercredi et samedi, on décalle de 3
			$dec = $numDay - 3;
		}else{
			//sinon on décale de 4 (on passe à l'autre semaine)
			$dec = $numDay + 4;
		}
		
		$timestampCorrespondingWeek = intval($timestamp)-(intval($dec) * 3600 * 24);
		
		$result = date("Y-m-d", $timestampCorrespondingWeek);
		
		return $result;
		
	}
	
	
	/**
	 * Fonction qui retourne une date décallée
	 * @param $date date de base
	 * @param $dec valeur de décallage
	 * @return la date décallée
	 */
	function getDecDate($date,$dec){
	
		$timestamp = $this->getTimeStamp($date);
	
		$timestampDec = intval($timestamp)-(intval($dec) * 3600 * 24);
		
		$result = date("Y-m-d", $timestampDec);
		
		return $result;
	}
	
	/**
	 * Renvoie le timestamp correspondant 
	 * à la date écrite sous la forme de chaîne 
	 * de caractère.
	 *
	 * @param[in] $date date au format YYYY-MM-DD
	 * @return timestamp UNIX 
	 */
	function getTimeStamp($date){
		$dateTab = explode("-",$date);
		$timestamp = mktime(0,0,0,$dateTab['1'],$dateTab['2'],$dateTab['0']);
		return $timestamp;
	}

}

?>
