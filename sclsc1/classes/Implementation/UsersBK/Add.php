<?php
	namespace classes\Implementation\Users;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Users/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Users as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function registerUser($role,
					$username,
				    $password,
				    $firstname,
				    $lastname,
				    $designation,
					$email_id,
					$mobile_no1,
					$mobile_no2
					)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try
			{
				$sqlQuery = "INSERT INTO tbl_user(role_id,user_name,password,first_name,last_name,designation,email_id,contact_no_1,contact_no_2)
							VALUES(:role,:username,:password,:firstname,:lastname,:designation,:email_id,:mobile_no1,:mobile_no2)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':role', $role, \PDO::PARAM_INT);
				$statement->bindParam(':username', $username, \PDO::PARAM_STR);
				$statement->bindParam(':password', $password, \PDO::PARAM_STR);
				$statement->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
				$statement->bindParam(':lastname', $lastname, \PDO::PARAM_STR);
				$statement->bindParam(':designation', $designation, \PDO::PARAM_STR);
				$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$statement->bindParam(':mobile_no1', $mobile_no1, \PDO::PARAM_INT);
				$statement->bindParam(':mobile_no2', $mobile_no2, \PDO::PARAM_INT);
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