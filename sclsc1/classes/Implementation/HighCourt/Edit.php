<?php
	namespace classes\Implementation\HighCourt;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/HighCourt/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\HighCourt as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		public function updateHighCourtDetail($id,$hc_name,$bench,$email_id,$mobile_no,$hc_address1,$hc_address2,$city,$state,$pincode)
		{
			$flag = 0;
			$con = Conn\Connection::getConnection();
			try{
				$con->beginTransaction();
				$query = "update tbl_high_courts set hc_name = :hc_name,bench = :bench,email_id =:email_id,mobile_no= :mobile_no,hc_address1 = :hc_address1,hc_address2 =:hc_address2,city = :city,state = :state,pincode = :pincode WHERE id = :id";
				$statement = $con->prepare($query);
				$statement->bindParam(':id', $id, \PDO::PARAM_INT);
				$statement->bindParam(':hc_name', $hc_name, \PDO::PARAM_STR);
				$statement->bindParam(':bench', $bench, \PDO::PARAM_STR);
				$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$statement->bindParam(':mobile_no', $mobile_no, \PDO::PARAM_INT);
				$statement->bindParam(':hc_address1', $hc_address1, \PDO::PARAM_STR);
				$statement->bindParam(':hc_address2', $hc_address2, \PDO::PARAM_STR);
				$statement->bindParam(':city', $city, \PDO::PARAM_STR);
				$statement->bindParam(':state', $state, \PDO::PARAM_INT);
				$statement->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
				
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