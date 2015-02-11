<?php
	namespace classes\Implementation\LetterType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/LetterType/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\LetterType as IEdit;
	 
	class Edit implements IEdit\Editable
	{	
		
		public function updateDocument($doc_id,$doc_name,$is_active =NULL)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_doc_type set doc_name = :doc_name WHERE id = :doc_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':doc_name', $doc_name, \PDO::PARAM_STR);
				$statement->bindParam(':doc_id', $doc_id, \PDO::PARAM_STR);
		
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
		
		
		public function updateDocumentStatus($doc_id,$is_active)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_doc_type set is_active = :is_active WHERE id = :doc_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->bindParam(':doc_id', $doc_id, \PDO::PARAM_STR);
		
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
		public function updateLetter($Letter_id,$name,$stage,$sub_stages,$filepath)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				//echo $fileName;
				$str=explode('.', $filepath);
				$fileName=$str[0].'_'.$Letter_id;
				$NewfileName=$fileName.'.'.$str[1];
				//echo $NewfileName;exit;
				$query = "update tbl_letter_types set type_name = :name,stage_id = :stage,sub_stage_id = :sub_stages,file_path = :NewfileName WHERE id = :Letter_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':Letter_id', $Letter_id, \PDO::PARAM_INT);
				$statement->bindParam(':name', $name, \PDO::PARAM_STR);
				$statement->bindParam(':stage', $stage, \PDO::PARAM_INT);
				$statement->bindParam(':sub_stages', $sub_stages, \PDO::PARAM_INT);
				$statement->bindParam(':NewfileName', $NewfileName, \PDO::PARAM_STR);
		
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