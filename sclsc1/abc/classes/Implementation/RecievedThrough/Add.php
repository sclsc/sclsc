<?php
	namespace classes\Implementation\RecievedThrough;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThrough/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThrough as IAdd;
	
	class Add implements IAdd\Addable
	{
		public function addReceivedThrough($received_through_type,$designation,$appli_through_type_name,$email_id,$contact_number,$address_line1,$address_line2,$city,$state,$pincode)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();
		
				$query = "INSERT INTO tbl_appli_through(appli_through_type_id,designation,appli_through_name,email_id,contact_no,address_line1,address_line2,city,state,pincode)VALUES(:through_type_id,:designation,:appli_through_name,:email_id,:contact_no,:address_line1,:address_line2,:city,:state,:pincode)";
				$statement = $con->prepare($query);
				$statement->bindParam(':through_type_id', $received_through_type, \PDO::PARAM_INT);
				$statement->bindParam(':designation', $designation, \PDO::PARAM_STR);
				$statement->bindParam(':appli_through_name', $appli_through_type_name, \PDO::PARAM_STR);
				$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$statement->bindParam(':contact_no', $contact_number, \PDO::PARAM_STR);
				$statement->bindParam(':address_line1', $address_line1, \PDO::PARAM_STR);
				$statement->bindParam(':address_line2', $address_line2, \PDO::PARAM_STR);
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_STR);
				if($statement->execute())
					$flag = 1;
					
				/* $tbl_id  = $con->lastInsertId('tbl_appli_through_id_seq');
				$tbl_name= 'tbl_appli_through';
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
				$statement->bindParam(':action', $action, \PDO::PARAM_STR); */
				
		
				$con->commit();
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