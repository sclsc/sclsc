<?php
	namespace classes\Implementation\ClosingOfFile;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ClosingOfFile/Fetchable.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Constant.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ClosingOfFile as IFetch;
	use classes\Implementation\Misc as CFetch;
	
	class Fetch extends CFetch\Constant implements IFetch\Fetchable
	{

	public function getMiscApplicationDetails($stageId, $subStageId, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
		try{
				$currDate = date("Y-m-d");
				$appli_type_id = 30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name,
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_application_status g on b.id=g.application_id
						WHERE b.appli_type_id = :appli_type_id AND g.stage_id = :stage_id 
						AND g.sub_stage_id = :sub_stage_id AND g.is_active = :is_active
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getMiscApplicationCount($stageId, $subStageId)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
		try{
				$currDate = date("Y-m-d");
				$appli_type_id =30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name,
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_application_status g on b.id=g.application_id
						WHERE b.appli_type_id = :appli_type_id AND g.stage_id = :stage_id 
						AND g.sub_stage_id = :sub_stage_id AND g.is_active = :is_active
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$count = $stmt->rowCount();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		public function getAllApplicationDetails($stageId, $subStageId, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$currDate = date("Y-m-d");
				$appli_type_id = 30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name,
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_application_status g on b.id=g.application_id
						WHERE b.appli_type_id!= :appli_type_id AND g.stage_id = :stage_id
						AND g.sub_stage_id = :sub_stage_id AND g.is_active = :is_active
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getAllApplicationCount($stageId, $subStageId)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$currDate = date("Y-m-d");
				$appli_type_id =30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name,
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_application_status g on b.id=g.application_id
						WHERE b.appli_type_id!= :appli_type_id AND g.stage_id = :stage_id
						AND g.sub_stage_id = :sub_stage_id AND g.is_active = :is_active
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$count = $stmt->rowCount();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}

		public function getApplicationDetails($applicationId)
		{
			
			$con = Conn\Connection::getConnection();
			try{
				$query="select a.id appli_type_id, a.appli_type_name,
						b.diary_no, b.received_date,b.uid_application_through,
						c.id through_id, c.appli_through_name,c.appli_through_type_id,
						d.id applicant_id, d.applicant_name,g.applicant_address_line1, 
					    d.applicant_contact_no, d.applicant_mobile_no, d.applicant_email_id,
						e.active_date,
						f.id stage_id, f.stage_name, 
						g.applicant_address_line2, g.applicant_city, g.applicant_state, g.applicant_pincode,
						adv.id advocate_id, adv.advocate_name,
						appadv.appointment_date, appadv.is_sr_advocate,
						aid.legal_aid_grant_no,
						sc.case_type_name,
						scapp.id case_type_id, scapp.sc_case_type_id, scapp.case_number, scapp.case_year, 
						scapp.petitioner, scapp.respondent, scapp.date_of_filing
						from tbl_application_types a full join tbl_application b on a.id=b.appli_type_id
						full join tbl_appli_through c on b.uid_application_through=c.id
						full join tbl_applicants d on b.id=d.application_id
						full join tbl_application_status e on b.id=e.application_id
						full join tbl_stages f on f.id=e.stage_id
					    full join tbl_applicant_address g on g.applicant_id=d.id
						full join tbl_application_advocate appadv on appadv.application_id=b.id
						full join tbl_advocates adv on appadv.advocate_id=adv.id
						full join tbl_legal_aid_in_appli aid on aid.application_id=b.id
						full join tbl_sc_case_detail_in_appli scapp on scapp.application_id=b.id
						full join tbl_sc_case_type sc on sc.id=scapp.sc_case_type_id 
						WHERE b.id=:application_id AND e.is_active=TRUE
						ORDER BY e.id DESC";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getApplicats($applicationId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT id, applicant_name FROM tbl_applicants 
						WHERE application_id=:application_id ORDER BY id ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
			public function getThroughType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through_type";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getSrAdvocateDetails($applicationId)
		{
			$con = Conn\Connection::getConnection();
			try{
		
				$query="select sradv.id, sradv.sr_advocate_name, appadv.appointment_date
					    from tbl_application b 
						full join tbl_application_advocate appadv on appadv.application_id=b.id
					    full join tbl_sr_advocate sradv on appadv.advocate_id=sradv.id 
						where b.id=:application_id AND appadv.is_sr_advocate=true ";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getApplicantDetails($applicant_id)
		{
			$con = Conn\Connection::getConnection();
			$applicantDetails = array();
			try{
				$query="SELECT
							 a.applicant_name,
							 d.applicant_address_line1,
							 d.applicant_address_line2,
							 d.applicant_city,
							 d.applicant_state,
							 d.applicant_pincode,
							 a.applicant_contact_no,
							 a.applicant_mobile_no,
							 a.applicant_email_id,
							 a.applicant_age,
							 a.applicant_d_o_b,
							 a.applicant_father_name
							 FROM tbl_applicants a
							 FULL JOIN tbl_applicant_address d
							 ON a.id = d.applicant_id
							 where a.id = :applicant_id ";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$applicantDetails['applicant_name'] = $row['applicant_name'];
					$applicantDetails['applicant_address_line1'] = $row['applicant_address_line1'];
					$applicantDetails['applicant_address_line2'] = $row['applicant_address_line2'];
					$applicantDetails['applicant_city'] = $row['applicant_city'];
					$applicantDetails['applicant_state'] = $row['applicant_state'];
					$applicantDetails['applicant_pincode'] = $row['applicant_pincode'];
					$applicantDetails['applicant_contact_no'] = $row['applicant_contact_no'];
					$applicantDetails['applicant_mobile_no'] = $row['applicant_mobile_no'];
					$applicantDetails['applicant_email_id'] = $row['applicant_email_id'];
					$applicantDetails['applicant_age'] = $row['applicant_age'];
					$applicantDetails['applicant_d_o_b'] = $row['applicant_d_o_b'];
					$applicantDetails['applicant_father_name'] = $row['applicant_father_name'];		
				}
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $applicantDetails;
		}
		
		public function getApplicantJailInfo($applicant_id)
		{
			$con = Conn\Connection::getConnection();
			$applicantDetails = array();
			try{
				$query="SELECT a.convict_no, a.jail_id, b.appli_through_name, b.state
						from tbl_applicant_jail a
						FULL JOIN tbl_appli_through b ON a.jail_id=b.id
						WHERE a.applicant_id = :applicant_id ";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$applicantDetails['jail_convict_no'] = $row['convict_no'];
					$applicantDetails['jail_id'] = $row['jail_id'];
					$applicantDetails['appli_through_name'] = $row['appli_through_name'];
					$applicantDetails['custody_state'] = $row['state'];
				}
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $applicantDetails;
		}
		
		public function getEligibilities($applicant_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT eli.eligibility_id,con.eligibility_condition 
						FROM tbl_applicant_eligibility eli JOIN tbl_eligibility_conditions con ON con.id = eli.eligibility_id 
						WHERE eli.applicant_id = :applicant_id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getThroughDetails($throughId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT t.id,t.designation,t.appli_through_name,t.email_id,t.contact_no,t.address_line1,t.address_line2,t.city,
						s.state_name state,t.pincode,n.appli_through_type_name through_type
						 FROM tbl_appli_through t JOIN tbl_appli_through_type n ON n.id = t.appli_through_type_id
						JOIN tbl_states s ON s.id = t.state WHERE t.id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $throughId, \PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}
			
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getGeneratedLetter($applicationId)
		{
			$con = Conn\Connection::getConnection();
			$applicantDetails = array();
			try{
				$query="SELECT a.id, a.letter_type, a.letter_no, a.subject,						
						c.type_name							 					 
					    FROM tbl_letters_disp_in_appli a					    
				        JOIN tbl_letter_types c ON a.letter_type = c.id
					    WHERE a.application_id = :application_id ORDER BY id DESC";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();

				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getLetterAddresse($lettersDispId)
		{
			$con = Conn\Connection::getConnection();
			
			$applicantDetails = array();
			try{
				$query="SELECT id, letters_disp_id, applicant_id, addressee_name, address1, address2, city, state, pincode, is_to
						FROM tbl_letter_disp_addressee
						WHERE letters_disp_id = :letters_disp_id  OR id = :letters_disp_id";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':letters_disp_id', $lettersDispId, \PDO::PARAM_INT);
			//	$stmt->bindValue(':is_to', $is_to, \PDO::PARAM_BOOL);
				$stmt->execute();
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getLetterAddresseTo($lettersDispId)
		{
			$con = Conn\Connection::getConnection();
			$is_to =TRUE;
			$count = 0;
			try{
				$query="SELECT applicant_id FROM tbl_letter_disp_addressee 
						WHERE is_to = :is_to AND (letters_disp_id = :letters_disp_id  OR id = :letters_disp_id)";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':letters_disp_id', $lettersDispId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_to', $is_to, \PDO::PARAM_BOOL);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$applicantId[$count] = $row['applicant_id'];
					$count++;
				}
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $applicantId;
		}
		
		public function getLetterAddresseCopyTo($lettersDispId)
		{
			$con = Conn\Connection::getConnection();
			$is_to =FALSE;
			$applicantDetails = array();
		try{
				$query="SELECT applicant_id FROM tbl_letter_disp_addressee 
						WHERE is_to = :is_to AND (letters_disp_id = :letters_disp_id  OR id = :letters_disp_id)";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':letters_disp_id', $lettersDispId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_to', $is_to, \PDO::PARAM_BOOL);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$applicantId[$count] = $row['applicant_id'];
					$count++;
				}
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $applicantId;
		}
		
		public function getMiscApplicationReminder($stageId, $subStageId, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$currDate = date("Y-m-d");
				$appli_type_id = 30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name,
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_application_status g on b.id=g.application_id
						WHERE b.appli_type_id = :appli_type_id AND g.stage_id = :stage_id
						AND g.sub_stage_id = :sub_stage_id AND g.is_active = :is_active
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC
						 LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getApplication($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$is_active=TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, a.appli_type_name, b.diary_no, b.received_date, 
						d.applicant_name, c.stage_id, s.stage_name, s.stage_page
						FROM tbl_application_types a
						JOIN tbl_application b ON a.id=b.appli_type_id
						JOIN tbl_applicants d ON b.id=d.application_id
						JOIN tbl_application_status c ON b.id=c.application_id
						JOIN tbl_stages s ON s.id=c.sub_stage_id OR s.id=c.stage_id	
						WHERE c.is_active=:is_active										
						ORDER BY  b.id, b.diary_no asc, d.id asc LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getApplicationCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{				
				$is_active=TRUE;
				$query = "SELECT DISTINCT ON (b.id) b.id, a.appli_type_name, b.diary_no, b.received_date, 
						d.applicant_name, c.stage_id, s.stage_name, s.stage_page
						FROM tbl_application_types a
						JOIN tbl_application b ON a.id=b.appli_type_id
						JOIN tbl_applicants d ON b.id=d.application_id
						JOIN tbl_application_status c ON b.id=c.application_id
						JOIN tbl_stages s ON s.id=c.sub_stage_id	
						WHERE c.is_active=:is_active						
						ORDER BY  b.id, b.diary_no asc, d.id asc";		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				$count++;
				$con =NULL;
		
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
		}
		return $count;
		}
		
		
		public function letterReminderStatus($application_id, $stage_id)
		{			
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{			
				
				$query = "SELECT letter_no, parent_letter_no, dispatch_date, reminder_status
						FROM tbl_letter_reminder_status						
						WHERE application_id=:application_id AND stage_id =:stage_id ORDER BY id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();				
				$con =NULL;		
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();;
		}
		
		
	 public function allApplicationDoc($application_id)
		{
			
			$count = 0;
			try
			{
				$is_active =TRUE;
				$con = Conn\Connection::getConnection();
				$query = "SELECT COUNT(id) as count FROM tbl_application_doc 
						WHERE application_id = :application_id AND is_active = :is_active";
				$statement = $con->prepare($query);
				$statement->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
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
		
		
		public function getApplicationReminderDoc($stageId, $subStageId, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			try{				
				$waitingDays    = self::WAITING_DATE;
				$reGenerateDays = self::REGENERATE_DATE;
				$waitingDate    = $NewDate=Date('Y-m-d', strtotime("-$waitingDays days"));
				$reGenerateDate = $NewDate=Date('Y-m-d', strtotime("-$reGenerateDays days"));
				$appli_type_id  = 30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date						
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id					
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appli.appli_type_id!= :appli_type_id AND appliStatus.stage_id = :stage_id
						AND appliStatus.sub_stage_id = :sub_stage_id AND appliStatus.is_active = :is_active
						AND ldin.dispatch_date <= :waitingDate
												
						UNION
												
						SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date								
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id					
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appli.appli_type_id!= :appli_type_id AND appliStatus.stage_id = :stage_id
						AND appliStatus.sub_stage_id = :sub_stage_id AND appliStatus.is_active = :is_active
						AND ldin.dispatch_date <= :reGenerateDate
												
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->bindValue(':waitingDate', $waitingDate, \PDO::PARAM_STR);
				$stmt->bindValue(':reGenerateDate', $reGenerateDate, \PDO::PARAM_STR);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getApplicationReminderDocCount($stageId, $subStageId)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$waitingDays    = self::WAITING_DATE;
				$reGenerateDays = self::REGENERATE_DATE;
				$waitingDate    = $NewDate=Date('Y-m-d', strtotime("-$waitingDays days"));
				$reGenerateDate = $NewDate=Date('Y-m-d', strtotime("-$reGenerateDays days"));
				$appli_type_id =30;
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date						
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id					
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appli.appli_type_id!= :appli_type_id AND appliStatus.stage_id = :stage_id
						AND appliStatus.sub_stage_id = :sub_stage_id AND appliStatus.is_active = :is_active
						AND ldin.dispatch_date <= :waitingDate
												
						UNION
												
						SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date								
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id					
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appli.appli_type_id!= :appli_type_id AND appliStatus.stage_id = :stage_id
						AND appliStatus.sub_stage_id = :sub_stage_id AND appliStatus.is_active = :is_active
						AND ldin.dispatch_date <= :reGenerateDate";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stageId, \PDO::PARAM_INT);
				$stmt->bindValue(':sub_stage_id', $subStageId, \PDO::PARAM_INT);
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
				$stmt->bindValue(':waitingDate', $waitingDate, \PDO::PARAM_STR);
				$stmt->bindValue(':reGenerateDate', $reGenerateDate, \PDO::PARAM_STR);
				$stmt->execute();
				
				$count = $stmt->rowCount();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		public function applicantCompletedDoc($application_id, $applicant_id)
		{				
			$count = 0;
			try
			{
				$is_active =TRUE;
				$con = Conn\Connection::getConnection();
				$query = "SELECT COUNT(id) as count FROM tbl_application_doc
						WHERE application_id =:application_id AND applicant_id =:applicant_id AND is_active =:is_active";
				$statement = $con->prepare($query);
				$statement->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$statement->bindValue(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$statement->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);
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
		
		
		public function primaFacieReply($application_id, $stage_id)
		{
			$count = 0;
			try
			{
				$is_active =TRUE;
				$con = Conn\Connection::getConnection();
				$query="SELECT is_in_favour, secretary_order
				FROM tbl_opinions_in_requests				
				WHERE application_id =:application_id AND stage_id =:stage_id AND is_active IS TRUE";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$primaFacieReply['is_in_favour'] = $row['is_in_favour'];
					$primaFacieReply['secretary_order'] = $row['secretary_order'];					
				}
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $primaFacieReply;
		}
		
		
		public function getDispatchApplications($limit, $start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appliStatus.sub_stage_id IN (9,19,23,27,31,36) 
						AND appliStatus.is_active = :is_active		
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);				
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);				
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getDispatchApplicationsCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				
				$is_active =TRUE;
				$query = "SELECT DISTINCT ON (appli.id) appli.id, appli.diary_no, appli.appli_type_id,
			            appliType.appli_type_name,
						applicant.applicant_name,
						ldin.dispatch_date
						FROM tbl_application_types appliType join tbl_application appli on appliType.id=appli.appli_type_id
						JOIN tbl_applicants applicant on appli.id=applicant.application_id
						JOIN tbl_application_status appliStatus on appli.id=appliStatus.application_id
						JOIN tbl_letters_disp_in_appli ldin on appli.id=ldin.application_id
						WHERE appliStatus.sub_stage_id IN (9,19,23,27,31,36) 
						AND appliStatus.is_active = :is_active";
				$stmt = $con->prepare($query);			
				$stmt->bindValue(':is_active', $is_active, \PDO::PARAM_BOOL);			
				$stmt->execute();		
				$count = $stmt->rowCount();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function getDispatchAddressee($application_id)
		{
			$con = Conn\Connection::getConnection();	
			$addresseeDetails=array();
			try{
				$query="SELECT id, addressee_name, address1, city, stage_id, applicant_id, application_id
						from tbl_letter_disp_addressee 
						WHERE application_id =:application_id AND is_dispatch IS FALSE";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->execute();
				
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function singleDispatchAddressee($application_id, $applicant_id, $stage_id)
		{
			$con = Conn\Connection::getConnection();
			$addresseeDetails=array();
			try{
				$query="SELECT id, addressee_name, address1, address1, city, state, pincode
						from tbl_letter_disp_addressee WHERE application_id =:application_id 
						AND applicant_id =:applicant_id AND stage_id =:stage_id";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->bindValue(':applicant_id', $applicant_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getApplicationStatus($application_id)
		{
			$con = Conn\Connection::getConnection();
			$addresseeDetails=array();
			try{
				$query="SELECT stage_id, sub_stage_id
						from tbl_application_status
						WHERE application_id =:application_id AND is_active IS TRUE";		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$applicationStatus['stage_id']     = $row['stage_id'];
					$applicationStatus['sub_stage_id'] = $row['sub_stage_id'];					
				}
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $applicationStatus;
		}
		
		public function dispatchAddresseeCount($application_id, $stage_id)
		{
			$con = Conn\Connection::getConnection();
			$addresseeDetails=array();
			try{
				$query="SELECT id from tbl_letter_disp_addressee
						WHERE application_id =:application_id AND stage_id =:stage_id AND is_dispatch IS FALSE";
		
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->execute();
				$count = $stmt->rowCount();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $count;
		}
		
		
		public function getApplicationTranslator($applicationId)
		{
			
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT t.translator_id, t.translator_name FROM tbl_translator as t
						JOIN tbl_application_translator at ON t.translator_id = at.translator_id 
						WHERE at.application_id=:application_id AND at.is_active IS TRUE ORDER BY at.id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getApplicationAdvocate($applicationId)
		{
				
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT adv.id, adv.advocate_name FROM tbl_advocates as adv
						JOIN tbl_application_advocate appAdv ON adv.id = appAdv.advocate_id
						WHERE appAdv.application_id=:application_id AND appAdv.is_active IS TRUE ORDER BY appAdv.id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
  }
?>