<?php
	namespace classes\Implementation\DocumentTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocumentTypes/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocumentTypes as IEdit;
	 
	class Edit implements IEdit\Editable
	{	
		
		public function updateDocument($doc_id,$doc_name,$is_active =NULL)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_doc_type set doc_name = :doc_name WHERE id = :doc_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':doc_name', $doc_name, \PDO::PARAM_STR);
				$statement->bindParam(':doc_id', $doc_id, \PDO::PARAM_STR);
		
				if($statement->execute())
					$flag = 1;
				$con->commit();
				$con =NULL;
			}
			catch (PDOException $e) {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		public function updateDocumentStatus($doc_id,$is_active)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_doc_type set is_active = :is_active WHERE id = :doc_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->bindParam(':doc_id', $doc_id, \PDO::PARAM_STR);
		
				if($statement->execute())
					$flag = 1;
				$con->commit();
				$con =NULL;
			}
			catch (PDOException $e) {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	  
		
	}
?>