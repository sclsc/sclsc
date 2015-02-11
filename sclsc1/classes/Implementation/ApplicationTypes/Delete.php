<?php
	namespace classes\Implementation\ApplicationTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypes/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypes as IDelete;
	 
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
	  
	  
 }
?>