<?php
	namespace classes\Implementation\Translator;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Translator/Editable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Translator as IEdit;
	 
	class Edit implements IEdit\Editable
	{
	public function upTranslatorStatus($translatorId,$fullname,$gender,$lang,$email_id,$mobile_no,$mobile_no2,
				$address1,$address2,$city,$state,$pincode,$c_name,
				$c_address1,$c_address2,$c_city,$c_state,$c_pincode,$start_date1 = array(),
				$end_date1=array(),$hiddenData,$date_of_reg)
		{   
			$flag=0;
			$con = Conn\Connection::getConnection();
		 try 
		  {			
			$con->beginTransaction();
			$query = "UPDATE tbl_translator SET translator_name=:fullname,gender=:gender,lang_id=:lang,
					email_id=:email_id,contactno1=:mobile_no,contactno2=:mobile_no2
		            WHERE translator_id = :translatorId";
			$statement = $con->prepare($query);
			$statement->bindParam(':translatorId', $translatorId, \PDO::PARAM_INT);
			$statement->bindParam(':fullname', $fullname, \PDO::PARAM_STR);
			$statement->bindParam(':gender', $gender, \PDO::PARAM_STR);
			$statement->bindParam(':lang', $lang, \PDO::PARAM_INT);
			$statement->bindParam(':email_id', $email_id, \PDO::PARAM_STR);
			$statement->bindParam(':mobile_no', $mobile_no, \PDO::PARAM_INT);
			$statement->bindParam(':mobile_no2', $mobile_no2, \PDO::PARAM_INT);
			$statement->execute();
			
			//$comm_add_1='f';
			$sqladd = "UPDATE tbl_translator_address SET address1=:address1,address2=:address2,city=:city,state=:state,pincode=:pincode
					 WHERE translator_id = :translatorId AND is_commun_address IS FALSE";
			$getadd = $con->prepare($sqladd);
			$getadd->bindParam(':translatorId', $translatorId, \PDO::PARAM_INT);
			$getadd->bindParam(':address1', $address1, \PDO::PARAM_STR);
			$getadd->bindParam(':address2', $address2, \PDO::PARAM_STR);
			$getadd->bindParam(':city', $city, \PDO::PARAM_STR);
			$getadd->bindParam(':state', $state, \PDO::PARAM_STR);
			$getadd->bindParam(':pincode', $pincode, \PDO::PARAM_INT);
			//$getadd->bindParam(':is_commun_address',$comm_add_1, \PDO::PARAM_BOOL);
			$getadd->execute();
			
			$sqlcomm = "UPDATE tbl_translator_address SET address1=:c_address1,address2=:c_address2,city=:c_city,state=:c_state,pincode=:c_pincode,commun_name=:c_name
					 WHERE translator_id = :translatorId AND is_commun_address IS TRUE";
			$getcomm = $con->prepare($sqlcomm);
			$getcomm->bindParam(':translatorId', $translatorId, \PDO::PARAM_INT);
			$getcomm->bindParam(':c_address1', $c_address1, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_address2', $c_address2, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_city', $c_city, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_state', $c_state, \PDO::PARAM_STR);
			$getcomm->bindParam(':c_pincode', $c_pincode, \PDO::PARAM_INT);
			$getcomm->bindParam(':c_name',$c_name, \PDO::PARAM_STR);
			$getcomm->execute();
			
		
			
			$query = "delete from tbl_translator_period WHERE translator_id = :translatorId";
			$statement1 = $con->prepare($query);
			$statement1->bindParam(':translatorId', $advocateId, \PDO::PARAM_INT);
			$statement1->execute();
			
			
			$is_active="t";
			$periodReg = "insert into tbl_translator_period(translator_id,start_date,is_active)
			              values(:translatorId,:start_date,:is_active)";
			
			$perioddateReg = $con->prepare($periodReg);
			$perioddateReg->bindParam(':translatorId', $translatorId, \PDO::PARAM_INT);
			$perioddateReg->bindParam(':start_date', $date_of_reg, \PDO::PARAM_STR);
			$perioddateReg->bindParam(':is_active',$is_active, \PDO::PARAM_STR);
			$perioddateReg->execute();
				
			for ($i=0; $i< ($hiddenData); $i++)
			{
			$is_active='f';
			$sqlperiod = "insert into tbl_translator_period(translator_id,start_date,end_date,is_active)
			              values(:translatorId,:start_date,:end_date,:is_active)";
			$period = $con->prepare($sqlperiod);
						$period->bindParam(':translatorId', $translatorId, \PDO::PARAM_INT);
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