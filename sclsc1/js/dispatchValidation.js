function validateDispatch()
{	
	//alert('Hi');
	var form = document.dispatch_detail;
	

	if(form.name.value == "")
	{
	alert( "Please Enter Full Name." );
	form.name.focus();
	return false;
	}
	
	if(form.subject.value == "")
	{
	alert( "Please Enter Subject." );
	form.subject.focus();
	return false;
	}
	
		if(form.file_head.value=="")
		{
		alert("Please Enter File Head");
		form.file_head.focus();
		return false;
		}
		
		if(form.address1.value=="")
		{
		alert("Please Enter Address Line 1  ");
		form.address1.focus();
		return false;
		}
		
		if(form.state.value=="")
		{
		alert("Please Select State ");
		form.state.focus();
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


function validateLetterType()
{	
	//alert('Hi');
	var form = document.letter_type;
	

	if(form.name.value == "")
	{
	alert( "Please Enter Type Name." );
	form.name.focus();
	return false;
	}
	
	/*if(form.subject.value == "")
	{
	alert("Please Enter Subject File Path");
	form.subject.focus();
	return false;
	}
	
		if(form.title.value=="")
	{
	alert("Please Enter Title File Path");
	form.title.focus();
	return false;
	}
	
	if(form.letter_no.value=="")
	{
	alert("Please Enter Letter Number");
	form.letter_no.focus();
	return false;
	}

	if(form.header_file_path.value=="")
	{
	alert("Please Enter Header File Path");
	form.header_file_path.focus();
	return false;
	}
	
	if(form.body_file_path.value=="")
	{
	alert("Please Enter Body File Path");
	form.body_file_path.focus();
	return false;
	}
	
	if(form.note_file_path.value=="")
	{
	alert("Please Enter Note File Path");
	form.note_file_path.focus();
	return false;
	}
	
	if(form.stage.value=="")
	{
	alert("Please Enter Completed Stage");
	form.stage.focus();
	return false;
	}
	
	if(form.stage.value!="")
	{
		if(form.sub_stage.value=="")
		{
		alert("Please Enter Completed Sub Stage");
		form.stage.focus();
		return false;
		}
	}
*/	
	

		return true;
		 
	}

function validateHighCourtForm()
{
var form = document.form1;
var email = document.getElementById('email_id');
var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
	

	if(form.hc_name.value == "")
	{
	alert( "Please Enter High Court Name." );
	form.hc_name.focus();
	return false;
	}
	
	if(form.bench.value == "")
	{
	alert( "Please Enter Bench Name." );
	form.bench.focus();
	return false;
	}
	if(form.email_id.value == "")
	{
	alert( "Please Enter Email Id." );
	form.email_id.focus();
	return false;
	}
	
	 if(!filter.test(email.value))
	 {
	    alert('Please provide a valid email address');
	    form.email_id.focus;
	    return false;
     }
		
	 if(!form.mobile_no.value.match(phoneno))  
	{  
		    alert('Please provide a valid 10 digit Mobile no');
		    form.mobile_no.focus;
		    return false; 
	 }  
	 if(form.mobile_no.value == "")
	{
		alert( "Please Enter Mobile no." );
		form.email_id.focus();
		return false;
	}
		  
	if(form.hc_address1.value=="")
	{
	alert("Please Enter Address Line 1  ");
	form.address1.focus();
	return false;
	}
	if(form.city.value=="")
	{
	alert("Please Enter City ");
	form.city.focus();
	return false;
	}

	if(form.state.value=="")
	{
	alert("Please Select State ");
	form.state.focus();
	return false;
	}

		return true;	

}
/*function validateStageType()
{	
	//alert('Hi');
	var form = document.stage_name;
	

	if(form.stage_name.value == "")
	{
	alert( "Please Enter stage Name." );
	form.name.focus();
	return false;
	}
	
	if(form.stage_page.value == "")
	{
	alert( "Please Enter stage Page." );
	form.name.focus();
	return false;
	}
		return true;
		 
	}
*/
/*function validateSubStageType()
{	
	//alert('Hi');
	var form = document.substage_name;
	

	if(form.substage_name.value == "")
	{
	alert( "Please Enter Sub Stage Name." );
	form.name.focus();
	return false;
	}
	
	if(form.stage_page.value == "")
	{
	alert( "Please Enter stage Page." );
	form.name.focus();
	return false;
	}
		return true;
		 
	}*/

/*function validateApplicationTypeStage()
{
	alert('Hi');
	var form = document.applicationtype_name;
	

	if(form.stage_name.value == "")
	{
	alert( "Please Select Stage Name." );
	form.name.focus();
	return false;
	}
	
	if(form.application_type.value == "")
	{
	alert( "Please Select Application Type." );
	form.name.focus();
	return false;
	}
		return true;
}*/
