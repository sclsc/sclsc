<?php
	namespace classes\Implementation\SeniorAdvocate;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SeniorAdvocate/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SeniorAdvocate as IAdd;
	
	class Add implements IAdd\Addable
	{	
		
		public function reg_sr_advocate(
				$full_name,
				$gender,
				$lang,
				$email_id,
				$mobile_no,
				$mobile_no2,
				$date_of_reg,
				$date_of_enrol,
				$name_of_bar,
				$date_of_scba,
				$aor,
				$address1,
				$address2,
				$city,
				$state,
				$pincode,
				$c_name,
				$c_address1,
				$c_address2,
				$c_city,				
				$c_state,
				$c_pincode,
				$comm_add,
				$is_on_panel,
				$is_aor,
				$advocate_code,
				$start_date1 = array(),
				$end_date1=array(),
				$hiddenData
		)
		{	
			//echo 'test'; exit;
			
			$is_active="t";		
			$flag = 0;		
			$con = Conn\Connection::getConnection();		
			try 
			{

				$con->beginTransaction();
			 
			 $sqlQuery = "insert into tbl_sr_advocate
					     (sr_advocate_name, sr_advocate_code, email_id, contact_no1, contact_no2, advocate_enrol_date,
			 		     enrolled_bar, scba_enrol_date ,aor_desig_date, language, is_active, is_on_panel, gender, is_aor)
					     values(:full_name, :advocate_code, :email_id, :contact_no1, :contact_no2, :advocate_enrol_date,
					    :enrolled_bar, :scba_enrol_date, :aor_desig_date, :language, :is_active, :is_on_panel, :gender, :is_aor)";
			$statement = $con->prepare($sqlQuery);
			$statement->bindParam(':full_name', $full_name, \PDO::PARAM_STR);
			$statement->bindParam(':advocate_code', $advocate_code, \PDO::PARAM_STR);
			$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
			$statement->bindParam(':contact_no1', $mobile_no, \PDO::PARAM_STR);
			$statement->bindParam(':contact_no2', $mobile_no2, \PDO::PARAM_STR);
			$statement->bindParam(':advocate_enrol_date', $date_of_enrol, \PDO::PARAM_STR);
			$statement->bindParam(':enrolled_bar', $name_of_bar, \PDO::PARAM_STR);
			$statement->bindParam(':scba_enrol_date', $date_of_scba, \PDO::PARAM_STR);
			$statement->bindParam(':aor_desig_date', $aor, \PDO::PARAM_STR);
			$statement->bindParam(':language', $lang, \PDO::PARAM_STR);
			$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
			$statement->bindParam(':is_on_panel', $is_on_panel, \PDO::PARAM_BOOL);
			$statement->bindParam(':gender', $gender, \PDO::PARAM_STR);
			$statement->bindParam(':is_aor', $is_aor, \PDO::PARAM_BOOL);
			$statement->execute();
			
			$advocate_maxID = $con->lastInsertId('tbl_sr_advocate_id_seq');
								
			$periodReg = "insert into tbl_sr_advocate_period(sr_advocates_id,start_date,is_active)
			 values(:advocate_maxID,:start_date,:is_active)";
			$perioddateReg = $con->prepare($periodReg);
			$perioddateReg->bindParam(':advocate_maxID', $advocate_maxID, \PDO::PARAM_INT);
			$perioddateReg->bindParam(':start_date', $date_of_reg, \PDO::PARAM_STR);
			$perioddateReg->bindParam(':is_active',$is_active, \PDO::PARAM_STR);
			$perioddateReg->execute();
					
			for ($i=0; $i< ($hiddenData); $i++)
			{
				$is_active='f';
				$sqlperiod = "insert into tbl_sr_advocate_period(sr_advocates_id,start_date,end_date,is_active)
			                  values(:advocate_maxID,:start_date,:end_date,:is_active)";
				$period = $con->prepare($sqlperiod);
				$period->bindParam(':advocate_maxID', $advocate_maxID, \PDO::PARAM_STR);
				$period->bindParam(':start_date', $start_date1[$i], \PDO::PARAM_STR);
				$period->bindParam(':end_date', $end_date1[$i], \PDO::PARAM_STR);
				$period->bindParam(':is_active',$is_active, \PDO::PARAM_BOOL);
				$period->execute();		
			}						
				
			$comm_add_1='f';
			$sqladd = "insert into tbl_sr_adv_address
			          (sr_advocates_id, address1, address2, city,state, pincode, is_commun_address)
			          values(:advocate_maxID, :address1, :address2, :city, :state, :pincode, :is_commun_address)";
			$getadd = $con->prepare($sqladd);
			$getadd->bindParam(':advocate_maxID', $advocate_maxID, \PDO::PARAM_INT);
			$getadd->bindParam(':address1', $address1, \PDO::PARAM_STR);
			$getadd->bindParam(':address2', $address2, \PDO::PARAM_STR);
			$getadd->bindParam(':city', $city, \PDO::PARAM_STR);
			$getadd->bindParam(':state', $state, \PDO::PARAM_STR);
			$getadd->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
			$getadd->bindParam(':is_commun_address',$comm_add_1, \PDO::PARAM_BOOL);
			$getadd->execute();
											
			if($comm_add=='1')
			{				
				$sqlcomm = "insert into tbl_sr_adv_address
		                    (sr_advocates_id, address1, address2, city, state, pincode, is_commun_address, commun_name)
		                     values(:advocate_maxID, :c_address1, :c_address2, :c_city, :c_state, :c_pincode,
							:is_commun_address, :c_name)";
				$getcomm = $con->prepare($sqlcomm);
				$getcomm->bindParam(':advocate_maxID', $advocate_maxID, \PDO::PARAM_INT);
				$getcomm->bindParam(':c_address1', $c_address1, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_address2', $c_address2, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_city', $c_city, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_state', $c_state, \PDO::PARAM_STR);
				$getcomm->bindParam(':c_pincode', $c_pincode, \PDO::PARAM_INT);
				$getcomm->bindParam(':is_commun_address',$comm_add, \PDO::PARAM_BOOL);
				$getcomm->bindParam(':c_name',$c_name, \PDO::PARAM_STR);
				$getcomm->execute();
			}
			
			$flag = 1;
			$con->commit();
			$con =NULL;					
			}
			catch (\PDOException $e)
			 {
				$con->rollBack();
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			 }
		
				return $flag;
			}
		
		
	}
?>