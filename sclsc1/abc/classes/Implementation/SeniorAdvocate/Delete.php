<?php
	namespace classes\Implementation\SeniorAdvocate;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SeniorAdvocate/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SeniorAdvocate as IDelete;
	 
	class Delete implements IDelete\Deletable
	{
		
		public function delSrAvocate($srAdvocateId)
		{   
			$flag=0;
			$con = Conn\Connection::getConnection();
		 try 
		  {			
			$con->beginTransaction();
			
			    $query = "DELETE FROM tbl_sr_advocate WHERE id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $srAdvocateId, \PDO::PARAM_INT);
				$stmt->execute();
				
				$query = "DELETE FROM tbl_sr_advocate_period WHERE sr_advocates_id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $srAdvocateId, \PDO::PARAM_INT);
				$stmt->execute();
				
				$query = "DELETE FROM tbl_sr_adv_address WHERE sr_advocates_id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $srAdvocateId, \PDO::PARAM_INT);
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