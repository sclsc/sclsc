<?php
	namespace classes\Implementation\SubStageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SubStageType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SubStageType as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		public function getSubStageTypes($SubStage_id)
		{
			$con = Conn\Connection::getConnection();
			try{
			 	$query = "SELECT * FROM tbl_stages WHERE id= :SubStage_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':SubStage_id', $SubStage_id, \PDO::PARAM_INT);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		
	}
?>