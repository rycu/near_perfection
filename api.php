<?
spl_autoload_register(function ($class){
    include __DIR__.'/cls/' . $class . '.class.php';
});


function validateValue($name, $value) {

	$regexListArr = array (
		"name" => "\\S",
		'email' => "[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,6})",
		'tel' => "[0-9 (\\)\\+]{10,30}"
	);	
		
	$cleared = true;

	if(isset($regexListArr[$name])){
		if (!preg_match ('/'.$regexListArr[$name].'/', $value)){
			$cleared = false;
		}
	}
	return $cleared;
}


if($_POST['task'] == 'quickContactSend'){

	$errorListArr = array();
	$responceArr = array();

	$cleared = true;

	foreach (json_decode($_REQUEST["inputs"]) as $key => $value) {
		
		if(!validateValue($key, $value)){
					$cleared = false;
					array_push($errorListArr, $key);
		}
	}

	if($cleared){
		if(sendMail(json_decode($_REQUEST["inputs"]))){

			echo json_encode('sent');
		}
		
	}else{
		echo json_encode($errorListArr);
	}
 }


function sendMail($inputs){
	
	$mailaddress = 'rycuMMXVII@cuttermail.co.uk';
	
	$mailsubject = 'Message from the '.$_SERVER['SERVER_NAME'].' Contact Form';
	
	$mailMsg = "<p>".$mailsubject."</p>";

	foreach ($inputs as $key => $value) {
		$mailMsg .= "<p>".$key.": ".$value."</p>";
	}

	$mailer = new Mail();
	
	$mailer->sendMasterTemplate($mailaddress, $mailsubject, $mailMsg);

	return true;

}
			
die();

?>