<?php
	namespace classes\Implementation\Diary;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Diary/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Diary as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateDiary($id,$category,$letterNo,$letterDate,$received_through,$sender,$mailId,$contactNumber,
									  $fatherName,$address1,$address2,$city,$state,$pincode,$subject,$description,$markTo)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "update tbl_diary set category_id = :category, letter_no = :letterno, 
						date_of_letter = :letterDate,recieved_through 	 = :received_through,applicant = :sender,mail_id =:mailId ,contact_number = :contactNumber,father_name = :fatherName, sender_address1 = :address1, 
						sender_address2 = :address2, sender_city = :city, 
						sender_state = :state, pincode = :pincode,subject = :subject, subject_desc = :description,
						mark_to = :markTo WHERE id = :id";
				$statement = $con->prepare($query);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
				$statement->bindParam(':category', $category, \PDO::PARAM_STR);
				$statement->bindParam(':letterno', $letterno, \PDO::PARAM_STR);
				$statement->bindParam(':letterDate', $letterDate, \PDO::PARAM_STR);
				$statement->bindParam(':received_through', $received_through, \PDO::PARAM_INT);
				$statement->bindParam(':sender', $sender, \PDO::PARAM_STR);
				$statement->bindParam(':mailId', $mailId, \PDO::PARAM_STR);
				$statement->bindParam(':contactNumber', $contactNumber, \PDO::PARAM_INT);
				$statement->bindParam(':fatherName', $fatherName, \PDO::PARAM_STR);
				$statement->bindParam(':address1', $address1, \PDO::PARAM_STR);
				$statement->bindParam(':address2', $address2, \PDO::PARAM_STR);
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_STR);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_STR);
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':description', $description, \PDO::PARAM_STR);
				$statement->bindParam(':markTo', $markTo, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
				$con =NULL;
			}
			catch (PDOException $e) {
				$pdo->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		public function updateDiaryStatus($id)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$is_taken =TRUE;
				$query = "UPDATE tbl_diary SET is_taken = :is_taken WHERE id = :id";
				$statement = $con->prepare($query);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
				$statement->bindParam(':is_taken', $is_taken, \PDO::PARAM_BOOL);
				if($statement->execute())
					$flag = 1;
				$con =NULL;
			}
			catch (PDOException $e) {
				$pdo->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		public function upApplicantionDoc(
					$diary_number, 
					$application_id, 
					$applicant_name, 
					$doc_name, 
					$hiddenDoc, 
					$receiving_date )
		{
			$con = Conn\Connection::getConnection();
			$flag =0;
			try{
				$con->beginTransaction();
				echo $receiving_date;
			//	print_r($applicant_name); 
			//	print_r($doc_name);		exit;
			
				$newDoc = array_diff($doc_name,$hiddenDoc);
				$oldDoc = array_diff($hiddenDoc,$doc_name);
				
			//	print_r($newDoc); 
			//	print_r($oldDoc); exit;
				
				if(count($oldDoc) > 0)
				{
					foreach ($oldDoc as $val)
					{
						$is_active =TRUE;
						$sqlQuery = "SELECT id FROM tbl_application_doc
							    WHERE application_id= :application_id AND applicant_id =:applicant_id
								AND doc_type_id = :doc_type_id AND is_active = :is_active";
						$statement = $con->prepare($sqlQuery);						
						$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
						$statement->bindParam(':applicant_id', $applicant_name, \PDO::PARAM_INT);
						$statement->bindParam(':doc_type_id', $val, \PDO::PARAM_INT);						
						$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
						$statement->execute();
						while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
							$AppliDocID = $row['id'];
						
					
						$curStatus = FALSE;
						$query = "UPDATE tbl_application_doc SET is_active = :is_active WHERE id = :id";
						$statement = $con->prepare($query);
						$statement->bindParam(':is_active', $curStatus, \PDO::PARAM_BOOL);
						$statement->bindParam(':id', $AppliDocID, \PDO::PARAM_INT);
						$statement->execute();
					}
				}
				
				if(count($newDoc) > 0)
				{
					foreach ($newDoc as $val)
					{
						$sqlQuery = "INSERT INTO tbl_application_doc(diary_no, application_id,
								applicant_id, doc_type_id, receiving_date)
					    values(:diary_no, :application_id, :applicant_id, :doc_type_id, :receiving_date)";
						$statement = $con->prepare($sqlQuery);
						$statement->bindParam(':diary_no', $diary_number, \PDO::PARAM_STR);
						$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
					    $statement->bindParam(':applicant_id', $applicant_name, \PDO::PARAM_INT);
					    $statement->bindParam(':doc_type_id', $val, \PDO::PARAM_INT);
						$statement->bindParam(':receiving_date', $receiving_date, \PDO::PARAM_STR);
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
			return $flag;
		}
		
		
		
	}
?>