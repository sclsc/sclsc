<?php
	namespace classes\Implementation\DocumentTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocumentTypes/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocumentTypes as IDelete;
	 
	class Delete implements IDelete\Deletable
	{  
	  
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