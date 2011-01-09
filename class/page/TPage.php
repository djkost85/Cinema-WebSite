<?php

abstract class TPage {

	///Fichier template 
	protected $_tplFile;
	
	//titre de la page
	protected $_title;	
	
	//accès au logger
	protected $logger;
	
	//gestion de la session courante
	protected $sessionMgr;
	
	//message d'erreur à afficher
	private $error;

	//objet regroupant tout les paramètres de l'application
	protected $_param;

	public function __construct(SessionMgr $sessionMgr, $tplFile, $title){
		$this->_tplFile     = $tplFile;
		$this->_title = $title;
		$this->logger = Logger::getRootLogger();
		$this->sessionMgr = $sessionMgr;
	}

	abstract protected function heart();

	public function render(){
		include $this->_tplPath."head.tpl";
		$this->heart();
		include $this->_tplPath."foot.tpl";

	}

	protected function addError($error){
		$this->error = $this->error."<li>".$error."</li>";
	}
	
	protected function getError(){
		return $this->error;
	}


}

?>