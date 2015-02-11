<?php
	namespace classes\Implementation\HighCourt;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/HighCourt/Deleteable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\HighCourt as IDelete;
	 
	class Delete implements IDelete\Deleteable
	{
		public function delHighCourt($HighCourtId)
		{
			//	echo $applicationId; exit;
			$con = Conn\Connection::getConnection();
			$flag=0;
			try{
				$query = "DELETE FROM tbl_high_courts WHERE id=:HighCourtId";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':HighCourtId', $HighCourtId, \PDO::PARAM_INT);
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