<?php 
	
	for($i = 1; $i <= $_SESSION['counter'];$i++)
	{
	$applicant = 'applicant'.$i;
	unset($_SESSION[$applicant]);
	}
	unset($_SESSION['counter']);
		
	unset($_SESSION['diary_number']);
	unset($_SESSION['received_date']);
	unset($_SESSION['received_through_type']);
	unset($_SESSION['received_through']);
	unset($_SESSION['applicant1']);
	unset($_SESSION['last_completed_stage']);
	unset($_SESSION['appli_case_type']);
	unset($_SESSION['case_filed_advocate_name']);
	unset($_SESSION['case_filed__advocate_appointment_date']);
	unset($_SESSION['case_filed_legal_aid_grant_number']);
	unset($_SESSION['applicationId']);
?>