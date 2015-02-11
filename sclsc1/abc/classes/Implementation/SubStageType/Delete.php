<?php
	namespace classes\Implementation\SubStageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SubStageType/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SubStageType as IDelete;
	 
	class Delete implements IDelete\Deletable
	{  
	  
	  public function deleteSubStage($SubStage_id)
	  {
	  	$flag = 0;
	  	$con = Conn\Connection::getConnection();
	  	try{
	  		$con->beginTransaction();
	  		$query = "delete from tbl_stages WHERE id = :SubStage_id";
	  		$statement = $con->prepare($query);
	  		$statement->bindParam(':SubStage_id', $SubStage_id, \PDO::PARAM_INT);
	  
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