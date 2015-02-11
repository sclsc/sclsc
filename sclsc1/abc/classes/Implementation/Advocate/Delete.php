<?php
	namespace classes\Implementation\Advocate;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Advocate/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Advocate as IDelete;
	 
	class Delete implements IDelete\Deletable
	{
		
		public function delAvocate($advocateId)
		{   
			$flag=0;
			$con = Conn\Connection::getConnection();
		 try 
		  {			
			$con->beginTransaction();
			
			    $query = "DELETE FROM tbl_advocates WHERE id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $advocateId, \PDO::PARAM_INT);
				$stmt->execute();
				
				$query = "DELETE FROM tbl_advocate_period WHERE advocates_id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $advocateId, \PDO::PARAM_INT);
				$stmt->execute();
				
				$query = "DELETE FROM tbl_adv_address WHERE advocates_id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $advocateId, \PDO::PARAM_INT);
				$stmt->execute();				
			
				$flag=1;
			$con->commit();
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