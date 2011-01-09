<?

require_once("class/page/TPage.php");

class Home extends TPage {
	
	function __construct(Application $app){
		parent::__construct("page/Home.tpl", "Acceuil", $app);
		
	}
	
	function generateHTML(){
		
	}
	
	
}

?>