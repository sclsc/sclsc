<?php
	namespace classes\Implementation\DocumentTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocumentTypes/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocumentTypes as IFetch;
	
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
	
		public function getAllDocuments($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_doc_type Order By id ASC"; 
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
		
		
		public function getAllDocumentsCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{
				$query = "SELECT COUNT(*) as count FROM tbl_doc_type";
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
		
		public function checkDocument($docName)
		{
			$flag = 0;
			$count=0;
			$con = Conn\Connection::getConnection();
			try{
		
				$sqlQuery = "select doc_name from tbl_doc_type where doc_name LIKE :doc_name";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':doc_name', $docName, \PDO::PARAM_STR);
		
				if($statement->execute())
					while($statement->fetch())
						$count++;
		
					if($count!=0)
						$flag = 1;
		
					$con =NULL;
			}
			catch (PDOException $e) {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		
		
		public function getAllDocRequest()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT a.request_type_id, a.doc_type_id, b.doc_name, c.appli_type_name 
						FROM tbl_docs_in_request_type a 
						JOIN tbl_doc_type b ON b.id = a.doc_type_id
						Join tbl_application_types c ON c.id = a.request_type_id  ORDER By a.id ASC";
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