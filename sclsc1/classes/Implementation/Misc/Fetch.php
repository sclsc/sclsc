<?php
	namespace classes\Implementation\Misc;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Misc/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Misc as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function getAllStages()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_stages WHERE parent_id=0"; 
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
		
		
		public function getStageName($stage_id)
		{
			$con = Conn\Connection::getConnection();
			$stage_name ='';
			try{
				$query = "SELECT stage_name FROM tbl_stages WHERE id = :stage_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
				while ($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				       $stage_name = $row['stage_name'];			
					
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stage_name;
		}
		
		
		
		public function getSubStages($stage_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_stages WHERE parent_id = :stage_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getSubStagesid()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_stages WHERE parent_id=0";
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
		
		public function getSubStagesname($stage_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT s.stage_name FROM tbl_letter_types AS l
               LEFT JOIN tbl_stages s ON l.sub_stage_id=s.id where parent_id = :stage_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
				while ($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$stage_name = $row['stage_name'];
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stage_name;
		}
		
		
	}
?>