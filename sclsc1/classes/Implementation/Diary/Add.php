<?php
	namespace classes\implementation\Diary;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Diary/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Diary as IAdd;
	
	class Add implements IAdd\Addable
	{
		
	   public function registerDiaryByDeelingAssistant(
		$diary_number,
		$recieved_date,
		$recieved_through,
		$application_type
		)
		{
			$con = Conn\Connection::getConnection();
				
			try{
				$con->beginTransaction();
				$sqlQuery = "insert into tbl_application(diary_no,appli_type_id,uid_application_through,received_date)
						values(:diary_no,:appli_type_id,:application_through,:received_date)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':diary_no', $diary_number, \PDO::PARAM_STR);
				$statement->bindParam(':received_date', $recieved_date, \PDO::PARAM_STR);
				$statement->bindParam(':appli_type_id', $application_type, \PDO::PARAM_INT);
				$statement->bindParam(':application_through', $recieved_through, \PDO::PARAM_INT);
				$statement->execute();
		
				$application_id = $con->lastInsertId('tbl_application_id_seq');
				
				$stage_id = 1;
				$sub_stage_id = 0;
				$curDate = date("Y-m-d");
				$is_active =FALSE;
				$sqlQuery = "INSERT INTO tbl_application_status(application_id, stage_id, sub_stage_id,
						active_date, completion_date, is_active)
						VALUES(:application_id, :stage_id, :sub_stage_id, :active_date, :completion_date, :is_active)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':sub_stage_id', $sub_stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':active_date', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':completion_date', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
				
				$stage_id = 2;
				$sub_stage_id = 0;
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
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
			return $application_id;
		}
		
		public function registerDiary(
				$category_id,
				$diary_num,
				$recievedDate,
				$letterNumber,
				$letterDate,
				$recieved_through,
				$sender,
				$mailId,
				$contactNumber,
				$fatherName,
				$sender_address1,
				$sender_address2,
				$sender_city,
				$stateId,
				$pincode,
				$subject,
				$subjectDesc,
				$mark_to
				)
		{
			$msg = array();
			$diary_no = '';
			$con = Conn\Connection::getConnection();
			
			try{
				$con->beginTransaction();
				$sqlQuery = "insert into tbl_diary(diary_no,category_id,letter_no,date_of_letter,
						mail_id,contact_number,subject,subject_desc,recieved_date,applicant,
						sender_address1,sender_address2,sender_city,sender_state,pincode,
						recieved_through,mark_to,father_name)
						values(:diary_no,:category_id,:letter_no,:date_of_letter,:mail_id,
						:contact_number,:subject,:subject_desc,:recievedDate,:sender,:sender_address1,
						:sender_address2,:sender_city,:sender_state,:pincode,:recieved_through,
						:mark_to,:father_name)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':diary_no', $diary_num, \PDO::PARAM_STR);
				$statement->bindParam(':category_id', $category_id, \PDO::PARAM_INT);
				$statement->bindParam(':letter_no', $letterNumber, \PDO::PARAM_STR);
				$statement->bindParam(':date_of_letter', $letterDate, \PDO::PARAM_STR);
				$statement->bindParam(':mail_id', $mailId, \PDO::PARAM_STR);
				$statement->bindParam(':contact_number', $contactNumber, \PDO::PARAM_INT);
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':subject_desc', $subjectDesc, \PDO::PARAM_STR);
				$statement->bindParam(':recievedDate', $recievedDate, \PDO::PARAM_STR);
				$statement->bindParam(':sender', $sender, \PDO::PARAM_STR);
				$statement->bindParam(':sender_address1', $sender_address1, \PDO::PARAM_STR);
				$statement->bindParam(':sender_address2', $sender_address2, \PDO::PARAM_STR);
				$statement->bindParam(':sender_city', $sender_city, \PDO::PARAM_STR);
				$statement->bindParam(':sender_state', $stateId, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
				$statement->bindParam(':recieved_through', $recieved_through, \PDO::PARAM_INT);
				$statement->bindParam(':mark_to', $mark_to, \PDO::PARAM_INT);
				$statement->bindParam(':father_name', $fatherName, \PDO::PARAM_STR);
				$statement->execute();
				
				$diary_no = $con->lastInsertId('tbl_diary_id_seq');
				
				$con->commit();
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
			return $diary_no;
		}
		public function addApplicant(
				$id,
				$applicant_name,
				$applicant_father_name,
				$dob,
				$age,
				$address1,
				$address2,
				$applicant_city,
				$applicant_state,
				$applicant_pincode,
				$mobile_number,
				$contact_number,
				$mail_id,
				$eligibility_condition,
				$custody_convict_no,
				$custody_jail_id,
				$received_through_type,
				$received_through,
				$applicant_convict_no
		)
			
		{
			if($dob!='')
			{
				$dob=date("m-d-Y", strtotime($dob));
			}
			else
			{
				$dob=NULL;
			}
		
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();					
		
				$sqlQuery = "insert into tbl_applicants(application_id,applicant_name,
						applicant_contact_no,applicant_mobile_no,applicant_email_id,
						applicant_father_name,applicant_d_o_b,applicant_age)
						values(:application_id,:applicant_name,:applicant_contact_no,
						:applicant_mobile_no,:applicant_email_id,:applicant_father_name,
						:applicant_d_o_b,:applicant_age)";
		
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $id, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_name', $applicant_name, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_contact_no', $contact_number, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_mobile_no', $mobile_number, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_email_id', $mail_id, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_father_name', $applicant_father_name, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_d_o_b', $dob, \PDO::PARAM_STR);
				$statement->bindParam(':applicant_age', $age, \PDO::PARAM_STR);
				$statement->execute();
					
				$applicant_id = $con->lastInsertId('tbl_applicants_id_seq');
					
					
				if(($address1 != '' || $address2 != '' || $applicant_city != '' || $applicant_state != '' || $applicant_pincode != ''))
				{
					$sqlQuery = "insert into tbl_applicant_address(applicant_id,applicant_address_line1,
							applicant_address_line2,applicant_city,applicant_state,applicant_pincode)
				 values(:applicant_id,:applicant_address_line1,:applicant_address_line2,:applicant_city,
							:applicant_state,:applicant_pincode)";
						
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
					$statement->bindParam(':applicant_address_line1', $address1, \PDO::PARAM_STR);
					$statement->bindParam(':applicant_address_line2', $address2, \PDO::PARAM_STR);
					$statement->bindParam(':applicant_city', $applicant_city, \PDO::PARAM_STR);
					$statement->bindParam(':applicant_state', $applicant_state, \PDO::PARAM_INT);
					$statement->bindParam(':applicant_pincode', $applicant_pincode, \PDO::PARAM_INT);
					$statement->execute();
				}
		
		
				foreach($eligibility_condition as $val)
				{
					$custody_id =14;
					$through_id =38;
					$sqlQuery = "insert into tbl_applicant_eligibility(applicant_id,eligibility_id)
						values(:application_id,:eligibility_id)";
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':application_id', $applicant_id, \PDO::PARAM_INT);
					$statement->bindParam(':eligibility_id', $val, \PDO::PARAM_INT);
					$statement->execute();	
				}
				
				if(in_array($custody_id,$eligibility_condition) && $through_id!=$received_through_type)
				{
					$sqlQuery = "insert into tbl_applicant_jail(applicant_id,convict_no,jail_id)
					 values(:applicant_id,:convict_no,:jail_id)";
				
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
					$statement->bindParam(':convict_no', $custody_convict_no, \PDO::PARAM_STR);
					$statement->bindParam(':jail_id', $custody_jail_id, \PDO::PARAM_STR);
					$statement->execute();
				}
				
				if($through_id==$received_through_type)
				{
					$sqlQuery = "insert into tbl_applicant_jail(applicant_id,convict_no,jail_id)
					 values(:applicant_id,:convict_no,:jail_id)";
				
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
					$statement->bindParam(':convict_no', $applicant_convict_no, \PDO::PARAM_STR);
					$statement->bindParam(':jail_id', $received_through, \PDO::PARAM_STR);
					$statement->execute();
				}
					
				$con->commit();
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
		}
		
		public function addApplicantionDoc($diary_number, $application_id, $applicant_name, $doc_name, $receiving_date)
		{
			$con = Conn\Connection::getConnection();
			$flag =0;
			try{
				$con->beginTransaction();
				
				//print_r($applicant_name); 
			//	print_r($doc_name);		exit;
				
				for($i=0; $i<=count($applicant_name); $i++){
					//print_r($doc_name[$i]) ;
					
					foreach($doc_name[$i] as $value){
						//echo $value . "<br/>";
						//echo $applicat_name[]; 	exit;
						$sqlQuery = "INSERT INTO tbl_application_doc(diary_no, application_id,
								applicant_id, doc_type_id, receiving_date)
					    values(:diary_no, :application_id, :applicant_id, :doc_type_id, :receiving_date)";
						$statement = $con->prepare($sqlQuery);
						$statement->bindParam(':diary_no', $diary_number, \PDO::PARAM_STR);
						$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
					    $statement->bindParam(':applicant_id', $applicant_name[$i], \PDO::PARAM_INT);
					    $statement->bindParam(':doc_type_id', $value, \PDO::PARAM_INT);
						$statement->bindParam(':receiving_date', $receiving_date, \PDO::PARAM_INT);
						$statement->execute();
					}
				}
	
				$flag =1;
				$con->commit();
				$con =NULL;
			}
			catch(PDOException $e){
				$con->rollBack();
				$msg['error'] = $e->getMessage();
				die();
			}
			return $application_id;
		}
		
	}
?>