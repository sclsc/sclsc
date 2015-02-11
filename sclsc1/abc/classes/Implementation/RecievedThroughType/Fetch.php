<?php
	namespace classes\Implementation\RecievedThroughType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThroughType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThroughType as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		
		public function getThroughType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through_type";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function checkThroughType($through_type)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT appli_through_type_name FROM tbl_appli_through_type WHERE appli_through_type_name = :through_type";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':through_type', $through_type, \PDO::PARAM_INT);
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
		
		public function getReceivedThroughType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through_type";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getReceivedThrough($id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through where appli_through_type_id = :id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getThroughTypeName($id)
		{
			$con = Conn\Connection::getConnection();
			$name = '';
			try{
				$query = "SELECT appli_through_type_name FROM tbl_appli_through_type where id = :id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$name = $row['appli_through_type_name'];
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $name;
		}
		
	}
?>