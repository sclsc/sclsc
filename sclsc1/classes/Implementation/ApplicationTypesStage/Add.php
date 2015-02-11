<?php
	namespace classes\Implementation\ApplicationTypesStage;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypesStage/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypesStage as IAdd;
	
	class Add implements IAdd\Addable
	{
			
		public function addApplicationStageType(
					$stage_name,
					$application_type)
		{
			//echo $stage_name.'===='.$application_type; exit;
			
			$flag = 0;			
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
		     $sqlQuery = "INSERT INTO tbl_application_type_stages(stage_id,application_type_id) 
						VALUES(:stage_name,:application_type)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':stage_name', $stage_name, \PDO::PARAM_INT);
				$statement->bindParam(':application_type', $application_type, \PDO::PARAM_INT);
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