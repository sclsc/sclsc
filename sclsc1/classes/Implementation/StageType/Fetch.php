<?php
	namespace classes\Implementation\StageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/StageType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\StageType as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		public function getStageTypes($Stage_id)
		{
			$con = Conn\Connection::getConnection();
			try{
			 	$query = "SELECT * FROM tbl_stages WHERE id= :Stage_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':Stage_id', $Stage_id, \PDO::PARAM_STR);
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