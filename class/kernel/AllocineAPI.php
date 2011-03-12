<?php

require_once('class/model/FilmMgr.php');
//require_once('lib/API_Allocine/API_Allocine.php');

require_once('class/model/Film.php');

require_once('class/model/Projection.php');

/**
 * 
 * Classe s'occupant de faire des requètes sur le site Allociné 
 * 
 *
 */
class AllocineAPI {
	
	//Permet de gérer les objets films
	private $filmMgr;
	
	function __construct($filmMgr){
		$this->filmMgr = $filmMgr;
	}
	
	/**
	 * Cette fonction permet de récupérer la programation 
	 * à partir ce qui est fait sur le site allocine
	 * 
	 * @param $postCode code postal du cinéma
	 * @param $allocineCinemaCode code correspondant au cinéma dans Allociné
	 * @param $date date à laquelle on veut le programme format YYYY-MM-DD
	 * @param $radius rayon autour du code postal (défaut 10km permet le rafraichissement intégrale à chaque fois)
	 * @return un tableau contenant la programmation * Enter description here ...respectant le format model 
	 */
	function getProgCine($postCode, $allocineCinemaCode, $date, $radius = 10){
		
		$url = "http://api.allocine.fr/xml/showtimelist?partner=1&json=1&";
		// Code Postal
		if (!is_numeric($postCode)) {
			throw new InvalidArgumentException("[AllocineAPI::getProgCine] \$postCode n'est pas un nombre mais '".$postCode."'");
		}
		
		$url .= 'zip='.$postCode.'&';
		$url .= 'radius='.$radius.'&';
		$url .= "date=" . $date;
		
		// Récupération du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// Vérification de la présence d'erreur(s)
		if (empty($tab['error'])==false) {
			throw new RuntimeException("[AllocineAPI::getProgCine] Error when execute '".$url."' ".print_r($tab['error'],true));
		}		
		
		$result = array();
		if(empty($tab['feed'])){			
			Logger::getRootLogger()->warn("[AllocineAPI::getProgCine] No feed on result of url : '".$url."'");
		}else{
			if(intval($tab['feed']['totalResults']) > 0){
				if(empty($tab['feed']['theaterShowtimes'])){
					Logger::getRootLogger()->warn("[AllocineAPI::getProgCine] No theaterShowtimes on result of url : '".$url."'");
				}else{
					foreach($tab['feed']['theaterShowtimes'] as $theater){
						
						if($theater['theater']['code'] == $allocineCinemaCode){
							
							if(isset($theater['movieShowtimes'])){

								foreach($theater['movieShowtimes'] as $movie){
								
									$film = $this->filmMgr->getFilm($movie['movie']['title']);

									//replissage des valeurs dans l'objet
									//sauvegarde url affiche
									if($film->getPoster()==""){
										$film->setPoster($movie['poster']['href']);
									}
									//id allociné
									if($film->getAllocineId()==""){									
										$film->setAllocineId($movie['movie']['code']);
									}
								
									//programmation
									foreach($movie['scr'] as $progDate){
										foreach($progDate['t'] as $time){										
											$projection = new Projection($progDate['d'],$time['$'], $film);
											$film->addProjection($projection);						
										}
									}
									$result[] = $film;
								}
							}else{								
								Logger::getRootLogger()->debug(print_r($theater['theater'],true));
							}
						}
					}
				}
			}else{
				Logger::getRootLogger()->warn("[AllocineAPI::getProgCine] No result of url : '".$url."'");
			}
		}
		
		array_unique($result);	
		
		return $result;
		
	}
	
	/**
	 * Enrichie les informations sur le film passer en argument
	 * 
	 * l'id allociné doit être remplie dans l'objet
	 *
	 * @param Film $film
	 */
	function enrichFilm(Film $film){
		//URL du service
		$url = 'http://api.allocine.fr/xml/movie?code='.$film->getAllocineId().'&partner=1&json=1&profile=medium';
		
		// Récupération du JSON
		$json = file_get_contents($url);
			
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		//Vérification de la présence d'erreur(s)
		if (!empty($tab['error'])) {
			throw new RuntimeException("[AllocineAPI::enrichFilm] Error : '".print_r($tab['error'],true)."' when execute url : '".$url."'");
		}
		
		if(!empty($tab['movie'])){
		
			if($film->getOriginalTitle() == ""){
				$film->setOriginalTitle($tab['movie']['originalTitle']);
			}
	
			if($film->getResume() == ""){
				$film->setResume($tab['movie']['synopsisShort']);
			}
			
			if(intval($film->getYear()) == 0){
				$film->setYear($tab['movie']['productionYear']);
			}
			
			if($film->getPoster() == ""){
				$film->setPoster($tab['movie']['poster']['href']);
			}
			
			if(isset($tab['movie']['movieCertificate']['$'])){
				if($film->getAvertissementMsg() == ""){
					$film->setAvertissementMsg($tab['movie']['movieCertificate']['$']);
				}
			}
			
		}		
	}
	
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
			Logger::getRootLogger()->warn("[AllocineAPI::searchFilms] Error : '".print_r($tab['error'],true)."' when execute url : '".$url."'");			
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
		
		return $result;
	}
}

?>
