<?php

	require_once("class/kernel/Date.php");

	class ProgMgr {
		
		function __construct(){
		}
		
		/**
		 * Cette fonction retourne la liste 
		 * des semaines pour lesquels on dispose d'info
		 * mais dont le programme n'a pas été généré
		 */
		function getNotGeneratedWeek($tplPath){		
			$projectionMgr = new ProjectionMgr();

			$notImportedProjList = $projectionMgr->getNotImportedProjections();

			$progList = array();
			
			$date = new Date();

			foreach($notImportedProjList as $proj){
				
				//On récupère la date de la semaine correspondante 
				$weekDate = $date->getCorrespondingWeek($proj->getDay());
		
				//On indexe les projections correspondantes
				$progList[$weekDate][] = $proj;
						
			}
			
			$page = new stdClass();
			$page->film = new stdClass();
			$progs = array();
			foreach($progList as $beginDate => $prog){
				$endDate = $date->getDecDate($beginDate,7);
				foreach($prog as $proj){
					$id = $proj->getFilm()->getId()
					if(isset($page->film->$id) == false){
						$page->film->$id = new stdClass();
						$page->film->$id->title = $proj->getFilm()->getTitle();
						$page->film->$id->proj = new stdClass();
					}else{
						$page->film->$id->proj[] = $proj->getDay()." ".$proj->getTime();
					}
				}
				$content = sprintt($page,$tplPath."newsletter/newsletter.tpl");
				$progs[] = new Prog($beginDate, $endDate, $content);
			}
			
			return $prog;
		
		}
			
	}

?>
