<?php
	namespace classes\Implementation\Translator;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Translator/Addable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Translator as IAdd;
	
	class Add implements IAdd\Addable
	{
	public function reg_translator(
				$full_name,
				$gender,
				$lang,
				$email_id,
				$createtime,
				$mobile_no,
				$mobile_no2,
				$date_of_reg,
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
				$start_date1 = array(),
				$end_date1=array(),
				$hiddenData
		)
		
	  {	
			$is_active="t";		
			$flag = 0;
			$con = Conn\Connection::getConnection();
		try 
		 {
			$con->beginTransaction();
				
			$sqlQuery = "insert into tbl_translator
				        (translator_name,email_id, create_time,contactno1, contactno2, lang_id, gender, is_active)
				        values(:full_name, :email_id, :createtime,:mobile_no, :mobile_no2, :lang, :gender,:is_active)";
			$statement = $con->prepare($sqlQuery);
			$statement->bindParam(':full_name', $full_name, \PDO::PARAM_STR);
			$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
			$statement->bindParam(':createtime', $createtime, \PDO::PARAM_STR);
			$statement->bindParam(':mobile_no', $mobile_no, \PDO::PARAM_STR);
			$statement->bindParam(':mobile_no2', $mobile_no2, \PDO::PARAM_STR);
			$statement->bindParam(':lang', $lang, \PDO::PARAM_INT);
			$statement->bindParam(':gender', $gender, \PDO::PARAM_STR);
			$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
			$statement->execute();
			
			$translator_maxID = $con->lastInsertId('translator_on_panel_translator_id_seq');		
		
			$periodReg = "insert into tbl_translator_period(translator_id,start_date,is_active)
			              values(:translator_maxID,:start_date,:is_active)";
			$perioddateReg = $con->prepare($periodReg);
			$perioddateReg->bindParam(':translator_maxID', $translator_maxID, \PDO::PARAM_INT);
			$perioddateReg->bindParam(':start_date', $date_of_reg, \PDO::PARAM_STR);
			$perioddateReg->bindParam(':is_active',$is_active, \PDO::PARAM_STR);
			$perioddateReg->execute();
					
			for ($i=0; $i< ($hiddenData); $i++)
			 {
			$is_active='f';							
			$sqlperiod = "insert into tbl_translator_period(translator_id,start_date,end_date,is_active)
			              values(:translator_maxID,:start_date,:end_date,:is_active)";
			$period = $con->prepare($sqlperiod);
			$period->bindParam(':translator_maxID', $translator_maxID, \PDO::PARAM_INT);
			$period->bindParam(':start_date', $start_date1[$i], \PDO::PARAM_STR);
			$period->bindParam(':end_date', $end_date1[$i], \PDO::PARAM_STR);
			$period->bindParam(':is_active',$is_active, \PDO::PARAM_BOOL);
			$period->execute();										
			 }
												
			$comm_add_1='f';
			$sqladd = "insert into tbl_translator_address (translator_id,address1,address2,city,state,pincode,is_commun_address)
		               values(:translator_maxID,:address1,:address2,:city,:state,:pincode,:is_commun_address)";
	        $getadd = $con->prepare($sqladd);
			$getadd->bindParam(':translator_maxID', $translator_maxID, \PDO::PARAM_INT);
			$getadd->bindParam(':address1', $address1, \PDO::PARAM_STR);
			$getadd->bindParam(':address2', $address2, \PDO::PARAM_STR);
			$getadd->bindParam(':city', $city, \PDO::PARAM_STR);
			$getadd->bindParam(':state', $state, \PDO::PARAM_STR);
			$getadd->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
			$getadd->bindParam(':is_commun_address',$comm_add_1, \PDO::PARAM_BOOL);			
			$getadd->execute();	
				
			if($comm_add=='1')
			 {									
			$sqlcomm = "insert into tbl_translator_address
			           (translator_id, address1, address2, city, state, pincode, is_commun_address, commun_name)
			           values(:translator_maxID, :c_address1, :c_address2, :c_city, :c_state, :c_pincode, :is_commun_address, :c_name)";
			$getcomm = $con->prepare($sqlcomm);
			$getcomm->bindParam(':translator_maxID', $translator_maxID, \PDO::PARAM_INT);
			$getcomm->bindParam(':c_address1', $c_address1, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_address2', $c_address2, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_city', $c_city, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_state', $c_state, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_pincode', $c_pincode, \PDO::PARAM_INT);
			$getcomm->bindParam(':is_commun_address',$comm_add, \PDO::PARAM_BOOL);
			$getcomm->bindParam(':c_name',$c_name, \PDO::PARAM_STR);
			$getcomm->execute();
			
			}
			$flag=1;
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