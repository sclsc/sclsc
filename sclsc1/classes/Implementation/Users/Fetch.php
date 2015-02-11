<?php
	namespace classes\Implementation\Users;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';	
	require_once $_SESSION['base_url'].'/classes/Interfaces/Users/Fetchable.php';	
	
	use classes\Connection as Conn;
	use classes\Interfaces\Users as intFetch;
	
	class Fetch implements intFetch\Fetchable
	{	
		public function verifyLogin($user, $password)
		{
			$con = Conn\Connection::getConnection();
			try
			{
				$id = 0;
				$query = " SELECT id FROM tbl_user WHERE (user_name = :user_name OR email_id = :user_name) AND password = :password ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':user_name', $user, \PDO::PARAM_STR);
				$stmt->bindValue(':password', $password, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$id = $row['id'];
				$con = NULL;
			}
			catch (PDOException $e) 
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $id;
		}
		
		public function getUserDetails($id)
		{
			$con = Conn\Connection::getConnection();
			try
			{
				$user = array();
				$query = "SELECT * FROM tbl_user WHERE id = :id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$user['id'] = $row['id'];
					$user['user_name'] = $row['user_name'];
					$user['password'] = $row['password'];
					$user['first_name'] = $row['first_name'];
					$user['last_name'] = $row['last_name'];
					$user['designation'] = $row['designation'];
					$user['contact_no_1'] = $row['contact_no_1'];
					$user['contact_no_2'] = $row['contact_no_2'];
					$user['email_id'] = $row['email_id'];
					$user['is_active'] = $row['is_active'];
					$user['role_id'] = $row['role_id'];
				}
				$con = NULL;
			}
			catch (PDOException $e) 
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $user;
		}
		
		public function getAllUsers()
		{
			$con = Conn\Connection::getConnection();
			try
			{
				$user = array();
				$query = "SELECT * FROM tbl_user order by id";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) 
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getDealingUsers()
		{
			$con = Conn\Connection::getConnection();
			try{
				$user = array();
				$query = "SELECT * FROM tbl_user WHERE role_id = 2";
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
		public function getRole()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_role";
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
		public function checkApplicationType($email_id)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT email_id FROM tbl_user WHERE email_id = :email_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$flag = 1;
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
	}
?>