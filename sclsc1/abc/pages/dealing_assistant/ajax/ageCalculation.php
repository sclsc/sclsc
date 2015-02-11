<?php
	$age = strtotime($_GET['received_date']) - strtotime($_GET['dob']);
	
	echo floor($age/(60*60*24*365));
?>
		
		