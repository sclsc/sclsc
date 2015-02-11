<?php
	namespace classes\Implementation\RecievedThroughType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThroughType/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThroughType as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addThroughType($name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();
		
				$query = "INSERT INTO tbl_appli_through_type(appli_through_type_name)VALUES(:name)";
				$statement = $con->prepare($query);
				$statement->bindParam(':name', $name, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
		
				/*$tbl_id  = $con->lastInsertId('tbl_appli_through_type_id_seq');
				$tbl_name= 'tbl_appli_through_type';
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
				$statement->bindParam(':action', $action, \PDO::PARAM_STR);*/
				
				$con->commit();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	}
?>