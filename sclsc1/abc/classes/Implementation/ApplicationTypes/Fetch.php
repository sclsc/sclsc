<?php
	namespace classes\Implementation\ApplicationTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypes/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypes as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		
		public function getAllApplicationType($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_application_types ORDER BY id";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getAllApplicationCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{
				$query = "SELECT COUNT(*) as count FROM tbl_application_types";
				$statement = $con->prepare($query);
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['count'];
		
				$con =NULL;
		
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function checkApplicationType($application_name)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT appli_type_name FROM tbl_application_types WHERE appli_type_name = :application_name";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':application_name', $application_name, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$flag = 1;
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		public function getApplicationType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_application_types ORDER BY id";
				$stmt = $con->prepare($query);
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