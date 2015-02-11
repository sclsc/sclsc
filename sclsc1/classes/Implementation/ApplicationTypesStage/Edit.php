<?php
	namespace classes\Implementation\ApplicationTypesStage;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypesStage/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypesStage as IEdit;
	 
	class Edit implements IEdit\Editable
	{	
		
		
		public function updateApplicationStage($applicationstage_id,$application_type,$stage_name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				//echo $applicationstage_id.'<br>';
				//echo $application_type.'<br>';
				//echo $stage_name; exit;
				$query = "update tbl_application_type_stages set application_type_id = :application_type, stage_id = :stage_name 
						WHERE id = :applicationstage_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_type', $application_type, \PDO::PARAM_INT);
				$statement->bindParam(':stage_name', $stage_name, \PDO::PARAM_INT);
				$statement->bindParam(':applicationstage_id', $applicationstage_id, \PDO::PARAM_INT);
						
				$statement->execute();
				$flag = 1;
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