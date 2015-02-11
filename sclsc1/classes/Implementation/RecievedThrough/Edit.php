<?php
	namespace classes\Implementation\RecievedThrough;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThrough/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThrough as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateRecievedThrough($id,$received_through,$designation,$appli_through_name,$email_id,$contact_number,$address_line1,$address_line2,$city,$state,$pincode)
		{
		
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
		
				$con->beginTransaction();
		
				$query = "Update tbl_appli_through set appli_through_type_id=:through_type_id,designation=:designation,appli_through_name=:appli_through_name,email_id=:email_id,contact_no=:contact_no,address_line1=:address_line1,address_line2=:address_line2,city=:city,state=:state,pincode=:pincode where id=:id";
				$statement = $con->prepare($query);
				$statement->bindParam(':through_type_id', $received_through, \PDO::PARAM_INT);
				$statement->bindParam(':designation', $designation, \PDO::PARAM_STR);
				$statement->bindParam(':appli_through_name', $appli_through_name, \PDO::PARAM_STR);
				$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$statement->bindParam(':contact_no', $contact_number, \PDO::PARAM_STR);
				$statement->bindParam(':address_line1', $address_line1, \PDO::PARAM_STR);
				$statement->bindParam(':address_line2', $address_line2, \PDO::PARAM_STR);
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_STR);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
				if($statement->execute())
					$flag = 1;
				
				/* $tbl_id  = $id;
				$tbl_name= 'tbl_appli_through';
				$curDate = date("Y-m-d");
				$usrId   = $_SESSION['id'];
				$action  = 'Update';
				$sqlQuery = "insert into tbl_user_log(tbl_name,tbl_id,user_id,post_date,action)
						values(:tbl_name,:tbl_id,:user_id,:post_date,:action)";
				$statement = $con->prepare($sqlQuery);
				$statement->bindParam(':tbl_name', $tbl_name, \PDO::PARAM_INT);
				$statement->bindParam(':tbl_id', $tbl_id, \PDO::PARAM_INT);
				$statement->bindParam(':user_id', $usrId, \PDO::PARAM_INT);
				$statement->bindParam(':post_date', $curDate, \PDO::PARAM_STR);
				$statement->bindParam(':action', $action, \PDO::PARAM_STR); */
				
		
				$con->commit();
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