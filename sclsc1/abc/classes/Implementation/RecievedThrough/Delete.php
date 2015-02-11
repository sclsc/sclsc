<?php
	namespace classes\Implementation\RecievedThrough;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThrough/Deleteable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThrough as IDelete;
	 
	class Delete implements IDelete\Deleteable
	{
		public function delRecievedThrough($applicationId)
		{
			//	echo $applicationId; exit;
			$con = Conn\Connection::getConnection();
			$flag=0;
			try{
				$query = "DELETE FROM tbl_appli_through WHERE id=:id";
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