<?php
	namespace classes\Implementation\Category;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Category/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Category as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function getEnabledCategoryIds()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_diary_category WHERE is_active = true ORDER BY id";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getDisabledCategoryIds()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_diary_category WHERE is_active = false ORDER BY id";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getCategoryName($categoryId)
		{
			$count != 0?$cond = 'LIMIT '.$count:$cond = '';
			$con = Conn\Connection::getConnection();
			try{
				$query = "select category_name from tbl_diary_category where id = :categoryId";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function checkCategory($category_name)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT id FROM tbl_diary_category where category_name = :category_name";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':category_name', $category_name, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$flag = 1;
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		public function getAllCategory()
		{
			$con = Conn\Connection::getConnection();
			
			try{
				$query = "SELECT * FROM tbl_diary_category";
				$stmt = $con->prepare($query);
				$stmt->execute();
				
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		

		
	}
?>