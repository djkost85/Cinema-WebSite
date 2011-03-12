<?php

	require_once("class/sql/MysqlManager.php");
	require_once("class/model/Newsletters.php");

	class NewslettersMgr {
		
		public function __construct(){
			
		}
		
		/**
		 * 
		 * Retourne un tableau des newsletters
		 * @param $nb nombre de newsletters à retourner
		 */
		public function getNewsletters($nb = ""){
			$result = array();
			
			//gestion nombre maximum 
			$limit = "";
			if(intval($nb)>0){
				$limit = " LIMIT ".$nb;
			}
			
			$queryHandler = MysqlManager::query("SELECT id, sendType, date, contents, object FROM Newsletters ORDER by id DESC".$limit);
			
			while((($row = MysqlManager::fetch($queryHandler)) !== false)){				
				$result[] = new Newsletters($row['id'],$row['object']);
			}
			return $result;
		}
		
		
		public function getNewsletter($id){
			$row = MysqlManager::getRowResult("SELECT id, sendType, date, contents, object FROM Newsletters WHERE id = ".intval($id));
			return new Newsletters($row['id'], $row['object'], $row['contents'], $row['date'], $row['sendType']); 
		}
		
	}

?>