<?php
	namespace classes\Implementation\RecievedThroughType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThroughType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThroughType as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateRecievedThroughType($id,$appli_through_type_name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();
		
				$query = "update tbl_appli_through_type set appli_through_type_name = :appli_through_type_name where id = :id";
				$statement = $con->prepare($query);
				$statement->bindParam(':appli_through_type_name', $appli_through_type_name, \PDO::PARAM_STR);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
				if($statement->execute())
					$flag = 1;
						
				/* 	$tbl_id  = $id;
				$tbl_name= 'tbl_appli_through_type';
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