<?php
	namespace classes\Implementation\Category;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Category/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Category as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateCategoryName($category_name,$category_id)  
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "update tbl_diary_category set category_name = :category_name WHERE id = :category_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':category_name', $category_name, \PDO::PARAM_STR);
				$statement->bindParam(':category_id', $category_id, \PDO::PARAM_STR);
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
		
		public function updateCategoryStatus($category_id,$status)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "update tbl_diary_category set is_active = :status where id = :category_id";
				$statement = $con->prepare($query);
				$statement->bindParam(':category_id', $category_id, \PDO::PARAM_INT);
				$statement->bindParam(':status', $status, \PDO::PARAM_BOOL);
				if($statement->execute())
					$flag =1;
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