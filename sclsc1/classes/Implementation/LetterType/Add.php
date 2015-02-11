<?php
	namespace classes\Implementation\LetterType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/LetterType/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\LetterType as IAdd;
	
	class Add implements IAdd\Addable
	{
			
		public function addLetterType(
				    $name,
			 		$stage,
				    $sub_stages,
                    $filepath )
		{
		//	echo $name.'===='.$stage.'===='.$sub_stages.'==='.$filepath; exit;
			
			$flag = 0;			
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
				$sqlQuery = "INSERT INTO tbl_letter_types(type_name, stage_id, sub_stage_id, file_path) 
						VALUES(:type_name,:stages,:sub_stages,:filepath)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':type_name', $name, \PDO::PARAM_STR);
				$statement->bindParam(':stages', $stage, \PDO::PARAM_INT);
				$statement->bindParam(':sub_stages', $sub_stages, \PDO::PARAM_INT);
				$statement->bindParam(':filepath',  $filepath  , \PDO::PARAM_STR);
				$statement->execute();
					
				$LetterId = $con->lastInsertId('tbl_letter_types_id_seq');
				$str=explode('.', $filepath);
				$fileName=$str[0].'_'.$LetterId;
				$NewfileName=$fileName.'.'.$str[1];
					
				$sqlQuery = "UPDATE tbl_letter_types SET file_path=:NewfileName WHERE id =:id";
				$statement = $con->prepare($sqlQuery);				
				$statement->bindParam(':id', $LetterId, \PDO::PARAM_INT);					
				$statement->bindParam(':NewfileName',  $NewfileName  , \PDO::PARAM_STR);
				$statement->execute();
				
					
				$flag = 1;
				$con->commit();
				$con =NULL;
			}
			catch (PDOException $e) {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $LetterId;
		}
		
  }
?>