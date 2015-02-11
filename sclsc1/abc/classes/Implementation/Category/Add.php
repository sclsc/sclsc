<?php
	namespace classes\Implementation\Category;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Category/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Category as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addCategory($category_name) 
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "INSERT INTO tbl_diary_category(category_name)VALUES(:category_name)";
				$statement = $con->prepare($query);
				$statement->bindParam(':category_name', $category_name, \PDO::PARAM_STR);
				if($statement->execute())
					$flag =1;
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	}
?>