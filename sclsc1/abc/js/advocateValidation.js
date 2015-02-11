function validateAdvocateForm()
{	
	//alert('Hi');
	var form = document.advo_regis;
	
	if(form.title.value == "")
	{
	alert( "Please Select Tittle." );
	form.title.focus();
	return false;
	}
	if(form.full_name.value == "")
	{
	alert( "Please Enter Name." );
	form.full_name.focus();
	return false;
	}
/*	if(form.advocate_code.value == "")
	{
	alert( "Please Enter Advocate Code." );
	form.advocate_code.focus();
	return false;
	}
*/	
	if ( ( form.gender[0].checked == false ) && ( form.gender[1].checked == false ) )
	{
	alert ( "Please Select your Gender: Male or Female" );
	return false;
	}
/*	
	if(form.lang.value == "")
	{
	alert( "Please Enter Languages." );
	form.lang.focus();
	return false;
	}	
	
	if(form.email_id.value=="")
	{
	alert("Please Enter Email id");
	form.email_id.focus();
	return false;
	}
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var x=form.email_id.value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	 if ( !filter.test(applicant_mail_id.value) && (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) )
	  {
	  alert("Not a valid e-mail address");
	  form.email_id.focus();
	  return false;
	  }	
*/			
		if(form.date_of_enrol.value=="")
		{
		alert("Enter Enrolment Date as Advovate");
		form.date_of_enrol.focus();
		return false;
		}
		
		if(form.date_of_scba.value=="")
		{
		alert("Enter Enrolment Date as member of SCBA  ");
		form.date_of_scba.focus();
		return false;
		}
		
		if(form.date_of_scba.value <= form.date_of_enrol.value)
		{
		alert("Enrolment Date as member of SCBA must be Greater than Enrolment Date as Advovate ");
		form.date_of_scba.focus();
		return false;
		}
		
		if(form.aor.value!="")
		{
			if(form.aor.value <= form.date_of_enrol.value)
			{
			alert("AOR Designate Date must be Greater than Enrolment Date as member of SCBA ");
			form.date_of_scba.focus();
			return false;
			}
		}
		
		if(form.date_of_reg.value == "")
		{
		alert( "Enter Date Of Registration." );
		form.date_of_reg.focus();
		return false;
		}
		
		if(form.name_of_bar.value=="")
		{
		alert("Enter Bar Council Where Enrolled ");
		form.name_of_bar.focus();
		return false;
		}
		

/*		
		if(form.aor.value=="")
		{
		alert("Enter Date of Becoming Advocate on Record From  ");
		form.aor.focus();
		return false;
		}
*/				
		if(form.address1.value=="")
		{
		alert("Please Enter Advovate Address");
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
		alert("Please Select State.");
		form.state.focus();
		return false;
		}
	
		if(document.getElementById('comm_add').checked==true)
		  {
			//alert(isSeniorAdvocate);
			if(form.c_name.value=="")
			{
			alert("Please Enter Full Name.");
			form.c_name.focus();
			return false;
			}		
			if(form.c_address1.value=="")
			{
			alert("Please Enter Address Line 1.");
			form.c_address1.focus();
			return false;
			}
			
			if(form.c_city.value=="")
			{
			alert("Please Enter City.");
			form.c_city.focus();
			return false;
			}
			
			if(form.c_state.value=="")
			{
			alert("Please Select State.");
			form.c_state.focus();
			return false;
			}
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


function aorDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.aor.value != '') 
	{
		if(regs = form.aor.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'aor\').focus();document.getElementById(\'aor\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'aor\').focus();document.getElementById(\'aor\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'aor\').focus();document.getElementById(\'aor\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.aor.value);
			form.aor.focus(); 
			return false; 
		} 
	} 
}

function enrolDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.date_of_enrol.value != '') 
	{
		if(regs = form.date_of_enrol.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'date_of_enrol\').focus();document.getElementById(\'date_of_enrol\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'date_of_enrol\').focus();document.getElementById(\'date_of_enrol\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'date_of_enrol\').focus();document.getElementById(\'date_of_enrol\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.date_of_enrol.value);
			form.date_of_enrol.focus(); 
			return false; 
		} 
	} 
}


function enrolScbaDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.date_of_scba.value != '') 
	{
		if(regs = form.date_of_scba.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'date_of_scba\').focus();document.getElementById(\'date_of_scba\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'date_of_scba\').focus();document.getElementById(\'date_of_scba\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'date_of_scba\').focus();document.getElementById(\'date_of_scba\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.date_of_scba.value);
			form.date_of_scba.focus(); 
			return false; 
		} 
	} 
}


function regDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.date_of_reg.value != '') 
	{
		if(regs = form.date_of_reg.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'date_of_reg\').focus();document.getElementById(\'date_of_reg\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'date_of_reg\').focus();document.getElementById(\'date_of_reg\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'date_of_reg\').focus();document.getElementById(\'date_of_reg\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.date_of_reg.value);
			form.date_of_reg.focus(); 
			return false; 
		} 
	} 
}

function startDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.txtFrom.value != '') 
	{
		if(regs = form.txtFrom.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'txtFrom\').focus();document.getElementById(\'txtFrom\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'txtFrom\').focus();document.getElementById(\'txtFrom\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'txtFrom\').focus();document.getElementById(\'txtFrom\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.txtFrom.value);
			form.txtFrom.focus(); 
			return false; 
		} 
	} 
}


function endDate(form)
{
	
	re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
	if(form.txtTo.value != '') 
	{
		if(regs = form.txtTo.value.match(re)) 
		{ 
			// day value between 1 and 31 
			if(regs[1] < 1 || regs[1] > 31) 
			{
				alert("Invalid value for day: " + regs[1]); 
				setTimeout('document.getElementById(\'txtTo\').focus();document.getElementById(\'txtTo\').select();',0);
				return false; 
			}
			// month value between 1 and 12 
			if(regs[2] < 1 || regs[2] > 12) 
			{
				alert("Invalid value for month: " + regs[2]);
				setTimeout('document.getElementById(\'txtTo\').focus();document.getElementById(\'txtTo\').select();',0);
				return false; 
			} 
			// year value between 1970 and 2014 
			if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
			{
				alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
				setTimeout('document.getElementById(\'txtTo\').focus();document.getElementById(\'txtTo\').select();',0);
				return false; 
			}
		} else 
		{
			alert("Invalid date format: " + form.txtTo.value);
			form.txtTo.focus(); 
			return false; 
		} 
	} 
}
