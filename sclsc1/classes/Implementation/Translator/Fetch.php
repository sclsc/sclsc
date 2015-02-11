<?php
	namespace classes\Implementation\Translator;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Translator/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Translator as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
	public function getAllTranslator($limit,$start)
		{			
			$count = 0;
			$flag=0;
			try 
			{
			$con = Conn\Connection::getConnection();				
		    $query = "SELECT DISTINCT ON (a.translator_id) a.translator_id, a.translator_name, a.email_id,
		    		 a.contactno1, a.is_active, a.medium_code, b.start_date FROM tbl_translator a 
				     FULL JOIN tbl_translator_period  b on a.translator_id = b.translator_id 
				     ORDER BY a.translator_id DESC LIMIT :limit OFFSET :offset";
			$statement = $con->prepare($query);
			$statement->bindValue(':limit', $limit, \PDO::PARAM_STR);
			$statement->bindValue(':offset', $start, \PDO::PARAM_STR);
			$statement->execute();
			}
			catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();		
		}
		
		public function getAllTranslatorCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{				
				$query = "SELECT COUNT(DISTINCT a.translator_id) as count FROM tbl_translator a 
				     FULL JOIN tbl_translator_period  b on a.translator_id = b.translator_id";		
				$statement = $con->prepare($query);	
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['count'];
				
				$con =NULL;	
								
			}
			catch (PDOException $e) 
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
		    }
		return $count;		
		}
		
	    public function singleTranslatorDetails($translator_id)
		{	
			 $advocate = array();
		     $count = 0;	
			$con = Conn\Connection::getConnection();		
		
			$query = "SELECT a.translator_id as atid, a.translator_name,a.email_id, a.contactno1, a.contactno2,
					  a.lang_id, a.is_active as advactive,a.gender,
					  b.address1, b.address2, b.city, b.state, b.pincode, b.commun_name, b.is_commun_address,c.lang_name
					  FROM tbl_translator a
					  full JOIN tbl_translator_address b ON a.translator_id = b.translator_id full JOIN tbl_translator_language c on a.lang_id =c.id
					  WHERE a.translator_id  = :translator_id";
			$statement = $con->prepare($query);
			$statement->bindValue(':translator_id', $translator_id, \PDO::PARAM_INT);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				{
				$advocate[$count]['translator_id']    = $row['atid'];
				$advocate[$count]['translator_name']  = $row['translator_name'];
				$advocate[$count]['email_id']         = $row['email_id'];
				$advocate[$count]['contactno1']       = $row['contactno1'];
				$advocate[$count]['contactno2']       = $row['contactno2'];
				$advocate[$count]['lang_name']        = $row['lang_name'];
				$advocate[$count]['lang_id']        = $row['lang_id'];
				//$advocate[$count]['is_active']       = $row['advactive'];
				
				$advocate[$count]['gender']          = $row['gender'];
				$advocate[$count]['address1']        = $row['address1'];
				$advocate[$count]['address2']        = $row['address2'];
				$advocate[$count]['city']            = $row['city'];
				$advocate[$count]['state']           = $row['state'];
				$advocate[$count]['pincode']         = $row['pincode'];
				$advocate[$count]['commun_name']     = $row['commun_name'];
				$advocate[$count]['is_commun_address'] = $row['is_commun_address'];
				//$advocate[$count]['start_date'] = $row['start_date'];
				//$advocate[$count]['end_date'] = $row['end_date'];
				//$advocate[$count]['is_active'] = $row['advactivestate'];
				$count++;			
			}
			return $advocate;
		}	
		
		
		public function translatorPeriod($translatorId)
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT start_date, end_date, is_active FROM tbl_translator_period
					  WHERE translator_id = :translatorId";
			$statement = $con->prepare($query);
			$statement->bindValue(':translatorId', $translatorId, \PDO::PARAM_INT);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$advocate[$count]['start_date']      = $row['start_date'];
				$advocate[$count]['end_date']        = $row['end_date'];
				$advocate[$count]['is_active']       = $row['is_active'];
				$count++;
			}
			return $advocate;
		}
		
		public function TranslatorRegPeriod($translatorId)
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT start_date, end_date, is_active FROM tbl_translator_period
					  WHERE translator_id = :translatorId AND is_active IS TRUE";
			$statement = $con->prepare($query);
			$statement->bindValue(':translatorId', $translatorId, \PDO::PARAM_INT);
			$statement->execute();
			
			return $statement->fetchAll();		
		}
		public function TranslatortimePeriod()
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT a.start_date, b.translator_id, b.translator_name, b.email_id,
		    		 b.contactno1 FROM tbl_translator_period a full JOIN tbl_translator b ON a.translator_id = b.translator_id
					  WHERE a.end_date IS NULL AND a.is_active IS TRUE";
			$statement = $con->prepare($query);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$advocate[$count]['start_date']      = $row['start_date'];
				$advocate[$count]['translator_id']    = $row['translator_id'];
				$advocate[$count]['translator_name']  = $row['translator_name'];
				$advocate[$count]['email_id']         = $row['email_id'];
				$advocate[$count]['contactno1']       = $row['contactno1'];
				$count++;
			}
			//echo $advocate[$count]['start_date'];exit;
				
			return $advocate;
		}
		
		
		public function getTranslatorList()
		{
			$translator = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT translator_id, translator_name, medium_code FROM tbl_translator
					  WHERE is_active IS TRUE ORDER BY last_appt";
			$statement = $con->prepare($query);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$translator[$count]['translator_id']   = $row['translator_id'];
				$translator[$count]['translator_name'] = $row['translator_name'];
				$translator[$count]['medium_code']     = $row['medium_code'];
				$count++;
			}
				
			return $translator;
		}
		
		
		public function getTranslatorOnPannel($limit,$start)
		{
			$count = 0;
			$flag=0;
			try
			{
				$con = Conn\Connection::getConnection();
				$query = "SELECT DISTINCT ON (trans.translator_id) trans.translator_id, trans.translator_name, trans.medium_code, trans.email_id,
		    		trans.contactno1, appTrans.appointment_date, appTrans.application_id, appli.diary_no
					FROM tbl_translator trans
				    JOIN tbl_application_translator appTrans on trans.translator_id = appTrans.translator_id
				    JOIN tbl_application  appli on appTrans.application_id = appli.id
					WHERE trans.is_active IS TRUE AND appTrans.is_active IS TRUE
				    ORDER BY trans.translator_id DESC, appTrans.id DESC LIMIT :limit OFFSET :offset";
				$statement = $con->prepare($query);
				$statement->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$statement->bindValue(':offset', $start, \PDO::PARAM_STR);
				$statement->execute();
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		public function getTranslatorOnPannelCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{
				$query = "SELECT COUNT(DISTINCT trans.translator_id) as count FROM tbl_translator trans
				    JOIN tbl_application_translator appTrans on trans.translator_id = appTrans.translator_id
				    JOIN tbl_application  appli on appTrans.application_id = appli.id
					WHERE trans.is_active IS TRUE AND appTrans.is_active IS TRUE";
				$statement = $con->prepare($query);
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['count'];
		
				$con =NULL;
		
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function searchTranslatorOnPannel($fromDate, $toDate, $translator_name, $limit, $start)
		{
			$count = 0;
			$flag=0;
			try
			{
				$fromDate = date("Y-m-d", strtotime($fromDate));
				$toDate = date("Y-m-d", strtotime($toDate));
			//	echo $fromDate.'===='.$toDate.'===='.$translator_name.'===='.$limit.'===='.$start; exit;
				$con = Conn\Connection::getConnection();
				$query = "SELECT DISTINCT ON (trans.translator_id) trans.translator_id, trans.translator_name, trans.medium_code,
		    	      COUNT(appTrans.translator_id) count
					FROM tbl_translator trans
				    JOIN tbl_application_translator  appTrans on trans.translator_id = appTrans.translator_id					
                    WHERE trans.is_active IS TRUE AND appTrans.is_active IS TRUE				    
				    AND  (appTrans.appointment_date BETWEEN :fromDate AND :toDate)";
		
				if($translator_name!=0)
				{
					$query.=" AND appTrans.translator_id=:translator_id";
				}
		
				$query.=" GROUP BY appTrans.translator_id, trans.translator_name, trans.translator_id
				    		ORDER BY trans.translator_id DESC LIMIT :limit OFFSET :offset";
				$statement = $con->prepare($query);
				$statement->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$statement->bindValue(':toDate', $toDate, \PDO::PARAM_STR);
				$statement->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$statement->bindValue(':offset', $start, \PDO::PARAM_STR);
		
				if($translator_name!=0)
				{
					$statement->bindValue(':translator_id', $translator_name, \PDO::PARAM_INT);
				}
		
				$statement->execute();
		
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		public function searchTranslatorOnPannelCount($fromDate, $toDate, $translator_name)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;			
			try
			{
				$fromDate = date("Y-m-d", strtotime($fromDate));
				$toDate = date("Y-m-d", strtotime($toDate));
				
				$query = "SELECT COUNT(DISTINCT trans.translator_id) as count
					FROM tbl_translator trans
				    JOIN tbl_application_translator appTrans on trans.translator_id = appTrans.translator_id
					WHERE trans.is_active IS TRUE AND appTrans.is_active IS TRUE
						AND (appTrans.appointment_date BETWEEN :fromDate AND :toDate)";
		
			if($translator_name!=0)
				{
					$query.=" AND appTrans.translator_id=:translator_id";
				}
		
				$statement = $con->prepare($query);
				$statement = $con->prepare($query);
			$statement = $con->prepare($query);
				$statement->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$statement->bindValue(':toDate', $toDate, \PDO::PARAM_STR);			
		
				if($translator_name!=0)
				{
					$statement->bindValue(':translator_id', $translator_name, \PDO::PARAM_INT);
				}
				
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['count'];
		
				$con =NULL;
		
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function singleTranslatorOnPannel($translator_id)
		{
			$count = 0;
			$flag=0;
			try
			{
				$con = Conn\Connection::getConnection();
				$query = "SELECT trans.translator_id, trans.translator_name, trans.medium_code, trans.email_id,
		    		trans.contactno1, appTrans.appointment_date, appTrans.application_id, appli.diary_no
					FROM tbl_translator trans
				    JOIN tbl_application_translator  appTrans on trans.translator_id = appTrans.translator_id
				    JOIN tbl_application  appli on appTrans.application_id = appli.id
					WHERE trans.is_active IS TRUE AND appTrans.is_active IS TRUE
					AND appTrans.translator_id = :translator_id
				    ORDER BY trans.translator_id DESC, appTrans.id DESC";
				$statement = $con->prepare($query);
				$statement->bindValue(':translator_id', $translator_id, \PDO::PARAM_INT);
				$statement->execute();
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		
			public function getAllSearchTranslator($reg_date, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			$reg_date = (date('Y-m-d',strtotime($reg_date)));
			try{
				$query ="SELECT a.start_date,b.translator_id, b.translator_name, b.email_id,
					  b.contactno1 FROM tbl_translator_period a full JOIN tbl_translator b ON a.translator_id = b.translator_id
					   WHERE a.start_date = :reg_date AND a.end_date IS NULL AND a.is_active IS TRUE
						ORDER BY a.translator_id DESC LIMIT :limit OFFSET :offset ";
		
		
		
				$stmt = $con->prepare($query);
				$stmt->execute(array('reg_date' => $reg_date,'limit'=>$limit,'offset'=>$start));
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
				
		}
		public function getAllSearchTranslatorCount($reg_date)
		{
				
			$count = 0;
			$con = Conn\Connection::getConnection();
			$reg_date = (date('Y-m-d',strtotime($reg_date)));
			try{
				$query = "SELECT count(id) FROM tbl_translator_period a
						full JOIN tbl_translator b ON a.translator_id = b.translator_id
						 WHERE a.start_date = :reg_date AND a.end_date IS NULL AND a.is_active IS TRUE";
		
					
				$stmt = $con->prepare($query);
				//$stmt->bindValue(':diary_no', '%'.$diary_no.'%', \PDO::PARAM_STR);
				$stmt->execute(array('reg_date' => $reg_date));
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['count'];
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		

	}
?>