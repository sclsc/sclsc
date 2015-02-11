<?php
	namespace classes\Implementation\LetterType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/LetterType/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\LetterType as IAdd;
	
	class Add1 implements IAdd\Addable
	{
			
		public function addLetterType(
				    $firstname,
			 		$lastname,			 				 		
			 		$address,
			 		$subject
				     )
		{
			
			
			$flag = 0;			
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
				$sqlQuery = "INSERT INTO tbl_file_types(firstname, lastname, address, 
						subject) VALUES(:firstname, :lastname, :address, :subject)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
				$statement->bindParam(':lastname', $lastname, \PDO::PARAM_STR);
				$statement->bindParam(':address', $address, \PDO::PARAM_STR);
				$statement->bindParam(':subject', $subject, \PDO::PARAM_STR);
				//$statement->bindParam(':stage_id', $stageId, \PDO::PARAM_INT);
			//	$statement->bindParam(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
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
