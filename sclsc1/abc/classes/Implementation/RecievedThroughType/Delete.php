<?php
	namespace classes\Implementation\RecievedThroughType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThroughType/Deleteable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThroughType as IDelete;
	 
	class Delete implements IDelete\Deleteable
	{
		public function delRecievedThroughType($applicationId)
		{
			//	echo $applicationId; exit;
			$con = Conn\Connection::getConnection();
			$flag=0;
			try{
				$query = "DELETE FROM tbl_appli_through_type WHERE id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $applicationId, \PDO::PARAM_INT);
				if($stmt->execute())
				{
					$flag = 1;
				}
				$query1 = "DELETE FROM tbl_appli_through WHERE id=:id";
				$stmt1 = $con->prepare($query1);
				$stmt1->bindValue(':id', $applicationId, \PDO::PARAM_INT);
				if($stmt1->execute())
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