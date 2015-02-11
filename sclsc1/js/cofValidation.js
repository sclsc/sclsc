function validateCOF()
{	
	//alert('Hi');
	var form = document.dispatch_detail;
	

	if(form.letterType.value == "")
	{
	alert( "Please Enter Letter Type." );
	form.letterType.focus();
	return false;
	}
	
	if(form.subject.value == "")
	{
	alert( "Please Enter Subject." );
	form.subject.focus();
	return false;
	}

 return true;
		 
	}

//only for alphavat 
function alphadot_hyphendigit_No_Limited(e)
{	
	var key;
	var keychar;
	if (window.event){
		key = window.event.keyCode;		
	}else if (e){
		key = e.which;		
	}
	else
		return true;
	if((key == 8) || (key == 0))
		return true;
		
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	if(key!=32)
	{ 		
		invalids = "`~@#$%^*()_+=\|{}[]:'\"<>?/,1234567890;!.\\";
		//invalids = "`~@#$%^*()_+=\|{}[]:;'\"<>&?/!,\\";
		for(i=0; i<invalids.length; i++) {
			if(keychar.indexOf(invalids.charAt(i)) >= 0 || keychar==false) {				           			  
				return false;               
			}
		}
	}
	return true;		
}

/* only for number */
function number(e)
{	
	var key;
	var keychar;
	if (window.event){
		key = window.event.keyCode;		
	}else if (e){
		key = e.which;		
	}
	else
		return true;
	
	if((key == 8) || (key == 0))
		return true;
		
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	if((key > 47) && (key < 58)){				
		return true;
	}else
	    return false;	
}