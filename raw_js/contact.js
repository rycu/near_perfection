var errorListArr = [];
var inputListObj = {};

var regexListObj = {

	"name" : ["\\S", "required field"],
	"email" : ["[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,6})", "please enter a valid email address"],
	"tel" : ["[0-9 (\\)\\+]{10,30}", "please enter a valid telephone number"]

};

function validateValue(name, value) {

	var cleared = true; 

	if(regexListObj.hasOwnProperty(name)){
		var thisRegex = new RegExp(regexListObj[name][0]);
		
		if(!thisRegex.test(value)){ 
			errorListArr.push(name);
			cleared = false;
		}
		/*alert('name: '+name+'\nvalue: '+value+'\nRegex: '+thisRegex+'\noutcome: '+cleared);*/
	} 
	return cleared;
}

function quickContactSend(formIn){ 

	event.preventDefault();

	var cleared = true;
	for (var i=0; i<formIn.length; i++) { 
	
		if(formIn[i].name !== ''){ 

			inputListObj[formIn[i].name] = formIn[i].value;

			if(!validateValue(formIn[i].name, formIn[i].value)){
				cleared = false;
			} 
		} 
	}

	 if (!cleared) {
	 	displayErrors();
	 }else{
		apiCall(
			'task=quickContactSend'+
			'&inputs='+
			JSON.stringify(inputListObj)
		);
	}
}



function apiCall(dataIn){

    jQuery.ajax({
    	type:"POST",                                      
      	url: templateUrl+'/api.php',         
      	data: dataIn,                                
      	dataType: 'json',                  
      	success:function(response)        
      	{
      		if(response == 'sent'){
      			displaySucsess();
      		}else{
      			errorListArr = response;
      			displayErrors();
      		}
      		console.log("API response: "+response);
      	},
      	error: function(errorThrown){
            console.log(errorThrown);
        }		 
    });
}



function displayErrors(){

	jQuery(".inputField").css("background-color", "");
	jQuery(".valMsg").html("");

	console.log("errorList: "+errorListArr);

	jQuery.each(errorListArr, function(index, val) {
		 jQuery("#"+val).css("background-color", "#fdd8d8");
		 jQuery("#"+val+"ValMsg").html(regexListObj[val][1]);

	});

	errorListArr = [];

}



function displaySucsess(){

	jQuery("#quickContactForm").html("<div id='msgSent'><h2>Message Sent</h2><p>We shall be in contact as soon as possible</p></div>");

}