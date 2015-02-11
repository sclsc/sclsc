<?php
	namespace classes\Implementation\StageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/StageType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\StageType as IEdit;
	 
	class Edit implements IEdit\Editable
	{	
		
		
		public function updateStage($Stage_id,$stage_name,$stage_page)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
				$query = "update tbl_stages set stage_name = :stage_name,stage_page = :stage_page WHERE id = :Stage_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':Stage_id', $Stage_id, \PDO::PARAM_INT);
				$statement->bindParam(':stage_name', $stage_name, \PDO::PARAM_STR);
				$statement->bindParam(':stage_page', $stage_page, \PDO::PARAM_STR);
				
		
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