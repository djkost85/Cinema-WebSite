<?

require_once("class/model/Newsletters.php");
require_once("class/page/TPage.php");

class NewsLettersPage extends TPage {
	
	//en mode edit il s'agit de la newsletters courante
	private $currentNewsletter;
	
	function __construct(Application $app){
		parent::__construct("page/NewsletterMenu.tpl", "Gestion NewsLetters", $app);
		$action = $this->app->getPost("action");
		switch($action){
			case "edit" :
				$this->_tplFile = "page/NewsletterEdit.tpl";
				$save = $this->app->getPost('save');
				$contents = $this->app->getPost('contents');
				$object = $this->app->getPost('object');
				if(($save != null)&&($contents != null)&&($object != null)){
					//sauvegarde de la newsletters en cours d'édition 
					$this->currentNewsletter = $this->app->getSessionValue("NewsLettersPageCurrentNewsletter");
					$this->currentNewsletter->setContents($_POST['contents']);
					$this->currentNewsletter->setObject($_POST['object']);
					$this->currentNewsletter->storeInDb();
					
				}else{
					//c'est qu'on est en mode création d'une nouvelle newsletters
					$this->currentNewsletter = new Newsletters(); 
				}
				
				$this->app->storeSessionValue("NewsLettersPageCurrentNewsletter",$this->currentNewsletter);
				
			break;
			case "manage" :
			break;
			case "subscriber" :
			break;
		}
		
		
	}
	
	function generateHTML(){
		if($this->_tplFile == "page/NewsletterCreate.tpl"){
			$this->page->object = $this->currentNewsletter->getObject();
			$this->page->contents = $this->currentNewsletter->getContents();
		}
	}
	
	
}

?>
