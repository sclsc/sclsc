<?php
	namespace classes\Implementation\ApplicationTypesStage;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypesStage/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypesStage as IDelete;
	 
	class Delete implements IDelete\Deletable
	{  
	  
	  public function deleteApplicationStage($applicationstage_id)
	  {
	  	$flag = 0;
	  	$con = Conn\Connection::getConnection();
	  	try{
	  		$con->beginTransaction();
	  		$query = "delete from tbl_application_type_stages  WHERE id = :applicationstage_id";
	  		$statement = $con->prepare($query);
	  		$statement->bindParam(':applicationstage_id', $applicationstage_id, \PDO::PARAM_INT);
	  
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