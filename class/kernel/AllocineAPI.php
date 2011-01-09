<?php


//require_once('lib/API_Allocine/API_Allocine.php');

require_once('class/model/Film.php');

/**
 * 
 * Classe s'occupant de faire des requètes sur le site Allociné 
 * 
 *
 */
class AllocineAPI {
	
	
	/**
	 * Cette fonction retourne les infos trouvées concernant un film
	 *
	 * @param[in] $titre titre du film à rechercher
	 * @param[in] $limitation nombre de résultat maximum
	 * 
	 * @return tableau contenant une liste d'objets Films  
	 */
	function searchFilms($titre, $limitation){
		
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($titre).'&partner=1&json=1&profile=small&count='.intval($limitation);

		// Récupération du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		$result = array();
		// Vérification de la présence d'erreur(s)
		if (!empty($tab['error'])){ 
			Logger::getRootLogger()->warn("[AllocineAPI::searchFilms] Error : '".$tab['error']."'when execute url : '".$url."'");			
		}elseif(empty($tab['feed'])){
			Logger::getRootLogger()->warn("[AllocineAPI::searchFilms] No feed on result of url : '".$url."'"); 
			return array();
		}elseif(empty($tab['feed']['movie'])){
			Logger::getRootLogger()->warn("[AllocineAPI::searchFilms] No movies on result of url : '".$url."'");
		}else{
			//On peut maintenant s'attaquer au contenu
			foreach($tab['feed']['movie'] as $movie){
				
				//gestion titre et titre originaux
				$noTitle = false;
				$title = "";
				$originalTitle = "";
				if(empty($movie['title']) == true){
					if(empty($movie['originalTitle'])==false){
						$title = $movie['originalTitle'];
						$originalTitle = $movie['originalTitle'];				
					}else{
						Logger::getRootLogger()->info("[AllocineAPI::searchFilms] no title found for allocine movie Id : '".$movie['code']."', jump movie");
						$noTitle = true;
					}
				}
				
				//On continue que si il y a un titre
				if ($noTitle == false){
					$poster = "";
					if(((empty($movie['poster'])==false)&&(count($movie['poster'])>0))){
						$poster = $movie['poster']['href'];
					}
					
					$year = 0;
					if(empty($movie['productionYear'])==false){
						$year = $movie['productionYear'];
					}
					
					$result[] = new Film($title, $originalTitle, "", $poster, $year, $movie['code']);
				}
			}
		}
		
		
		
		//$films = searchMoviesByKeywords($titre);
		print_r($result);
		return $result;
	}
}

?>