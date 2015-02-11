<?php
	namespace classes\Implementation\DocInAppliType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocInAppliType/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocInAppliType as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addApplicationType($name)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				
				$con->beginTransaction();
				
				$sqlQuery = "insert into tbl_application_types(appli_type_name) values(:name)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':name', $name, \PDO::PARAM_STR);				
				$statement->execute();
					
			/*		$tbl_id  = $con->lastInsertId('tbl_application_types_id_seq');
					$tbl_name= 'tbl_application_types';
					$curDate = date("Y-m-d");
					$usrId   = $_SESSION['id'];
					$action  = 'Add';
					$sqlQuery = "insert into tbl_user_log(tbl_name,tbl_id,user_id,post_date,action)
						values(:tbl_name,:tbl_id,:user_id,:post_date,:action)";
					$statement = $con->prepare($sqlQuery);
					$statement->bindParam(':tbl_name', $tbl_name, \PDO::PARAM_STR);
					$statement->bindParam(':tbl_id', $tbl_id, \PDO::PARAM_INT);
					$statement->bindParam(':user_id', $usrId, \PDO::PARAM_INT);
					$statement->bindParam(':post_date', $curDate, \PDO::PARAM_STR);
					$statement->bindParam(':action', $action, \PDO::PARAM_STR);
					if($statement->execute())
					
			*/		
						$flag = 1;
					
					$con->commit();
					$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
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
		
		public function addDocRequestType($applicationId,$docId)		
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
			$con->beginTransaction();
			
			foreach ($docId as $val)
			{			
				$sqlQuery = "insert into tbl_docs_in_request_type(request_type_id, doc_type_id) values(:request_type_id, :doc_type_id)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':request_type_id', $applicationId, \PDO::PARAM_STR);
				$statement->bindParam(':doc_type_id', $val, \PDO::PARAM_STR);				
				$statement->execute();							
			}						
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