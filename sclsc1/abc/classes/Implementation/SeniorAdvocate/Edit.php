<?php
	namespace classes\Implementation\SeniorAdvocate;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SeniorAdvocate/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SeniorAdvocate as IEdit;
	 
	class Edit implements IEdit\Editable
	{
		/*public function upSrAvocateStatus($srAdvocateId,$activeStatus)
		{  		
			$flag=0;
			$con = Conn\Connection::getConnection();
		 try {			
			$con->beginTransaction();
			$query = "UPDATE tbl_sr_advocate SET is_active= :activeStatus WHERE id = :SrAdvocateId";
			$statement = $con->prepare($query);
			$statement->bindParam(':SrAdvocateId', $srAdvocateId, \PDO::PARAM_INT);
			$statement->bindParam(':activeStatus', $activeStatus, \PDO::PARAM_STR);
			if($statement->execute())
				$flag=1;
			$con->commit();
			$con =NULL;
		  }
		catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
		 }
		return $flag;
		
	   }*/
		public function upSrAvocateStatus($advocateId,$fullname,$gender,$lang,$email_id,$mobile_no,$mobile_no2,
				$date_of_enrol,$name_of_bar,$date_of_scba,$aor,$advocate_code,
				$is_on_panel,$is_aor,$address1,$address2,$city,$state,$pincode,$c_name,
				$c_address1,$c_address2,$c_city,$c_state,$c_pincode,$start_date1 = array(),
				$end_date1=array(),$hiddenData,$date_of_reg)
		{
			$flag=0;
			$con = Conn\Connection::getConnection();
			try
			{
				$con->beginTransaction();
				$query = "UPDATE tbl_sr_advocate SET sr_advocate_name=:fullname,gender=:gender,language=:lang,email_id=:email_id,contact_no1=:mobile_no,contact_no2=:mobile_no2,
					advocate_enrol_date=:date_of_enrol,enrolled_bar=:name_of_bar,scba_enrol_date=:date_of_scba,
					aor_desig_date=:aor,sr_advocate_code=:advocate_code,is_on_panel=:is_on_panel,is_aor=:is_aor WHERE id = :advocateId";
				$statement = $con->prepare($query);
				$statement->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
				//	$statement->bindParam(':title', $title, \PDO::PARAM_STR);
				$statement->bindParam(':fullname', $fullname, \PDO::PARAM_STR);
				$statement->bindParam(':gender', $gender, \PDO::PARAM_STR);
				$statement->bindParam(':lang', $lang, \PDO::PARAM_STR);
				$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
				$statement->bindParam(':mobile_no', $mobile_no, \PDO::PARAM_INT);
				$statement->bindParam(':mobile_no2', $mobile_no2, \PDO::PARAM_INT);
				$statement->bindParam(':date_of_enrol', $date_of_enrol, \PDO::PARAM_STR);
				$statement->bindParam(':name_of_bar', $name_of_bar, \PDO::PARAM_STR);
				$statement->bindParam(':date_of_scba', $date_of_scba, \PDO::PARAM_STR);
				$statement->bindParam(':aor', $aor, \PDO::PARAM_STR);
				$statement->bindParam(':advocate_code', $advocate_code, \PDO::PARAM_STR);
				$statement->bindParam(':is_on_panel', $is_on_panel, \PDO::PARAM_BOOL);
				$statement->bindParam(':is_aor', $is_aor, \PDO::PARAM_BOOL);
				$statement->execute();
					
				//$comm_add_1='f';
				$sqladd = "UPDATE tbl_sr_adv_address SET address1=:address1,address2=:address2,city=:city,state=:state,pincode=:pincode
					 WHERE sr_advocates_id = :advocateId AND is_commun_address IS FALSE";
				$getadd = $con->prepare($sqladd);
				$getadd->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
				$getadd->bindParam(':address1', $address1, \PDO::PARAM_STR);
				$getadd->bindParam(':address2', $address2, \PDO::PARAM_STR);
				$getadd->bindParam(':city', $city, \PDO::PARAM_STR);
				$getadd->bindParam(':state', $state, \PDO::PARAM_STR);
				$getadd->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
				//$getadd->bindParam(':is_commun_address',$comm_add_1, \PDO::PARAM_BOOL);
				$getadd->execute();
					
				$sqlcomm = "UPDATE tbl_sr_adv_address SET address1=:c_address1,address2=:c_address2,city=:c_city,state=:c_state,pincode=:c_pincode,commun_name=:c_name
					 WHERE sr_advocates_id = :advocateId AND is_commun_address IS TRUE";
				$getcomm = $con->prepare($sqlcomm);
				$getcomm->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
				$getcomm->bindParam(':c_address1', $c_address1, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_address2', $c_address2, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_city', $c_city, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_state', $c_state, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_pincode', $c_pincode, \PDO::PARAM_INT);
				$getcomm->bindParam(':c_name',$c_name, \PDO::PARAM_STR);
				$getcomm->execute();
					
		
					
				$query = "delete from tbl_sr_advocate_period WHERE sr_advocates_id = :advocateId";
				$statement1 = $con->prepare($query);
				$statement1->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
				$statement1->execute();
					
					
				$is_active="t";
				$periodReg = "insert into tbl_sr_advocate_period(sr_advocates_id,start_date,is_active)
			              values(:advocateId,:start_date,:is_active)";
					
				$perioddateReg = $con->prepare($periodReg);
				$perioddateReg->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
				$perioddateReg->bindParam(':start_date', $date_of_reg, \PDO::PARAM_STR);
				$perioddateReg->bindParam(':is_active',$is_active, \PDO::PARAM_STR);
				$perioddateReg->execute();
		
				for ($i=0; $i< ($hiddenData); $i++)
				{
				$is_active='f';
				$sqlperiod = "insert into tbl_sr_advocate_period(sr_advocates_id,start_date,end_date,is_active)
			              values(:advocateId,:start_date,:end_date,:is_active)";
						$period = $con->prepare($sqlperiod);
						$period->bindParam(':advocateId', $advocateId, \PDO::PARAM_INT);
						$period->bindParam(':start_date', $start_date1[$i], \PDO::PARAM_STR);
						$period->bindParam(':end_date', $end_date1[$i], \PDO::PARAM_STR);
						$period->bindParam(':is_active',$is_active, \PDO::PARAM_BOOL);
						$period->execute();
				}
					
				$flag=1;
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