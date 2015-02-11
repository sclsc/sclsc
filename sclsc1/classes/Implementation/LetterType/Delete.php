<?php
	namespace classes\Implementation\LetterType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/LetterType/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\LetterType as IDelete;
	 
	class Delete implements IDelete\Deletable
	{  
	  
	  public function deleteLetter($Letter_id)
	  {
	  	$flag = 0;
	  	$con = Conn\Connection::getConnection();
	  	try{
	  		$con->beginTransaction();
	  		$query = "delete from tbl_letter_types WHERE id = :Letter_id";
	  		$statement = $con->prepare($query);
	  		$statement->bindParam(':Letter_id', $Letter_id, \PDO::PARAM_INT);
	  
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