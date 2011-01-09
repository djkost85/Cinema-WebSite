<?php

require_once("class/page/TPage.php");

require_once("class/kernel/AllocineAPI.php");

require_once("class/model/ProjectionMgr.php");
require_once('class/model/Film.php');

class ProgPage extends TPage {
	
	function __construct(Application $app){
		parent::__construct("page/ProgIndex.tpl", "Programmation", $app);
		
		$action = $this->app->getPost("action");
		if($action == "Import"){	
			//On doit importer un fichier de prog
			$type = $this->app->getPost("type");
			if($type == "file"){
				//todo
			}else{
				$this->_tplFile = "page/ProgFromAllocine.tpl";
				//remplis le tableau $this->film
				$this->setProgFromAllocine();
			}
		}elseif($action == "ImportValid"){
			//on commence par récupérer la liste des films accessible en session
			$this->films = $this->app->getSessionValue("ProgPageFilms");
			$this->_tplFile = "page/ProgValid.tpl";							
			//stockage dans la base des films validés
			foreach($this->films as $film){
				$film->storeInDb();
			}
			
			//récupération des images
			foreach($this->films as $film){
				if($film->getPoster() != ""){
					fopen($film->getPoster(), "r");
					is_dir("image/prog");
				}
			}
			
			$this->app->unsetValue("ProgPageFilms");
			
		}
	}
	
	private function setProgFromAllocine(){
		
		$filmMgr = new FilmMgr();
		$projectionMrg = new ProjectionMgr();
		
		$allocineApi = new AllocineAPI($filmMgr);
		$dateProg = $projectionMrg->getLastProjectionDate();
		
		//import à partir d'allociné
		//////////////////////////:
		
		//on identifie la date de début pour pouvoir passer à la date suivante
		$dateTab = explode('-', $dateProg);
		
		$this->films = array();
		
		for($i=0;$i<ALLOCINE_NB_DAY_REQUEST;$i++){
			//décallage d'une journée
			$dateProg = date("Y-m-d",mktime(0,0,0,$dateTab[1],$dateTab[2],$dateTab[0])+3600*24*$i);

			//récupération de la programation de la journée  
			$filmArray = $allocineApi->getProgCine(ALLOCINE_CINEMA_POSTCODE,ALLOCINE_CINEMA_CODE, $dateProg);
			
			//merge dans la prog totalement en cours de téléchargement
			$this->films = array_merge($this->films, $filmArray);
		}
		
		$this->films = array_unique($this->films);

		//On récupère plus d'info pour chaque film
		foreach($this->films as $film){
			$allocineApi->enrichFilm($film); 
		}
		
		//on stocke la liste récupérée en session
		$this->app->storeSessionValue("ProgPageFilms", $this->films);		
		
	}
	
	/**
	 * On remplie la variable page utilisé pour la génération du template
	 * @see TPage::generateHTML()
	 */
	public function generateHTML() {
		if($this->_tplFile == "page/ProgFromAllocine.tpl"){
			//gestion affichage pour le template
			foreach($this->films as $filmObj){
				$film = new stdClass();
				$film->posterSrc = $filmObj->getPoster();
				$film->title = $filmObj->getTitle();
				$film->resume = $filmObj->getResume();
				$film->avertissement = $filmObj->getAvertissementMsg();
				
				foreach($filmObj->getProjection() as $progObj){				
					$prog = new stdClass();				
					$prog->day = $progObj->getDay();
					$prog->time = $progObj->getTime();
					$film->prog[] = $prog;
				}
	
				$this->page->film[] = $film;
			}
		}
	}
	
}

?>