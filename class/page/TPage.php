<?php

require_once("lib/log4php/Logger.php");

abstract class TPage {

	///Fichier template 
	protected $_tplFile;
	
	//titre de la page
	protected $title;	
	
	//accès au logger
	protected $logger;
	
	protected $test;
	
	//gestion de la session courante
	//protected $sessionMgr;
	
	//message d'erreur à afficher
	private $error;

	//objet regroupant tout les paramètres de l'application
	protected $_param;

	/// objet regroupant tout les paramètres de template
	protected $page;
	
	/**
	 * 
	 * Constructeur
	 * 
	 * @param $tplFile chemin vers le nom du fichier à partir du répertoire de stockage des fichier template
	 * @param $title titre correspondant à la page
	 * @param $app objet application pour accèder au variable post, get et session
	 */
	public function __construct($tplFile, $title, Application $app/*,SessionMgr $sessionMgr*/){
		$this->_tplFile     = $tplFile;
		$this->logger = Logger::getRootLogger();
		$this->app = $app;		
		
		/// Paramètre utilisé par le template
		$this->page = new stdClass();
		$this->page->title = $title;
		
		//$this->sessionMgr = $sessionMgr;
	}

	/**
	 * Cette fonction à réimplémenter
	 * affiche le contenu à afficher
	 * 
	 * @param  $tplPath chemin vers les fichiers template de l'application doit 
	 * finir par un /
	 */
	public function content($tplPath){
		printt($this->page, $tplPath."head.tpl");
		printt($this->page, $tplPath.$this->_tplFile);
		printt($this->page, $tplPath."foot.tpl");
	}

	protected function addError($error){
		$this->error = $this->error."<li>".$error."</li>";
	}
	
	protected function getError(){
		return $this->error;
	}
	
	///Page remplissant l'objet page qui contient les différents item du template
	abstract function generateHTML();


}

?>
