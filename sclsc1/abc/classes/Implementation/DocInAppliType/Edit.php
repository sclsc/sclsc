<?php
	namespace classes\Implementation\DocInAppliType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/DocInAppliType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\DocInAppliType as IEdit;
	 
	class Edit implements IEdit\Editable
	{

		public function updateDocAplliType($applicationId,$documentId,$hiddenDoc)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				

			//	print_r($documentId);
			//	print_r($hiddenDoc); 
				
				$newDoc = array_diff($documentId,$hiddenDoc);
				$oldDoc = array_diff($hiddenDoc,$documentId);
				
			//	print_r($newDoc);
			//	print_r($oldDoc); exit;
				
				if(count($oldDoc) > 0)
				{
					foreach ($oldDoc as $val)
					{		
						$active=TRUE;				
						$query = "SELECT id FROM tbl_docs_in_request_type
							WHERE request_type_id = :request_type_id AND doc_type_id = :doc_type_id AND is_active = :is_active";
						$statement = $con->prepare($query);
						$statement->bindParam(':request_type_id', $applicationId, \PDO::PARAM_STR);
						$statement->bindParam(':doc_type_id', $val, \PDO::PARAM_STR);
						$statement->bindParam(':is_active', 	$active, \PDO::PARAM_BOOL);
						$statement->execute();
						while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))						
						  $docID = $row['id'];
	
						$curStatus = FALSE;
						$query = "UPDATE tbl_docs_in_request_type set is_active = :is_active WHERE id = :id";
						$statement = $con->prepare($query);
						$statement->bindParam(':is_active', $curStatus, \PDO::PARAM_BOOL);
						$statement->bindParam(':id', $docID, \PDO::PARAM_INT);			
						$statement->execute();
					}
				}				
				
				if(count($newDoc) > 0)
				{
				  foreach ($newDoc as $val)
				  {			  	
						$sqlQuery = "insert into tbl_docs_in_request_type(request_type_id, doc_type_id) 
								values(:request_type_id, :doc_type_id)";
						$statement = $con->prepare($sqlQuery);
						$statement->bindParam(':request_type_id', $applicationId, \PDO::PARAM_STR);
						$statement->bindParam(':doc_type_id', $val, \PDO::PARAM_STR);				
						$statement->execute();
				  }	
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