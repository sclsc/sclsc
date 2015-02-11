<?php
	namespace classes\Implementation\State;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Diary/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\State as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateState($state_name, $state_id)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_states set state_name = :state_name WHERE state_id = :state_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':state_name', $state_name, PDO::PARAM_STR);
				$statement->bindParam(':state_id', $state_id, PDO::PARAM_STR);
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