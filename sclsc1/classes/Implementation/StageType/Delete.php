<?php
	namespace classes\Implementation\StageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/StageType/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\StageType as IDelete;
	 
	class Delete implements IDelete\Deletable
	{  
	  
	  public function deleteStage($Stage_id)
	  {
	  	$flag = 0;
	  	$con = Conn\Connection::getConnection();
	  	try{
	  		$con->beginTransaction();
	  		$query = "delete from tbl_stages WHERE id = :Stage_id";
	  		$statement = $con->prepare($query);
	  		$statement->bindParam(':Stage_id', $Stage_id, \PDO::PARAM_INT);
	  
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