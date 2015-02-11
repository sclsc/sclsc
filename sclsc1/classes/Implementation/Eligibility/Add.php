<?php
	namespace classes\Implementation\Eligibility;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Eligibility/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Eligibility as IAdd;
	
	class Add implements IAdd\Addable
	{
		function addElegibilityCondition($condition_name) {
			$flag = 0;
			$msg = array();
			$diary_no = '';
			$con = Conn\Connection::getConnection();
		
			try{
		
				$con->beginTransaction();
		
				$sqlQuery = "insert into tbl_eligibility_conditions(eligibility_condition)
						values(:condition_name)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':condition_name', $condition_name, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
					
				/* $tbl_id  = $con->lastInsertId('tbl_eligibility_conditions_id_seq');
				$tbl_name= 'tbl_eligibility_conditions';
				$curDate = date("Y-m-d");
				$usrId   = $_SESSION['id'];
				$action  = 'Add';
				$sqlQuery = "insert into tbl_user_log(tbl_name,tbl_id,user_id,post_date,action)
						values(:tbl_name,:tbl_id,:user_id,:post_date,:action)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':tbl_name', $tbl_name, \PDO::PARAM_STR);
				$statement->bindParam(':tbl_id', $tbl_id, \PDO::PARAM_INT);
				$statement->bindParam(':user_id', $usrId, \PDO::PARAM_INT);
				$statement->bindParam(':post_date', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':action', $action, \PDO::PARAM_STR); */
				
		
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