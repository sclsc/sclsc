<?php
	namespace classes\Implementation\Advocate;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Advocate/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Advocate as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
	
	public function getAllAdvocates($limit,$start)
		{			
			$count = 0;
			$flag=0;
			try 
			{
			$con = Conn\Connection::getConnection();				
		    $query = "SELECT DISTINCT ON (a.id) a.id, a.advocate_name, a.advocate_code, a.email_id,
		    		 a.contact_no1, a.is_on_panel, a.is_active, b.start_date FROM tbl_advocates a 
				     FULL JOIN tbl_advocate_period  b on a.id = b.advocates_id 
				     ORDER BY a.id DESC LIMIT :limit OFFSET :offset";
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
		
		public function getAllAdvocatesCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{				
				$query = "SELECT COUNT(DISTINCT a.id) as count FROM tbl_advocates a 
				     FULL JOIN tbl_advocate_period  b on a.id = b.advocates_id";		
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
		
	    public function singleAvocateDetails($advocateId)
		{	
			 $advocate = array();
		     $count = 0;	
			$con = Conn\Connection::getConnection();	
			$query = "SELECT a.id, a.advocate_name, a.advocate_code, a.email_id, a.contact_no1, a.contact_no2,
					  a.advocate_enrol_date, a.enrolled_bar, a.scba_enrol_date, a.scba_enrol_date, a.aor_desig_date,
					  a.language, a.is_active advactive, a.is_on_panel, a.is_aor, a.gender,
					  b.address1, b.address2, b.city, b.state, b.pincode, b.commun_name, b.is_commun_address
					  FROM tbl_advocates a
					  full JOIN tbl_adv_address b ON a.id = b.advocates_id 
					  WHERE a.id = :advocateId";
			$statement = $con->prepare($query);
			$statement->bindValue(':advocateId', $advocateId, \PDO::PARAM_INT);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				{
				$advocate[$count]['advocate_id']    = $row['id'];
				$advocate[$count]['advocate_name']  = $row['advocate_name'];
				$advocate[$count]['advocate_code']  = $row['advocate_code'];
				$advocate[$count]['email_id']       = $row['email_id'];
				$advocate[$count]['contact_no1']    = $row['contact_no1'];
				$advocate[$count]['contact_no2']    = $row['contact_no2'];
				$advocate[$count]['advocate_enrol_date'] = $row['advocate_enrol_date'];
				$advocate[$count]['enrolled_bar']    = $row['enrolled_bar'];
				$advocate[$count]['scba_enrol_date'] = $row['scba_enrol_date'];
				$advocate[$count]['aor_desig_date']  = $row['aor_desig_date'];
				$advocate[$count]['language']        = $row['language'];
				$advocate[$count]['is_active']       = $row['advactive'];
				$advocate[$count]['is_on_panel']     = $row['is_on_panel'];
				$advocate[$count]['is_aor']          = $row['is_aor'];
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
		
		
		public function avocatePeriod($advocateId)
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT start_date, end_date, is_active FROM tbl_advocate_period
					  WHERE advocates_id = :advocateId";
			$statement = $con->prepare($query);
			$statement->bindValue(':advocateId', $advocateId, \PDO::PARAM_INT);
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
		public function AdvocateRegPeriod($advocateId)
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT start_date, end_date, is_active FROM tbl_advocate_period 
					  WHERE advocates_id = :advocateId AND is_active IS TRUE";
			$statement = $con->prepare($query);
			$statement->bindValue(':advocateId', $advocateId, \PDO::PARAM_INT);
			$statement->execute();
			
			return $statement->fetchAll();		
		}
		
		public function AdvocatetimePeriod()
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT a.start_date,b.id, b.advocate_name, b.advocate_code, b.email_id, b.contact_no1 
					FROM tbl_advocate_period a full JOIN tbl_advocates b ON a.advocates_id = b.id 
					WHERE a.end_date IS NULL AND a.is_active IS TRUE";
			$statement = $con->prepare($query);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$advocate[$count]['start_date']      = $row['start_date'];
				$advocate[$count]['advocate_id']    = $row['id'];
				$advocate[$count]['advocate_name']  = $row['advocate_name'];
				$advocate[$count]['advocate_code']  = $row['advocate_code'];
				$advocate[$count]['email_id']       = $row['email_id'];
				$advocate[$count]['contact_no1']    = $row['contact_no1'];
				$count++;
			}	
			//echo $advocate[$count]['start_date'];exit;
			
			return $advocate;
		}
		
		public function getAdvocatesList()
		{
			$advocate = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT id, advocate_name, advocate_code FROM tbl_advocates
					  WHERE is_active IS TRUE ORDER BY last_appt";
			$statement = $con->prepare($query);
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$advocate[$count]['id']            = $row['id'];
				$advocate[$count]['advocate_name'] = $row['advocate_name'];
				$advocate[$count]['advocate_code'] = $row['advocate_code'];
				$count++;
			}
				
			return $advocate;
		}
		
		
		public function getAdvocatesOnPannel($limit,$start)
		{
			$count = 0;
			$flag=0;
			try
			{
				$con = Conn\Connection::getConnection();
				$query = "SELECT DISTINCT ON (adv.id) adv.id, adv.advocate_name, adv.advocate_code, adv.email_id,
		    		adv.contact_no1, appAdv.appointment_date, appAdv.application_id, appli.diary_no
					FROM tbl_advocates adv
				    JOIN tbl_application_advocate  appAdv on adv.id = appAdv.advocate_id
				    JOIN tbl_application  appli on appAdv.application_id = appli.id
					WHERE adv.is_active IS TRUE AND appAdv.is_active IS TRUE AND appAdv.is_sr_advocate IS FALSE
				    ORDER BY adv.id DESC, appAdv.id DESC LIMIT :limit OFFSET :offset";
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
		
		public function getAdvocatesOnPannelCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{
				$query = "SELECT COUNT(DISTINCT adv.id) as count FROM tbl_advocates adv
				      JOIN tbl_application_advocate  appAdv on adv.id = appAdv.advocate_id
						WHERE adv.is_active IS TRUE AND appAdv.is_active IS TRUE";
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
		
		
		
		public function searchAdvocatesOnPannel($fromDate, $toDate, $advocate_name, $limit, $start)
		{		
			$count = 0;
			$flag=0;
			try
			{
				$fromDate = date("Y-m-d", strtotime($fromDate));
			    $toDate = date("Y-m-d", strtotime($toDate));
			  //echo $fromDate.'===='.$toDate.'===='.$advocate_name.'===='.$limit.'===='.$start; exit;
				$con = Conn\Connection::getConnection();
				$query = "SELECT DISTINCT ON (adv.id) adv.id, adv.advocate_name, adv.advocate_code,
		    	      COUNT(appAdv.advocate_id) count
					FROM tbl_advocates adv
				    JOIN tbl_application_advocate  appAdv on adv.id = appAdv.advocate_id				    
					WHERE adv.is_active IS TRUE AND appAdv.is_active IS TRUE AND appAdv.is_sr_advocate IS FALSE
				    AND  (appAdv.appointment_date BETWEEN :fromDate AND :toDate)"; 
				
				if($advocate_name!=0)
				{
					$query.=" AND appAdv.advocate_id=:advocate_id";						
				}
				
				    $query.=" GROUP BY appAdv.advocate_id, adv.advocate_name, adv.id
				    		ORDER BY adv.id DESC LIMIT :limit OFFSET :offset";
				$statement = $con->prepare($query);
			    $statement->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$statement->bindValue(':toDate', $toDate, \PDO::PARAM_STR);	
				$statement->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$statement->bindValue(':offset', $start, \PDO::PARAM_STR);	

				if($advocate_name!=0)
				{
					$statement->bindValue(':advocate_id', $advocate_name, \PDO::PARAM_INT);
				}
				
				$statement->execute();
				
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		public function searchAdvocatesOnPannelCount($fromDate, $toDate, $advocate_name)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try
			{
				$fromDate = date("Y-m-d", strtotime($fromDate));
				$toDate = date("Y-m-d", strtotime($toDate));
				
				$query = "SELECT COUNT(DISTINCT adv.id) as rowCount 
					FROM tbl_advocates adv
				    JOIN tbl_application_advocate  appAdv on adv.id = appAdv.advocate_id				    
					WHERE adv.is_active IS TRUE AND appAdv.is_active IS TRUE AND appAdv.is_sr_advocate IS FALSE
						AND appAdv.appointment_date BETWEEN :fromDate AND :toDate"; 
						
				if($advocate_name!=0)
				{
					$query.=" AND appAdv.advocate_id=:advocate_id";						
				}				
				    
				$statement = $con->prepare($query);
				$statement = $con->prepare($query);
				$statement->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$statement->bindValue(':toDate', $toDate, \PDO::PARAM_STR);			
				
				if($advocate_name!=0)
				{
					$statement->bindValue(':advocate_id', $advocate_name, \PDO::PARAM_INT);
				}
				$statement->execute();
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$count = $row['rowCount'];
		
				$con =NULL;
		
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function singleAdvocatesOnPannel($advocate_id)
		{			
			$count = 0;
			$flag=0;
			try
			{
				$con = Conn\Connection::getConnection();
				$query = "SELECT adv.id, adv.advocate_name, adv.advocate_code, adv.email_id,
		    		adv.contact_no1, appAdv.appointment_date, appAdv.application_id, appli.diary_no
					FROM tbl_advocates adv
				    JOIN tbl_application_advocate  appAdv on adv.id = appAdv.advocate_id
				    JOIN tbl_application  appli on appAdv.application_id = appli.id
					WHERE adv.is_active IS TRUE AND appAdv.is_active IS TRUE AND appAdv.is_sr_advocate IS FALSE
					AND appAdv.advocate_id = :advocate_id	
				    ORDER BY adv.id DESC, appAdv.id DESC";
				$statement = $con->prepare($query);
				$statement->bindValue(':advocate_id', $advocate_id, \PDO::PARAM_INT);			
				$statement->execute();
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $statement->fetchAll();
		}
		
		
		public function getAllSearchAdvocate($reg_date, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			$reg_date = (date('Y-m-d',strtotime($reg_date)));
			try{
				$query ="SELECT a.start_date,b.id, b.advocate_name, b.advocate_code, b.email_id, b.contact_no1
						FROM tbl_advocate_period a full JOIN tbl_advocates b ON a.advocates_id = b.id
				        WHERE a.start_date = :reg_date AND a.end_date IS NULL AND a.is_active IS TRUE
						ORDER BY a.advocates_id DESC LIMIT :limit OFFSET :offset ";
		
		
				/*	$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
				 d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
				d.sender_city,s.state_name, d.pincode,d.recieved_through, u.user_name
				FROM tbl_diary d JOIN tbl_states s ON d.sender_state = s.id
				join tbl_diary_category c on c.id = d.category_id
				JOIN tbl_user u ON d.mark_to = u.id
				WHERE d.diary_no ILIKE :diary_no OR d.applicant ILIKE :diary_no OR d.letter_no ILIKE :diary_no
				OR d.subject ILIKE :diary_no OR d.contact_number ILIKE :diary_no OR d.sender_city ILIKE :diary_no
				ORDER BY d.id DESC LIMIT :limit OFFSET :offset";*/
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
		public function getAllSearchAdvocateCount($reg_date)
		{
				
			$count = 0;
			$con = Conn\Connection::getConnection();
			$reg_date = (date('Y-m-d',strtotime($reg_date)));
			try{
				$query = "SELECT count(*) FROM tbl_advocate_period a
						full JOIN tbl_advocates b ON a.advocates_id = b.id
						 WHERE a.start_date = :reg_date AND a.end_date IS NULL AND a.is_active IS TRUE";
		
				/*$query = "SELECT count(*) FROM tbl_diary d
				 WHERE d.diary_no ILIKE :diary_no OR d.applicant ILIKE :diary_no OR d.letter_no ILIKE :diary_no
				OR d.subject ILIKE :diary_no OR d.contact_number ILIKE :diary_no OR d.sender_city ILIKE :diary_no";*/
					
				//$query = "SELECT count(*) FROM tbl_diary";
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