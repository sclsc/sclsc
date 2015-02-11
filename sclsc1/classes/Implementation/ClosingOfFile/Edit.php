<?php
	namespace classes\Implementation\ClosingOfFile;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ClosingOfFile/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ClosingOfFile as IEdit;
	 
	class Edit implements IEdit\Editable
	{
	   public function reGenerateLetter(
			 		$application_id,
			        $letterId,
			 		$letterType,			 				 		
			 		$subject,
			 		$to,
			 		$copyTo )
		{
			
			
			$msg = array();
			$flag =0;
			$con = Conn\Connection::getConnection();
			
			$length = 6;
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
			
			try {				
				$con->beginTransaction();
				
				$query = "DELETE FROM tbl_letters_disp_in_appli 
						WHERE application_id = :application_id AND id=:id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':id', $letterId, \PDO::PARAM_INT);
				$statement->execute();
				
				$sqlQuery = "INSERT INTO tbl_letters_disp_in_appli(application_id, letter_no, subject, letter_type)
						VALUES(:application_id, :letter_no, :subject, :letter_type)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':letter_no', $letter_no, \PDO::PARAM_INT);
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':letter_type', $letterType, \PDO::PARAM_STR);							
				$statement->execute();
				
			$letters_disp_id = $con->lastInsertId('tbl_letters_disp_in_appli_id_seq'); 

			$query = "DELETE FROM tbl_letter_disp_addressee WHERE letters_disp_id = :letters_disp_id ";
			$statement = $con->prepare($query);
			$statement->bindParam(':letters_disp_id', $letterId, \PDO::PARAM_INT);
			$statement->execute();
		
		  foreach ($to as $val)
			{				
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
						address2, city, state, pincode, is_to, applicant_id)
						VALUES(:letters_disp_id, :addressee_name, :address1, :address2, :city, :state,
						 :pincode, :is_to, :applicant_id)";
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
				$statement->execute();
				
			}
			
			foreach ($copyTo as $val)
			{				
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
				
				
				$active = FALSE;				
				$sqlQuery = "INSERT INTO tbl_letter_disp_addressee(letters_disp_id, addressee_name, address1,
						address2, city, state, pincode, is_to, applicant_id)
						VALUES(:letters_disp_id, :addressee_name, :address1, :address2, :city, :state,
						 :pincode, :is_to, :applicant_id)";
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
		
		
	  public function upApplicationStatus($application_id, $stage_id, $sub_stage_id)
		{
			//echo $application_id.'========'.$stage_id.'====='.$sub_stage_id; exit;
			$msg = array();
			$flag =0;
			$con = Conn\Connection::getConnection();
				
			try {
				$con->beginTransaction();
				
				$is_active =FALSE;
				$query = "UPDATE tbl_application_status SET is_active = :is_active
					 WHERE application_id = :application_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
		
				$curDate = date("Y-m-d");
				$sqlQuery = "INSERT INTO tbl_application_status(application_id, stage_id, sub_stage_id, completion_date)
						VALUES(:application_id, :stage_id, :sub_stage_id, :completion_date)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':sub_stage_id', $sub_stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':completion_date', $curDate, \PDO::PARAM_STR);
				$statement->execute();
		
				$con->commit();
				$flag =1;
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
			return $flag;
		}
		
		
	}
?>