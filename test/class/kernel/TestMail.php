 <?php
	require_once("SendHtmlMail.php");

	$sendHtmlMail = new SendHtmlMail("newsletter@lebretagne.fr", "Programme cinéma Le Bretagne du semaine du 09/01/2011");

	$sendHtmlMail->addEmailAdress("jeromebarotin@gmail.com");
	$sendHtmlMail->addEmailAdress("jeromebarotin@gmail.com");
	$file = 'test.jpg';
	$html = '<html><body>HTML version of email <img src="'.$file.'" /></body></html>';

	$sendHtmlMail->setHTML($html);

	$sendHtmlMail->send();

	/*require_once('Mail.php');
	require_once('Mail/mime.php');

	$text = 'Text version of email';
	$file = 'test.jpg';
	$html = '<html><body>HTML version of email <img src="'.$file.'" /></body></html>';
	$crlf = "\n";
	$hdrs = array(
		      'From'    => 'toto@gloubi.com',
		      'Subject' => 'Test mime message'
		      );

	$mime = new Mail_mime($crlf);

	$mime->setTXTBody($text);
	$mime->setHTMLBody($html);
	$mime->addHTMLImage($file,mime_content_type($file),$file,true);
	//$mime->addAttachment($file, 'text/plain');

	//do not ever try to call these lines in reverse order
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);

	print_r($hdrs);

	//mail("jeromebarotin@gmail.com","test.....",$body);

	$mail = new Mail();
	//::factory('mail');
	$mail->send('jeromebarotin@gmail.com', $hdrs, $body);*/

?>

