<?
spl_autoload_register(function ($class){
    include __DIR__.'/cls/' . $class . '.class.php';
});

function validateValue($name, $value) {

	//REGEX can be added to any field name
	$regexListArr = array (
		"name" => "\\S",
		'email' => "[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,6})",
		'tel' => "[0-9 (\\)\\+]{10,30}"
	);	
		
	$cleared = true;

	//check value against regex array
	if(isset($regexListArr[$name])){
		if (!preg_match ('/'.$regexListArr[$name].'/', $value)){
			$cleared = false;
		}
	}
	return $cleared;
}

function sendMail($inputs){
	
	//TEMP EMAIL ACC from maildrop.cc
	$mailaddress = 'near_perfection@maildrop.cc';
	$mailsubject = 'Message from the '.$_SERVER['SERVER_NAME'].' Contact Form';
	$mailMsg = "<p>".$mailsubject."</p>";

	//add each field
	foreach ($inputs as $key => $value) {
		$mailMsg .= "<p>".$key.": ".$value."</p>";
	}

	//send fields to master mail template
	$mailer = new Mail();
	$mailer->sendMasterTemplate($mailaddress, $mailsubject, $mailMsg);

	return true;
}


if($_POST['task'] == 'quickContactSend'){

	$errorListArr = array();
	$responceArr = array();
	$cleared = true;

	// Build Error list if required
	foreach (json_decode($_REQUEST["inputs"]) as $key => $value) {
		
		if(!validateValue($key, $value)){
					$cleared = false;
					array_push($errorListArr, $key);
		}
	}

	// proceed with send mail if validation is cleared
	if($cleared){
		if(sendMail(json_decode($_REQUEST["inputs"]))){
			echo json_encode('sent');
		}
	}else{
		//return error list
		echo json_encode($errorListArr);
	}
 }

			
die();
?>