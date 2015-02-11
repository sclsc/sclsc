<?php
	namespace classes\Implementation\SupremeCourt;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SupremeCourt/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SupremeCourt as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addState($state_name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$sqlQuery = "insert into tbl_states(state_name) values(:state_name)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':state_name', $state_name, \PDO::PARAM_STR);
				if($stmt->execute())
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