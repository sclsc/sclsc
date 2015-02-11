<?php
	namespace classes\Implementation\Users;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Users/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Users as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updatePassword($userId,$newPassword,$oldPassword)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			$count=0;
			try
			{
				$qry=" SELECT * FROM tbl_user WHERE id= :user_id AND password= :old_password ";
				$statement = $con->prepare($qry);
				$statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
				$statement->bindParam(':old_password', $oldPassword, \PDO::PARAM_STR);
				if($statement->execute())
					while($statement->fetch())
						$count++;
				if($count != 0)
				{
					$query = " UPDATE tbl_user SET password = :new_password WHERE id = :user_id AND password LIKE :old_password";
					$statement = $con->prepare($query);
					$statement->bindParam(':new_password', $newPassword, \PDO::PARAM_STR);
					$statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
					$statement->bindParam(':old_password', $oldPassword, \PDO::PARAM_STR);
					
					if($statement->execute())
						$flag = 1;
				}
				$con =NULL;
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		public function updateUserDetail($id,$role,$username,$password,$firstname,$lastname,$designation,$email_id,$mobile_no1,$mobile_no2)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_user set role_id = :role,user_name = :username,password = :password,first_name = :firstname,last_name =:lastname,designation = :designation,email_id =:email_id,contact_no_1= :mobile_no1,contact_no_2 = :mobile_no2 WHERE id = :id";
				$statement = $con->prepare($query);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
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
		
		
		public function changepassword($user,$password)
		{
			
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_user set password = :password,is_change_password = 'TRUE'  WHERE id = :user";
				$statement = $con->prepare($query);
				$statement->bindParam(':user', $user, \PDO::PARAM_INT);
				$statement->bindParam(':password', $password, \PDO::PARAM_STR);
			//	$statement->bindParam(':username', $username, \PDO::PARAM_STR);
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