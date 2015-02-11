<?php
	namespace classes\Implementation\StageType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/StageType/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\StageType as IAdd;
	
	class Add implements IAdd\Addable
	{
			
		public function addSatgeType(
				    $stage_name,
			 		$stage_page)
		{
		//	echo $name.'===='.$stage.'===='.$sub_stages.'==='.$filepath; exit;
			
			$flag = 0;			
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				
		     $sqlQuery = "INSERT INTO tbl_stages(stage_name, stage_page,parent_id) 
						VALUES(:stage_name,:stage_page,'0')";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':stage_name', $stage_name, \PDO::PARAM_STR);
				$statement->bindParam(':stage_page', $stage_page, \PDO::PARAM_STR);
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