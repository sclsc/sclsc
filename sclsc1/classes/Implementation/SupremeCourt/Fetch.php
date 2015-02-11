<?php
	namespace classes\Implementation\SupremeCourt;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SupremeCourt/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SupremeCourt as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function getAllStates()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT id,state_name FROM tbl_states"; 
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
		
		
		public function getstateName($state_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT state_name FROM tbl_states where id = :state_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
	}
?>