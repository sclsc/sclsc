<?php
	namespace classes\Implementation\DocumentTypes;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocumentTypes/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocumentTypes as IAdd;
	
	class Add implements IAdd\Addable
	{
			
		public function addDocument($docName)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$sqlQuery = "insert into tbl_doc_type(doc_name) values(:doc_name)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':doc_name', $docName, \PDO::PARAM_STR);				
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