<?php

	require_once('Mail.php');
	require_once('Mail/mime.php');

/**
 * Cette classe permet d'envoyer des mails au format HTML
 *
 * Sa particularité est qu'elle parcour le fichier html pour 
 */
class SendHtmlMail {
	
	/// Objet contenant le contenu mime du mail
	private $mime;

	///Addresse d'envoie
	private $senderAddr;

	///Objet du mail
	private $msgObject;
	
	/// Liste des adresses à qui on envoies
	private $recipients;

	function __construct($senderAddr, $object){
		$this->mime = new Mail_mime("\n");
		$this->senderAddr = $senderAddr;
		$this->msgObject = $object;
	}

	function addEmailAdress($email){
		$this->recipients[] = $email;
	}

	function setHTML($html){
		//Pour commencer on indexe toutes les images
		$matches = array();
		$orig = array();
		$dest = array();
		preg_match_all("/<img src\=\"(.*)\"/", $html, $matches);
		//print_r($matches);

		foreach($matches[1] as $file){
			$orig[] = "/".$file."/";
			$dest[] = basename($file);
		}

		//Ensuite, on remplace par leurs versions courte
		$html = preg_replace($orig,$dest,$html);

		//echo $html;
		//mémorisation en contenu mime du html
		$this->mime->setHTMLBody($html);
	
		//Enfin on ajoute au contenu les fichiers en question au fichier
		foreach($matches[1] as $file){
			$this->mime->addHTMLImage($file,mime_content_type($file),basename($file),true);
		}
	}

	function setText($text){
		$this->mime->setTXTBody($text);	
	}

	function send(){
		$hdrs = array(
		      'From'    => $this->senderAddr,
		      'Subject' => $this->msgObject
		      );
		$body = $this->mime->get();
		$hdrs = $this->mime->headers($hdrs);

		$mail = new Mail();
		$mail->send($this->recipients, $hdrs, $body);
	}
}

?>
