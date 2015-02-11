	function validateDiary() 
	{		
		var diary_no = document.getElementById('diary_number').value;
		var received_date = document.getElementById('received_date').value;
		var received_through_type = document.getElementById('received_through_type').value;
		var received_through = document.getElementById('received_through').value;
		if(diary_no == '')
		{
			alert("Enter Diary Number");
			document.getElementById('diary_number').focus();
			return false;
		}
		if(received_date == '')
		{
			alert("Enter Received Date");
			document.getElementById('received_date').focus();
			return false;
		}
		if(received_through_type != '')
		{
			if(received_through == '')
			{
				alert("Enter received through");
				document.getElementById('received_through').focus();
				return false;
			}
		}
	}
	function myFunction(form)
	{
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.received_date.value != '') 
		{
			if(regs = form.received_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					setTimeout('document.getElementById(\'received_date\').focus();document.getElementById(\'received_date\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					setTimeout('document.getElementById(\'received_date\').focus();document.getElementById(\'received_date\').select();',0);
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
					setTimeout('document.getElementById(\'received_date\').focus();document.getElementById(\'received_date\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.received_date.value);
				form.received_date.focus(); 
				return false; 
			} 
		} 
	}
	
	function myFunction1(form)
	{
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.appointed_advocate_apointment_date.value != '') 
		{
			if(regs = form.appointed_advocate_apointment_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
				//	form.appointed_advocate_apointment_date.focus(); 
					setTimeout('document.getElementById(\'appointed_advocate_apointment_date\').focus();document.getElementById(\'appointed_advocate_apointment_date\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
				//	form.appointed_advocate_apointment_date.focus(); 
					setTimeout('document.getElementById(\'appointed_advocate_apointment_date\').focus();document.getElementById(\'appointed_advocate_apointment_date\').select();',0);
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
				//	form.appointed_advocate_apointment_date.focus(); 
					setTimeout('document.getElementById(\'appointed_advocate_apointment_date\').focus();document.getElementById(\'appointed_advocate_apointment_date\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.received_date.value);
			//	form.appointed_advocate_apointment_date.focus(); 
				setTimeout('document.getElementById(\'appointed_advocate_apointment_date\').focus();document.getElementById(\'appointed_advocate_apointment_date\').select();',0);
				return false; 
			} 
		} 
	}
	
	function myFunction2(form)
	{
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.case_filed_advocate_appointment_date.value != '') 
		{
			if(regs = form.case_filed_advocate_appointment_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
				//	form.case_filed_advocate_appointment_date.focus(); 
					setTimeout('document.getElementById(\'case_filed_advocate_appointment_date\').focus();document.getElementById(\'case_filed_advocate_appointment_date\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
				//	form.case_filed_advocate_appointment_date.focus(); 
					setTimeout('document.getElementById(\'case_filed_advocate_appointment_date\').focus();document.getElementById(\'case_filed_advocate_appointment_date\').select();',0);
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
				//	form.case_filed_advocate_appointment_date.focus(); 
					setTimeout('document.getElementById(\'case_filed_advocate_appointment_date\').focus();document.getElementById(\'case_filed_advocate_appointment_date\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.received_date.value);
			//	form.case_filed_advocate_appointment_date.focus(); 
				setTimeout('document.getElementById(\'case_filed_advocate_appointment_date\').focus();document.getElementById(\'case_filed_advocate_appointment_date\').select();',0);
				return false; 
			} 
		} 
	}
	function myFunction3(form)
	{
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.date_of_filing.value != '') 
		{
			if(regs = form.date_of_filing.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					form.date_of_filing.focus(); 
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					form.date_of_filing.focus(); 
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
					form.date_of_filing.focus(); 
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.received_date.value);
				form.date_of_filing.focus(); 
				return false; 
			} 
		} 
	}
	
	function myFunction4(form)
	{
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.date_of_filing.value != '') 
		{
			if(regs = form.case_filed_senior_advocate_appointment_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					form.case_filed_senior_advocate_appointment_date.focus(); 
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					form.case_filed_senior_advocate_appointment_date.focus(); 
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
					form.case_filed_senior_advocate_appointment_date.focus(); 
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.received_date.value);
				form.case_filed_senior_advocate_appointment_date.focus(); 
				return false; 
			} 
		} 
	}
	
	function myFunction5(form)
	{
		
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.doc_completed_date.value != '') 
		{
			if(regs = form.doc_completed_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					setTimeout('document.getElementById(\'doc_completed_date\').focus();document.getElementById(\'doc_completed_date\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					setTimeout('document.getElementById(\'doc_completed_date\').focus();document.getElementById(\'doc_completed_date\').select();',0);
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 1990 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1990 and " + (new Date()).getFullYear()); 
					setTimeout('document.getElementById(\'doc_completed_date\').focus();document.getElementById(\'doc_completed_date\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.doc_completed_date.value);
				form.doc_completed_date.focus(); 
				return false; 
			} 
		} 
	}
	
	function myFunction6(form)
	{
		
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.scls_appointment_date.value != '') 
		{
			if(regs = form.scls_appointment_date.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					setTimeout('document.getElementById(\'scls_appointment_date\').focus();document.getElementById(\'scls_appointment_date\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					setTimeout('document.getElementById(\'scls_appointment_date\').focus();document.getElementById(\'scls_appointment_date\').select();',0);
					return false; 
				} 
				// year value between 1970 and 2014 
				if(regs[3] < 1970 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1970 and " + (new Date()).getFullYear()); 
					setTimeout('document.getElementById(\'scls_appointment_date\').focus();document.getElementById(\'scls_appointment_date\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.scls_appointment_date.value);
				form.scls_appointment_date.focus(); 
				return false; 
			} 
		} 
	}
	
	
	function dobValidation(form)
	{
		
		re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
		if(form.dob.value != '') 
		{
			if(regs = form.dob.value.match(re)) 
			{ 
				// day value between 1 and 31 
				if(regs[1] < 1 || regs[1] > 31) 
				{
					alert("Invalid value for day: " + regs[1]); 
					setTimeout('document.getElementById(\'dob\').focus();document.getElementById(\'dob\').select();',0);
					return false; 
				}
				// month value between 1 and 12 
				if(regs[2] < 1 || regs[2] > 12) 
				{
					alert("Invalid value for month: " + regs[2]);
					setTimeout('document.getElementById(\'dob\').focus();document.getElementById(\'dob\').select();',0);
					return false; 
				} 
				// year value between 1902 and 2014 
				if(regs[3] < 1910 || regs[3] > (new Date()).getFullYear()) 
				{
					alert("Invalid value for year: " + regs[3] + " - must be between 1910 and " + (new Date()).getFullYear()); 
					setTimeout('document.getElementById(\'dob\').focus();document.getElementById(\'dob\').select();',0);
					return false; 
				}
			} else 
			{
				alert("Invalid date format: " + form.dob.value);
				form.dob.focus(); 
				return false; 
			} 
		} 
	}


	function validateApplicant(applicationThrough)
	 {
	 var applicant_name = document.getElementById('applicant_name').value;
	 var custody_jails = document.getElementById('showJails').value;
	 var custody_state = document.getElementById('custody_state').value; 
	 var address1 = document.getElementById('address1').value;
	 var applicant_city = document.getElementById('applicant_city').value;
	 var applicant_state = document.getElementById('applicant_state').value;
	 var applicant_pincode = document.getElementById('applicant_pincode').value;
	 var contact_number = document.getElementById('contact_number').value;
	 var mobile_number = document.getElementById('mobile_number').value;
	 var applicant_mail_id = document.getElementById('applicant_mail_id').value;
	 var atpos = applicant_mail_id.indexOf("@");
	 var dotpos = applicant_mail_id.lastIndexOf(".");
	 var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	 var digit = /[0-9]/;
	 var vals = [];

	 $('input:checkbox[name="eligibility_condition[]"]').each(function() {
	 if (this.checked) {
	 vals.push(this.value);
	 }
	 });
//	 alert(applicationThrough);
//	 alert(vals.toString());
	 if(applicant_name == '')
	 {
	 alert("Enter Applicant Name");
	 document.getElementById('applicant_name').focus();
	 return false;
	 }
	 
	 if(contact_number != '')
	 {
	 if (!digit.test(contact_number))
	 {
	 alert("Invalid Contact Number.");
	 document.getElementById('contact_number').focus();
	 return false;
	 }
	 }
	 
	 if(applicant_mail_id != '')
	 {
		
	 if (!filter.test(applicant_mail_id.value) && (atpos< 1 || dotpos<atpos+2 || dotpos+2>=applicant_mail_id.length)) {
	 alert("Not a valid e-mail address");
	 document.getElementById('applicant_mail_id').focus();
	 return false;
	 }
	 }
	 if(vals.length == 0)
	 {
	 alert("Please add atleast one eligibility codition");
	 return false;
	 }
	 if(applicationThrough != 33)
	 {
	 for(i=0;i<vals.length;i++)
	 { 
	 if(vals[i] == 14 && custody_state == '')
	 {
	 alert("Please Select State1");
	 //document.getelementsbyname('custody_state').focus();
	 return false;
	 } 
	 
	 if(vals[i] == 14 && custody_jails == '')
	 {
	 alert("Please Select Jail");
	 // document.getelementsbyname('custody_jails').focus();
	 return false;
	 }
	 }
	 }
	 }
	
	
	function validate1()
	{
		var appli_case_type = document.getElementById('appli_case_type').value;
		var last_completed_stage = document.getElementById('last_completed_stage').value;
		if(appli_case_type == '')
		{
			alert("Select Application Type");
			document.getElementById('appli_case_type').focus();
			return false;
		}
		if(last_completed_stage == '')
		{
			alert("Select Last Completed stage");
			document.getElementById('last_completed_stage').focus();
			return false;
		}
	}
	/*
	function submitHighCourt()
	{
		var high_court_name = document.getElementById('high_court_name').value;
		var case_type = document.getElementById('case_type').value;
		var case_number = document.getElementById('case_number').value;
		var case_year = document.getElementById('case_year').value;
		var petitioner = document.getElementById('petitioner').value;
		var respondent = document.getElementById('respondent').value;
		var judgement_date = document.getElementById('judgement_date').value;
		if(high_court_name == '')
		{
			alert("Select High Court");
			return false;
		}
		if(case_type == '')
		{
			alert("Enter Case Type");
			return false;
		}
		if(case_number == '')
		{
			alert("Enter Case Number");
			return false;
		}
		if(case_year == '')
		{
			alert("Enter Case Year");
			return false;
		}
		if(petitioner == '')
		{
			alert("Enter Petitioner");
			return false;
		}
		if(respondent == '')
		{
			alert("Enter Respondent");
			return false;
		}
		if(judgement_date == '')
		{
			alert("Enter Judgement Date");
			return false;
		}
	}
	*/
	
	
	function validate2()
	{
		
		var appointed_advocate_name = document.getElementById('appointed_advocate_name').value;
		var appointed_advocate_apointment_date = document.getElementById('appointed_advocate_apointment_date').value;
		var appointed_legal_aid_grant_number = document.getElementById('appointed_legal_aid_grant_number').value;
		
		if(appointed_advocate_name == '')
		{
			alert("Enter Advocate Name");
			document.getElementById('appointed_advocate_name').focus();
			return false;
		}
		if(appointed_advocate_apointment_date == '')
		{
			alert("Enter Appointment Date");
			document.getElementById('appointed_advocate_apointment_date').focus();			
			return false;
		}
		if(appointed_legal_aid_grant_number == '')
		{
			alert("Enter Legal Aid Grant NUmber");
			document.getElementById('appointed_legal_aid_grant_number').focus();
			return false;
		}
	}
	
	function validate3()
	{		
		var case_filed_advocate_name = document.getElementById('case_filed_advocate_name').value;
		var case_filed_advocate_appointment_date = document.getElementById('case_filed_advocate_appointment_date').value;
		var case_filed_aid_grant_number = document.getElementById('case_filed_aid_grant_number').value;
		
		if(case_filed_advocate_name == '')
		{
			alert("Enter Advocate Name");
			document.getElementById('case_filed_advocate_name').focus();
			return false;
		}
		if(case_filed_advocate_appointment_date == '')
		{
			alert("Enter Appointment Date");
			document.getElementById('case_filed_advocate_appointment_date').focus();
			return false;
		}
		if(case_filed_aid_grant_number == '')
		{
			alert("Enter Legal Aid Grant NUmber");
			document.getElementById('case_filed_aid_grant_number').focus();
			return false;
		}
	}
	
	function validate4()
	{
		
		var date_of_filing = document.getElementById('date_of_filing').value;
		var petitioner = document.getElementById('petitioner').value;
		var respondent = document.getElementById('respondent').value;
		var sci_case_type = document.getElementById('sci_case_type').value;
		var case_filed_case_number = document.getElementById('case_filed_case_number').value;
		var sci_field_year = document.getElementById('sci_field_year').value;
		var isSeniorAdvocate = document.getElementById('isSeniorAdvocate').value;
		var case_filed_senior_advocate_name = document.getElementById('case_filed_senior_advocate_name').value;
		var case_filed_senior_advocate_appointment_date = document.getElementById('case_filed_senior_advocate_appointment_date').value;
		
		if(date_of_filing == '')
		{
			alert("Enter Date Of Filing");
			document.getElementById('date_of_filing').focus();
			return false;
		}
		if(petitioner == '')
		{
			alert("Enter Petitioner");
			document.getElementById('petitioner').focus();
			return false;
		}
		if(respondent == '')
		{
			alert("Enter respondent");
			document.getElementById('respondent').focus();
			return false;
		}
		if(sci_case_type == '')
		{
			alert("Select SCI Case type");
			document.getElementById('sci_case_type').focus();
			return false;
		}
		if(case_filed_case_number == '')
		{
			alert("Enter case number");
			document.getElementById('case_filed_case_number').focus();
			return false;
		}
		if(sci_field_year == '')
		{
			alert("Select Year");
			document.getElementById('sci_field_year').focus();
			return false;
		}
	if(document.getElementById('isSeniorAdvocate').checked==true)
	  {
		//alert(isSeniorAdvocate);
		if(case_filed_senior_advocate_name == '')
        {
			alert("Enter Senior Advocate Name");
			document.getElementById('case_filed_senior_advocate_name').focus();
			return false;
        }		
		if(case_filed_senior_advocate_appointment_date == '')
        {
			alert("Enter Appointment Date");
			document.getElementById('case_filed_senior_advocate_appointment_date').focus();
			return false;
        }	
	 }
			
				
	}
	
	function showSeniorAdvocate(str)
	{
		if($('#isSeniorAdvocate').is(":checked"))   
	        $("#senior_advocate_apointed").show();
	    else
	        $("#senior_advocate_apointed").hide();
	}
	

		function validateAppThroughForm() {		
			var received_through_type = document.getElementById('received_through_type').value;
			var designation = document.getElementById('designation').value;
			var appli_through_type_name = document.getElementById('appli_through_type_name').value;
			var email_id = document.getElementById('email_id').value;
			var contact_number = document.getElementById('contact_number').value;
			var city = document.getElementById('city').value;
			var state = document.getElementById('state').value;
			var atpos = email_id.indexOf("@");
			var dotpos = email_id.lastIndexOf(".");
			var digit = /[0-10]/;


			
			if(received_through_type == '')
			{
				alert("Select Through Type");
				document.getElementById('received_through_type').focus();
				return false;
			}
			if(designation == '')
			{
				alert("Enter Designation");
				document.getElementById('designation').focus();
				return false;
			}
			if(appli_through_type_name == '')
			{
				alert("Enter Through Name");
				document.getElementById('appli_through_type_name').focus();
				return false;
			}
			
			if(email_id != '')
			{
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email_id.length) {
					alert("Not a valid e-mail address");
					setTimeout('document.getElementById(\'email_id\').focus();document.getElementById(\'email_id\').select();',0);
		        	return false;
		    	}
				
			}
			/*		
			if(contact_number != '')
			{
				if (!digit.test(contact_number))
				{
					alert("Invalid Contact Number.");
					document.getElementById('contact_number').focus();
					return false;
				}
			}
			
			
			
			if(address1 == '')
			{
				alert("Enter Address1");
				return false;
			}
			*/
			
			if(city == '')
			{
				alert("Enter City");
				document.getElementById('city').focus();
				return false;
			}
			if(state == '')
			{
				alert("Select State");
				document.getElementById('state').focus();
				return false;
			}
			
		}	
		
		function dateFunction(form)
		{
			re = /^(\d{1,2})\-(\d{1,2})\-(\d{4})$/;
			if(form.date1.value != '') 
			{
				if(regs = form.date1.value.match(re)) 
				{ 
					// day value between 1 and 31 
					if(regs[1] < 1 || regs[1] > 31) 
					{
						alert("Invalid value for day: " + regs[1]); 
						setTimeout('document.getElementById(\'date1\').focus();document.getElementById(\'date1\').select();',0);
						return false; 
					}
					// month value between 1 and 12 
					if(regs[2] < 1 || regs[2] > 12) 
					{
						alert("Invalid value for month: " + regs[2]);
						setTimeout('document.getElementById(\'date1\').focus();document.getElementById(\'date1\').select();',0);
						return false; 
					} 
					// year value between 1902 and 2014 
					if(regs[3] < 2000 || regs[3] > (new Date()).getFullYear()) 
					{
						alert("Invalid value for year: " + regs[3] + " - must be between 1902 and " + (new Date()).getFullYear()); 
						setTimeout('document.getElementById(\'date1\').focus();document.getElementById(\'date1\').select();',0);
						return false; 
					}
				} else 
				{
					alert("Invalid date format: " + form.date1.value);
					form.date1.focus(); 
					return false; 
				} 
			} 
		}