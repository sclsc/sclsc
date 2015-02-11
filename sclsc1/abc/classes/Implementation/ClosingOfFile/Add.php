<?php
	namespace classes\implementation\ClosingOfFile;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ClosingOfFile/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ClosingOfFile as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function generateLetter(
			 		$application_id,
			 		$letterType,			 				 		
			 		$subject,
			 		$to,
			 		$copyTo,
                    $stage_id )
		{
			
			
			$msg = array();
			$flag =0;
			$con = Conn\Connection::getConnection();
			
	/*		$length = 6;
			$letter_no = "";
			$possible = "023456789AbcdEfghjkLmnpqrsTvwxyz"; //no vowels			
			$i = 0;			
			while ($i < $length) {			
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);			
				if (!strstr($letter_no, $char)) {
					$letter_no .= $char;
					$i++;
				}
			}
	*/		
			try {				
				$con->beginTransaction();
				
				foreach ($to as $val)
				{				
				$sqlQuery = "INSERT INTO tbl_letters_disp_in_appli(application_id, applicant_id, stage_id, 
						 subject, letter_type)
						VALUES(:application_id, :applicant_id, :stage_id, :subject, :letter_type)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_id', $val, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);				
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':letter_type', $letterType, \PDO::PARAM_STR);							
				$statement->execute();
				
			$letters_disp_id = $con->lastInsertId('tbl_letters_disp_in_appli_id_seq'); 		
				
				$query = "SELECT a.applicant_name, b.applicant_address_line1, b.applicant_address_line2,
						b.applicant_city, b.applicant_state, b.applicant_pincode
						FROM tbl_applicants a
						JOIN tbl_applicant_address b ON a.id = b.applicant_id
						WHERE a.id=:applicant_id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':applicant_id', $val, \PDO::PARAM_INT);
				$stmt->execute();
				
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
				$name     = $row['applicant_name'];
				$address1 = $row['applicant_address_line1'];
				$address2 = $row['applicant_address_line2'];
				$city     = $row['applicant_city'];
				$state    = $row['applicant_state'];
				$pincode  = $row['applicant_pincode'];
				}
				
				$active = TRUE;			
				$sqlQuery = "INSERT INTO tbl_letter_disp_addressee(letters_disp_id, addressee_name, address1,
						address2, city, state, pincode, is_to, applicant_id, application_id, stage_id)
						VALUES(:letters_disp_id, :addressee_name, :address1, :address2, :city, :state,
						 :pincode, :is_to, :applicant_id, :application_id, :stage_id)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':letters_disp_id', $letters_disp_id, \PDO::PARAM_INT);
				$statement->bindParam(':addressee_name', $name, \PDO::PARAM_STR);
				$statement->bindParam(':address1', $address1, \PDO::PARAM_STR);
				$statement->bindParam(':address2', $address2, \PDO::PARAM_STR);				
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_STR);
				$statement->bindParam(':is_to', $active, \PDO::PARAM_BOOL);
				$statement->bindParam(':applicant_id', $val, \PDO::PARAM_INT);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->execute();				
				
	// here code for CopyTo Addressee
				
				$query = "SELECT * FROM tbl_appli_through WHERE id =:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $copyTo, \PDO::PARAM_INT);
				$stmt->execute();				
				
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$name     = $row['appli_through_name'];
					$address1 = $row['address_line1'];
					$address2 = $row['address_line2'];
					$city     = $row['city'];
					$state    = $row['state'];
					$pincode  = $row['pincode'];
				}			
				
				$active = FALSE;				
				$sqlQuery = "INSERT INTO tbl_letter_disp_addressee(letters_disp_id, addressee_name, address1,
						address2, city, state, pincode, is_to, applicant_id, application_id, stage_id)
						VALUES(:letters_disp_id, :addressee_name, :address1, :address2, :city, :state,
						 :pincode, :is_to, :applicant_id, :application_id, :stage_id)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':letters_disp_id', $letters_disp_id, \PDO::PARAM_INT);
				$statement->bindParam(':addressee_name', $name, \PDO::PARAM_STR);
				$statement->bindParam(':address1', $address1, \PDO::PARAM_STR);
				$statement->bindParam(':address2', $address2, \PDO::PARAM_STR);				
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_STR);
				$statement->bindParam(':is_to', $active, \PDO::PARAM_BOOL);
				$statement->bindParam(':applicant_id', $copyTo, \PDO::PARAM_INT);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->execute();			
			}
			
			$con->commit();
				$flag =1;
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
			return $application_id;
		}
		
		public function addAdvocateApponment($application_id, $app_date, $adv_name, $isSrAdv)
		{
			$flag = 0;
	        $curDate = date("Y-m-d H:i:s");
			$appoinment_date = date("Y-m-d", strtotime($app_date));
			$con = Conn\Connection::getConnection();
			try{
				$query = "INSERT INTO tbl_application_advocate(appointment_date, is_sr_advocate, application_id, advocate_id)
						VALUES(:appointment_date, :is_sr_advocate, :application_id, :advocate_id)";
				$statement = $con->prepare($query);
				$statement->bindParam(':appointment_date', $appoinment_date, \PDO::PARAM_STR);
				$statement->bindParam(':is_sr_advocate', $isSrAdv, \PDO::PARAM_BOOL);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_STR);
				$statement->bindParam(':advocate_id', $adv_name, \PDO::PARAM_STR);
				$statement->execute();
					
				$query = "UPDATE tbl_advocates set last_appt = :last_appt WHERE id = :advocate_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':last_appt', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':advocate_id', $adv_name, \PDO::PARAM_INT);
				$statement->execute();
				
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			
			return $application_id;
		}
		
		
		public function addSrAdvocateApponment($application_id, $app_date, $adv_name, $isSrAdv)
		{
			$flag = 0;
			$curDate = date("Y-m-d H:i:s");
			$appoinment_date = date("Y-m-d", strtotime($app_date));
			$con = Conn\Connection::getConnection();
			try{
				$query = "INSERT INTO tbl_application_advocate(appointment_date, is_sr_advocate, application_id, advocate_id)
						VALUES(:appointment_date, :is_sr_advocate, :application_id, :advocate_id)";
				$statement = $con->prepare($query);
				$statement->bindParam(':appointment_date', $appoinment_date, \PDO::PARAM_STR);
				$statement->bindParam(':is_sr_advocate', $isSrAdv, \PDO::PARAM_BOOL);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_STR);
				$statement->bindParam(':advocate_id', $adv_name, \PDO::PARAM_STR);
				$statement->execute();
					
				$query = "UPDATE tbl_sr_advocate set last_appt = :last_appt WHERE id = :advocate_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':last_appt', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':advocate_id', $adv_name, \PDO::PARAM_INT);
				$statement->execute();
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
				
			return $application_id;
		}
		
		
		public function addTranslatorApponment($application_id, $app_date, $translator_name)
		{
			$flag = 0;
			$curDate = date("Y-m-d H:i:s");
			$appoinment_date = date("Y-m-d", strtotime($app_date));
			$con = Conn\Connection::getConnection();
			try{
				$query = "INSERT INTO tbl_application_translator(application_id, translator_id, appointment_date)
						VALUES(:application_id, :translator_id, :appointment_date)";
				$statement = $con->prepare($query);								
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':translator_id', $translator_name, \PDO::PARAM_INT);
				$statement->bindParam(':appointment_date', $appoinment_date, \PDO::PARAM_STR);
				$statement->execute();
					
				$query = "UPDATE tbl_translator SET last_appt = :last_appt WHERE translator_id =:translator_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':last_appt', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':translator_id', $translator_name, \PDO::PARAM_INT);
				$statement->execute();
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $application_id;
		}
		
		
		public function addOpinionDecision(
			 		$application_id,
			 		$name,
			 		$opinion_letter,			 		
			 		$subject,
			 		$opinion_sought_summary,
			 		$received_date,
			 		$secretary_order,
			 		$is_in_favour,
					$is_lsc,
			 		$opinion_received_summary,
	                $stage_id )
		{
			$flag = 0;
			$curDate = date("Y-m-d H:i:s");
			$received_date = date("Y-m-d", strtotime($received_date));		
			$status=1;
			$con = Conn\Connection::getConnection();
			try{
				$query = "INSERT INTO tbl_opinions_in_requests(application_id, adviser_id, stage_id, opinion_letter_id,
			            is_lsc, opinion_sought_subject, opinion_sought_summary, opinion_received_summary, 
						received_date, secretary_order, is_in_favour)
						VALUES(:application_id, :adviser_id, :stage_id, :opinion_letter_id, :is_lsc, 
						:opinion_sought_subject, :opinion_sought_summary, :opinion_received_summary,
						:received_date, :secretary_order, :is_in_favour)";
				$statement = $con->prepare($query);				
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':adviser_id', $name, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':opinion_letter_id', $opinion_letter, \PDO::PARAM_INT);
				$statement->bindParam(':is_lsc', $is_lsc, \PDO::PARAM_BOOL);
				$statement->bindParam(':opinion_sought_subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':opinion_sought_summary', $opinion_sought_summary, \PDO::PARAM_STR);
				$statement->bindParam(':opinion_received_summary', $adv_name, \PDO::PARAM_STR);
				$statement->bindParam(':received_date', $received_date, \PDO::PARAM_STR);
				$statement->bindParam(':secretary_order', $secretary_order, \PDO::PARAM_STR);
			//	$statement->bindParam(':status', $status, \PDO::PARAM_BOOL);
				$statement->bindParam(':is_in_favour', $is_in_favour, \PDO::PARAM_BOOL);
				$statement->execute();
	
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $application_id;
		}
		
				
	}
?>