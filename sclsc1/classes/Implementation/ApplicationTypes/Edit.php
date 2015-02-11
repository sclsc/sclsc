<?php
	namespace classes\Implementation\ApplicationTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypes/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypes as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		
		public function updateApplication($application_id,$application_name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				
				$con->beginTransaction();
				
				$query = "update tbl_application_types set appli_type_name = :application_name WHERE id = :appliaction_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_name', $application_name, \PDO::PARAM_STR);
				$statement->bindParam(':appliaction_id', $application_id, \PDO::PARAM_STR);
				$statement->execute();

			/*		$tbl_id  = $application_id;
					$tbl_name= 'tbl_application_types';
					$curDate = date("Y-m-d");
					$usrId   = $_SESSION['id'];
					$action  = 'Update';
					$sqlQuery = "insert into tbl_user_log(tbl_name,tbl_id,user_id,post_date,action)
						values(:tbl_name,:tbl_id,:user_id,:post_date,:action)";
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':tbl_name', $tbl_name, \PDO::PARAM_INT);
					$statement->bindParam(':tbl_id', $tbl_id, \PDO::PARAM_INT);
					$statement->bindParam(':user_id', $usrId, \PDO::PARAM_INT);
					$statement->bindParam(':post_date', $curDate, \PDO::PARAM_STR);
					$statement->bindParam(':action', $action, \PDO::PARAM_STR);
					if($statement->execute())
					*/
					
						$flag = 1;
						
					$con->commit();
					$con =NULL;ULL;
			}
			catch (PDOException $e) {
				$pdo->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		

		
		public function updateAppliStatus($doc_id,$is_active)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_application_types set is_active = :is_active WHERE id = :doc_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->bindParam(':doc_id', $doc_id, \PDO::PARAM_STR);
		
				if($statement->execute())
					$flag = 1;
				$con->commit();
				$con =NULL;
			}
			catch (PDOException $e) {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	  
		
	}
?>