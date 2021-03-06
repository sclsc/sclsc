<?php
	namespace classes\Implementation\LetterType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/LetterType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\LetterType as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		
		public function getAllLetterTypes()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_letter_types ORDER BY id";
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
		
		public function getAllLetterSubject($letterId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT file_path FROM tbl_letter_types WHERE id= :letterId";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':letterId', $letterId, \PDO::PARAM_INT);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getLetterTypesByName($name)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_letter_types where type_name LIKE :name";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':name', $name, \PDO::PARAM_STR);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getLetterTypes($Letter_id)
		{
			$con = Conn\Connection::getConnection();
			try{
			 	$query = "SELECT * FROM tbl_letter_types WHERE id= :Letter_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':Letter_id', $Letter_id, \PDO::PARAM_STR);
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