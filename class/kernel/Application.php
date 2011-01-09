<?php

session_start();
require_once("config/config.php");
require_once('class/page/ProgPage.php');
require_once('class/page/Home.php');

require_once('lib/ets/ets.php');



/**
 * 
 * Point d'entrée du site 
 * du cinémas
 * 
 */
class Application {
	
	/// Liste des pages disponnible
	private $pageList = array(	"ProgPage" => "class/page/ProgPage.php",
								"Home" => "class/page/Hom$_SESSION[SESSION_KEY]e.php");
	
	/// Page courante à afficher
	private $currentPage;
	
	function getCurrentPage(){
		return $this->currentPage;
	}
	
	function __construct(){
		
		
		//démarrage de la gestion des sessions
		if(isset($_SESSION[SESSION_KEY])){
			$this->session = $_SESSION[SESSION_KEY];
		} 
		
		
		$this->currentPage = null;
		$pageClass = $this->getPost('page');
		if(empty($pageClass) == false){
			if(empty($this->pageList[$pageClass])==false){
				$this->currentPage = new $pageClass($this);
			}
		}

		//page par défaut
		if($this->currentPage == null){
			$this->currentPage = new Home($this);	
		}
		
	}//Contrôle des paramètres de connexion
	
	/**
	 * Récupère une variable extérieure à l'application par priorité :
	 * - en get
	 * - en post
	 * - en session
	 *  
	 * @param $key clé correspondante
	 * @return la valeur correspondante
	 */
	function getPost($key){
		if(isset($_GET[$key])){
			return $_GET[$key];
		}elseif(isset($_POST[$key])){
				return $_POST[$key];
		}elseif(isset($_SESSION[$key])){
			return $_SESSION[SESSION_KEY][$key];
		}else{
			return NULL;
		}
	}
	
	/**
	 * Préparation avant affichage 
	 */
	function generateHTML(){
		$this->currentPage->generateHTML();
	}
	
	/**
	 * Cette fonction affiche le code html généré 
	 * @param $tplPath chemin d'accès au répertoire de template doit finir par un /
	 */
	function display($tplPath){
		//contenu de la page courante
		$this->currentPage->content($tplPath);	
	}
	
	function storeSessionValue($key, $value){
		//mise à jour objet
		$this->session[$key] = $value;

		//sauvegarde en session
		$_SESSION[SESSION_KEY] = $this->session; 
	}
	
	function getSessionValue($key){
		return $this->session[$key];
	}
	
	
}

?>