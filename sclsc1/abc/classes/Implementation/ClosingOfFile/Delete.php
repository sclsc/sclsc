<?php
	namespace classes\Implementation\ClosingOfFile;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ClosingOfFile/Deletable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ClosingOfFile as IDelete;
	 
	class Delete implements IDelete\Deletable
	{
		public function deleteDiary($diaryId)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "DELETE FROM tbl_diary WHERE id = :diaryId ";
				$statement = $con->prepare($query);
				$statement->bindParam(':diaryId', $diaryId, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
				$con =NULL;
			}
			catch (PDOException $e) {
				$pdo->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	}
?>