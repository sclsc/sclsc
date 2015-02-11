<?php
	namespace classes\Implementation\Dispatcher;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Dispatcher/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Dispatcher as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateDiary($diary_no,$category_id,$letter_no,$date_of_letter,$subject,$subject_desc,$recieved_date,$sender,$sender_address1,$sender_address2,$sender_city,$sender_state,$pincode)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "update tbl_diary set category_id = :category_id, letter_no = :letter_no, date_of_letter = :date_of_letter, subject = :subject, subject_desc = :subject_desc, recieved_date = :recieved_date, sender = :sender, sender_address1 = :sender_address1, sender_address2 = :sender_address2, sender_city = :sender_city, sender_state = :sender_state, pincode = :pincode WHERE diary_no = :diary_no";
				$statement = $con->prepare($query);
				$statement->bindParam(':category_id', $category_id, PDO::PARAM_STR);
				$statement->bindParam(':letter_no', $letter_no, PDO::PARAM_STR);
				$statement->bindParam(':date_of_letter', $date_of_letter, PDO::PARAM_STR);
				$statement->bindParam(':subject', $subject, PDO::PARAM_STR);
				$statement->bindParam(':subject_desc', $subject_desc, PDO::PARAM_STR);
				$statement->bindParam(':recieved_date', $recieved_date, PDO::PARAM_STR);
				$statement->bindParam(':sender', $sender, PDO::PARAM_STR);
				$statement->bindParam(':sender_address1', $sender_address1, PDO::PARAM_STR);
				$statement->bindParam(':sender_address2', $sender_address2, PDO::PARAM_STR);
				$statement->bindParam(':sender_city', $sender_city, PDO::PARAM_STR);
				$statement->bindParam(':sender_state', $sender_state, PDO::PARAM_STR);
				$statement->bindParam(':pincode', $pincode, PDO::PARAM_STR);
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
		
		 public function closeMiscApplication($application_id, $stage_id, $sub_stage_id)
		 {	
		 	
		 	$flag = 0;		 
			$con = Conn\Connection::getConnection();
			
			try{ 
				
				$con->beginTransaction();
				
			    $is_active =FALSE;						
				$query = "UPDATE tbl_application_status SET is_active = :is_active
							 WHERE application_id = :application_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
			
				$curDate = date("Y-m-d");
				$sqlQuery = "INSERT INTO tbl_application_status(application_id, stage_id, sub_stage_id,
						 completion_date, active_date)
								VALUES(:application_id, :stage_id, :sub_stage_id, :completion_date, :active_date)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':sub_stage_id', $sub_stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':completion_date', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':active_date', $curDate, \PDO::PARAM_STR);
				$statement->execute();
				
			    $con->commit();
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
		
		
		
	}
?>