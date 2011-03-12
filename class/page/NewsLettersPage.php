<?php

require_once("class/model/Newsletters.php");
require_once("class/model/NewslettersMgr.php");

require_once("class/kernel/SendHtmlMail.php");

require_once("class/page/TPage.php");

class NewsLettersPage extends TPage {
	
	//mode edit 
	
	//la newsletters courante
	private $currentNewsletter;
	
	//l'adresse email de test
	private $currentEmail;
	
	//en mode manage : la liste des Newsletters afficher
	private $newslettersList;
		
	
	private $action;
	
	function __construct(Application $app){
		
		parent::__construct("page/NewsletterMenu.tpl", "Gestion NewsLetters", $app);
		
		$this->action = $this->app->getPost("action");
		/*if($this->action == null){
			$this->action = '';
		}*/
		
		$newslettersMgr = new NewslettersMgr();
		
		$this->currentNewsletter = null;				
		
		switch($this->action){
			case "edit" :
				$this->_tplFile = "page/NewsletterEdit.tpl";
				$id = $this->app->getPost('id');
				if($id == null){
					//si on ne retrouve pas d'id on vérifie qu'il n'y a pas une newsletter 
					//en cours d'édition
					if($this->app->issetSessionValue("NewsLettersPageCurrentNewsletter")){
						$this->currentNewsletter = $this->app->getSessionValue("NewsLettersPageCurrentNewsletter");
						$id = $this->currentNewsletter->getId();
					}
				}else{
					if(intval($id)>0){
						$this->currentNewsletter = $newslettersMgr->getNewsletter($id);
					}
				}
				
				if($this->currentNewsletter != null){
					
					//actions
					$save = $this->app->getPost('save');
					$testMail = $this->app->getPost('testMail');
					$import = $this->app->getPost('import');							

					if($save != null){
						//sauvegarde de la newsletters
						$contents = $this->app->getPost('contents');
						$object = $this->app->getPost('object');
						Logger::getRootLogger()->debug($contents);
						
						//sauvegarde de la newsletters en cours d'édition 						
						$this->currentNewsletter->setContents($contents);
						$this->currentNewsletter->setObject($object);
						$this->currentNewsletter->storeInDb();
					}elseif($testMail != null){
						//envoie d'un mail de tests
						$emailAdress = $this->app->getPost('testMailAddress');
						$sendHtmlMail = new SendHtmlMail(NEWSLETTER_SEND_EMAIL_SENDER, $this->currentNewsletter->getObject());
						$sendHtmlMail->addEmailAdress($emailAdress);
						$sendHtmlMail->setHTML(stripslashes($this->currentNewsletter->getContents()));
						$sendHtmlMail->send();
					}elseif($import != null){
						
						$startDate = $this->app->getPost('startDate');
						$endDate = $this->app->getPost('endDate');
						
						$contents = $this->importProgrammation($startDate,$endDate);
						
						$this->currentNewsletter->setContents($contents);
						
					}
				}else{
					//c'est qu'on est en mode création d'une nouvelle newsletters
					$this->currentNewsletter = new Newsletters(); 
				}
				
				//on recopie l'adresse email
				$this->page->currentEmail = $this->app->getPost('testMailAddress');
				
				$this->app->storeSessionValue("NewsLettersPageCurrentNewsletter",$this->currentNewsletter);
				
			break;
			case "subscriber" :
			break;
			default : //par défaut on affiche la liste des newsletters en base				
				$this->newslettersList = $newslettersMgr->getNewsletters(PAGE_ADMIN_NEWSLETTERS_NB_DISPLAY);
			break;
		}
		
		
	}
	
	private function importProgrammation($startDate, $endDate){
		//import de la programation dans la lettre

		
		$projectionMgr = new ProjectionMgr();
		
		$prog = $projectionMgr->getProjection($startDate,$endDate);
		
		$page = new stdClass();
		$page->dateBegin = $startDate;
		$page->dateEnd = $endDate;
		foreach($prog as $film){
			$filmObj = new stdClass();
			$filmObj->posterSrc = $film->getPoster();
			$filmObj->title = $film->getTitle();
			$filmObj->resume = $film->getResume();
			$filmObj->avertissement = $film->getAvertissementMsg();
			
			foreach($film->getProjection() as $proj){
				$progObj = new stdClass();
				$progObj->day = $proj->getDay();
				$progObj->time = $proj->getTime();
				$filmObj->prog[] = $progObj;
			}
			
			$page->film[] = $filmObj;
		}
		return sprintt($page,NEWSLETTER_SEND_EMAIL_TEMPLATE);
	}
	
	/**
	 * 
	 * A réimplémenter par les pages comprennant un so<h1>Programmation</h1>us menu
	 * @param $menu
	 */
	protected function getSubMenu(){

		return array(array(	array('name'=>"Liste des newsletters",'action' => ''),
							array('name'=>"Création",'action' => 'edit'),
							array('name'=>"Gérer les inscrits", 'action' => "subscriber")),$this->action);
		
	}
	
	function generateHTML(){
		if($this->_tplFile == "page/NewsletterEdit.tpl"){
			$this->page->object = $this->currentNewsletter->getObject();
			$this->page->contents = stripslashes($this->currentNewsletter->getContents());			
		}elseif($this->_tplFile  == "page/NewsletterMenu.tpl"){
			$this->page->newsletters = array();
			foreach($this->newslettersList as $newsletter){
				$newsletterObj = new stdClass();
				$newsletterObj->id = $newsletter->getId();
				$newsletterObj->object =  $newsletter->getObject();
				$this->page->newsletters[] = $newsletterObj;
			}
			
		}else{
			
		}
	}
	
	
}

?>
