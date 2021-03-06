<?php
	namespace classes\Implementation\Users;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Users/Deleteable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Users as IDelete;
	 
	class Delete implements IDelete\Deleteable
	{
		public function delUser($UserId)
		{
			//	echo $applicationId; exit;
			$con = Conn\Connection::getConnection();
			$flag=0;
			try{
				$query = "DELETE FROM tbl_user WHERE id=:UserId";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':UserId', $UserId, \PDO::PARAM_INT);
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