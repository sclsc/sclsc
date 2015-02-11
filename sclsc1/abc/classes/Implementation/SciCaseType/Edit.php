<?php
	namespace classes\Implementation\SciCaseType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SciCaseType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SciCaseType as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateScCaseType($case_type_id,$case_type_name)
		{
				
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();
		
				$query = "update tbl_sc_case_type set case_type_name = :case_type_name WHERE id = :case_type_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':case_type_name', $case_type_name, \PDO::PARAM_STR);
				$statement->bindParam(':case_type_id', $case_type_id, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
					
				/* $tbl_id  = $case_type_id;
				$tbl_name= 'tbl_sc_case_type';
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
				$statement->bindParam(':action', $action, \PDO::PARAM_STR); */
				
				$con->commit();
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