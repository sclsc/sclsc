<?php
	namespace classes\Implementation\DocInAppliType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocInAppliType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocInAppliType as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		
		public function getAllApplicationType($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_application_types ORDER BY id";
				$statement = $con->prepare($query);
				$statement->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
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
				$statement = $con->prepare($query);
				$statement->bindParam(':application_name', $application_name, \PDO::PARAM_INT);
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
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
				$statement = $con->prepare($query);
				$statement->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
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
		
		
		
		/* public function getAllDocRequest()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT a.request_type_id, a.doc_type_id, b.doc_name, c.appli_type_name 
						FROM tbl_docs_in_request_type a 
						JOIN tbl_doc_type b ON b.id = a.doc_type_id
						Join tbl_application_types c ON c.id = a.request_type_id  ORDER By a.id ASC";
				$statement = $con->prepare($query);
				$statement->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		} */
		
		public function getAllDocRequestIds()
		{			
			$con = Conn\Connection::getConnection();
			$count = 0;
			$ids = array();
			try{
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (a.request_type_id) a.request_type_id, b.appli_type_name
						FROM tbl_docs_in_request_type a						
						JOIN tbl_application_types b ON b.id = a.request_type_id WHERE a.is_active= :is_active
						ORDER By a.request_type_id ASC";			
				$statement = $con->prepare($query);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
			
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$ids[$count]['request_type_id'] = $row['request_type_id'];
			    $ids[$count]['appli_type_name'] = $row['appli_type_name'];
			    $count++;
			}
			}
			
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			$con = NULL;
			return $ids;
		}
		
		public function getAllmatchingData($request_type_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$is_active =TRUE;
				$query = "SELECT a.doc_type_id, b.doc_name, c.appli_type_name 
						FROM tbl_docs_in_request_type a 
						JOIN tbl_doc_type b ON b.id = a.doc_type_id
						JOIN tbl_application_types c ON c.id = a.request_type_id 
						WHERE request_type_id = :requestId AND a.is_active= :is_active 
						ORDER By a.id ASC";
				$statement = $con->prepare($query);
				$statement->bindParam(':requestId', $request_type_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		public function getSingleDocRequest($request_type_id)
		{			
			$docID = array();
			$count = 0;
			$active=TRUE;
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT doc_type_id FROM tbl_docs_in_request_type 
						WHERE request_type_id = :request_type_id AND is_active = :is_active";
				$statement = $con->prepare($query);
				$statement->bindParam(':request_type_id', $request_type_id, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', 	$active, \PDO::PARAM_BOOL);
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$docID[$count] = $row['doc_type_id'];					
					$count++;
				}
				
				$con = NULL;			
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $docID;			
		}
		
		
	}
?>