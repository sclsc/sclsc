<?php
	namespace classes\implementation\Dispatcher;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Dispatcher/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Dispatcher as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addDispatcher(
				    $application_id,
				    $applicant_id,
				    $stage_id,
			 		$name,
			 		$place,			 		
			 		$subject,
			 		$file_head,
			 		$stamp_received,
			 		$stamp_affixed,
			 		$stamp_balance,
			 		$remarks,
			 		$address1,
			 		$address2,
			 		$city,
			 		$state,
			 		$pincode
			 )
		 {
			
			$msg = array();
			$flag = 0;
			$con = Conn\Connection::getConnection();
			
			try{
				$con->beginTransaction();
				$sqlQuery = "INSERT INTO tbl_dispatch(name,place,subject,file_head,stamp_received,stamp_affixed,
						stamp_balance,remarks,address1,address2,city,state,pincode,application_id,applicant_id,stage_id)
						VALUES(:name,:place,:subject,:file_head,:stamp_received,:stamp_affixed,:stamp_balance,
						:remarks,:address1,:address2,:city,:state,:pincode,:application_id, :applicant_id, :stage_id)";
				$statement = $con->prepare($sqlQuery);				
				$statement->bindParam(':name', $name, \PDO::PARAM_STR);
				$statement->bindParam(':place', $place, \PDO::PARAM_STR);
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				$statement->bindParam(':file_head', $file_head, \PDO::PARAM_STR);
				$statement->bindParam(':stamp_received', $stamp_received, \PDO::PARAM_STR);
				$statement->bindParam(':stamp_affixed', $stamp_affixed, \PDO::PARAM_INT);
				$statement->bindParam(':stamp_balance', $stamp_balance, \PDO::PARAM_STR);
				$statement->bindParam(':remarks', $remarks, \PDO::PARAM_STR);
				$statement->bindParam(':address1', $address1, \PDO::PARAM_STR);
				$statement->bindParam(':address2', $address2, \PDO::PARAM_STR);
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_STR);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_INT);		
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->execute();
				
			if (isset($application_id) && $application_id!=0)
			{	
				$is_active =FALSE;
				$is_dispatch=TRUE;				
				$query = "UPDATE tbl_letters_disp_in_appli SET is_active = :is_active
					 WHERE application_id = :application_id AND applicant_id =:applicant_id AND stage_id =:stage_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
				
				$query = "UPDATE tbl_letter_disp_addressee SET is_dispatch = :is_dispatch
					 WHERE application_id = :application_id AND applicant_id =:applicant_id AND stage_id =:stage_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_dispatch', $is_dispatch, \PDO::PARAM_BOOL);
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
			return $flag;
		}

		
	}
?>