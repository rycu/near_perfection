<?
class Mail extends MailParts{

	private $mailFrom;
	private $mailSubject;
	private $boundary;
	private $imagePath;
	private $masterTemplate;

	function __construct() {
		
		$this->mailFrom = 'donotreply@'.str_replace("www.", "", $_SERVER['SERVER_NAME']);
		$this->mailSubject = str_replace("www.", "", $_SERVER['SERVER_NAME']);
		$this->boundary = uniqid('np');
		$this->imagePath = 'https://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['REQUEST_URI']), '', $_SERVER['REQUEST_URI']).'img/';
		ob_start();
		include __DIR__.'/../eml/masterTemplate.php';
		$this->masterTemplate = ob_get_clean();
	}
	
	private function getPlaintext($htmlIn){
	
		$textOut = str_replace(array('<br />', '</p>', '&nbsp;'), '*xxx*', $htmlIn);
		$textOut = preg_replace( '/[\v]|<.*?>/', '', $textOut) ;
		$textOut = str_replace('*xxx*', '
', $textOut);
		
		return $textOut;
	}
	
	
	private function templatefill($sub, $msg){	
	
		$templateIn = $this->masterTemplate;
		$templateIn =  str_replace('TITLE_LINE', 	$sub, $templateIn );
		$templateIn =  str_replace('LOGO_LOCATION', $this->imagePath, $templateIn );
		$templateIn =  str_replace('MAIN_MESSAGE', 	$msg, $templateIn );
		$templateIn =  str_replace('FOOTER_TEXT', 	$this->footer, $templateIn );
		
		return $templateIn;
	}
	
	private function getHeaders(){
	
		$headers = "From: ".$this->mailFrom."\n";
		$headers .= "Bcc: \n";
		$headers .= "X-Mailer: PHP/". phpversion()."\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative;boundary=" .$this->boundary . "\n";
		
		return $headers;
	}
	
	private function getMessageBlock($sub, $msg){
	
		$htmlMsg = $this->templatefill($sub, $msg);
		$textMsg = $this->getPlaintext($htmlMsg);
	
		$message = "This is a MIME encoded message."; 	
		$message .= "\n\n--" . $this->boundary . "\n";
		$message .= "Content-type: text/plain;charset=utf-8\n\n";
		$message .= $textMsg;	
		$message .= "\n\n--" . $this->boundary . "\n";
		$message .= "Content-type: text/html;charset=utf-8\n\n";
		$message .= $htmlMsg;
		$message .= "\n\n--" . $this->boundary . "--\n\n";
		
		return $message;
	}
	
	public function sendMasterTemplate($to, $sub, $msg) {
	
		mail($to, $this->mailSubject.' '.$sub, $this->getMessageBlock($sub, $msg), $this->getHeaders());
	
	}
	
}
?>
