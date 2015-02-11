<?php
	namespace classes\Implementation\SubStageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SubStageType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SubStageType as IEdit;
	 
	class Edit implements IEdit\Editable
	{	
		
		
		public function updateSubStage($SubStage_id,$stage_name,$substage_name,$stage_page)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
				$query = "update tbl_stages set stage_name = :substage_name,stage_page = :stage_page,parent_id = :stage_name WHERE id = :SubStage_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':SubStage_id', $SubStage_id, \PDO::PARAM_INT);
				$statement->bindParam(':substage_name', $substage_name, \PDO::PARAM_STR);
				$statement->bindParam(':stage_page', $stage_page, \PDO::PARAM_STR);
				$statement->bindParam(':stage_name', $stage_name, \PDO::PARAM_INT);
				
		
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