<?php
	namespace classes\Implementation\DocInAppliType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocInAppliType/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocInAppliType as IDelete;
	 
	class Delete implements IDelete\Deletable
	{
		
		public function delApplication($applicationId)
	    {		
		$con = Conn\Connection::getConnection();
		$flag=0;
		try{
			$query = "DELETE FROM tbl_application_types WHERE id=:id";
			$stmt = $con->prepare($query);
			$stmt->bindValue(':id', $applicationId, \PDO::PARAM_INT);
			if($stmt->execute())
			{
				$flag = 1;
			}
			$con =NULL;
		}
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $flag;
	  }
	  
	  
	  public function deleteDocument($doc_id)
	  {
	  	$flag = 0;
	  	$con = Conn\Connection::getConnection();
	  	try{
	  		$con->beginTransaction();
	  		$query = "delete from tbl_doc_type WHERE id = :doc_id";
	  		$statement = $con->prepare($query);
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