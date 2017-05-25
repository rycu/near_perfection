<?
echo '<form id="quickContactForm" onsubmit="quickContactSend(this)"><input type="hidden" name="currentPage" value="',get_permalink( $post->ID ),'">';

$fieldArr = array(
	'name' => array("Name", "text", "", "enter your name"),
	'tel' => array("Telephone", "tel", "", "enter your telephone number"),
	'email' => array("email", "email", "", "enter your email address")
);

foreach ($fieldArr as $key => $value) {
	
	echo '<label><span class="screen-reader-text">',$value[3],':</span><input type="',$value[1],'" id="',$key,'" name="',$key,'" class="inputField" tabindex="',$i,'" value="',$value[2],'" placeholder="',$value[0],'"/><span id="',$key,'ValMsg" class="valMsg"></span></label>';

}
echo '<label><span class="screen-reader-text">Enter your message</span><textarea id="msg" name="msg" class="inputField" placeholder="Your message"></textarea></label><button type="submit" tabindex="',$i,'">Send</button></form>';
?>