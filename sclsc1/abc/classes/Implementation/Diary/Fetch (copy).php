<?php
	namespace classes\Implementation\Diary;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Diary/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Diary as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		
		public function getDiaryDetails($diaryId)
		{
			$con = Conn\Connection::getConnection();
			try{
				//$query = "SELECT * FROM tbl_diary WHERE id = :id";
				$query = "SELECT 
							d.id,
							d.diary_no,
							c.category_name,
							d.letter_no,
							d.applicant,
							d.recieved_date,
							d.subject,
							d.subject_desc,
							d.date_of_letter,
							d.sender_address1,
							d.sender_address2,
							d.sender_city,
							s.state_name,
							d.pincode,
							a.appli_through_name,
						    a.appli_through_type_id,
						    d.recieved_through,						    
							u.user_name,
							d.father_name,
							d.contact_number,
							d.sender_state,
							d.mail_id
							
						 FROM tbl_diary d 
						FULL JOIN tbl_states s ON d.sender_state = s.id
						FULL JOIN tbl_diary_category c on c.id = d.category_id
						FULL JOIN tbl_user u ON d.mark_to = u.id
						FULL JOIN tbl_appli_through a ON a.id = d.recieved_through
						WHERE d.id = :id ORDER BY d.id DESC ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $diaryId, \PDO::PARAM_STR);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
	
		public function getUserSpecificPendingDiary($limit,$start,$userId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT d.is_taken,d.id,d.diary_no,c.category_name,d.letter_no,d.applicant,
						d.recieved_date,d.subject,d.subject_desc,d.date_of_letter,
						d.sender_address1,d.sender_address2,d.sender_city,s.state_name,
						d.pincode,d.recieved_through,u.user_name
						FROM tbl_diary d 
						JOIN tbl_states s ON d.sender_state = s.id 
						join tbl_diary_category c on c.id = d.category_id 
						JOIN tbl_user u ON d.mark_to = u.id  
						WHERE d.mark_to = :mark_to AND is_taken = 'false'
						ORDER BY d.id DESC LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':mark_to', $userId, \PDO::PARAM_INT);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getUserSpecificPendingDiaryCount($userId)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$query = "SELECT count(*) count from tbl_diary 
						WHERE mark_to = :mark_to AND is_taken = 'false' ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':mark_to', $userId, \PDO::PARAM_INT);
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
		
		
		public function getTodaysDiary($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			$recievedDate = date('Y-m-d');
			try{
				$query = "SELECT d.id,d.diary_no,c.category_name,d.letter_no,d.applicant,d.recieved_date,
			d.subject,d.subject_desc,d.date_of_letter,d.sender_address1,d.sender_address2,d.sender_city,
			s.state_name,d.pincode,d.recieved_through,u.user_name FROM tbl_diary d 
			JOIN tbl_states s ON d.sender_state = s.id 
			join tbl_diary_category c on c.id = d.category_id 
			JOIN tbl_user u ON d.mark_to = u.id 
			where d.recieved_date = :recieved_date  ORDER BY d.id DESC LIMIT :limit OFFSET :offset";				
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
				$stmt->bindValue(':recieved_date', $recievedDate, \PDO::PARAM_STR);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getTodaysDiaryCount()
		{
			$count = 0;
			$con = Conn\Connection::getConnection();
			$recievedDate = date('Y-m-d');
			try{
				$query = "SELECT count(*) FROM tbl_diary where recieved_date = :recieved_date";				
				$stmt = $con->prepare($query);
				$stmt->bindValue(':recieved_date', $recievedDate, \PDO::PARAM_STR);
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
		
		
		public function getAllDiary($limit,$start)
		{
			$con = Conn\Connection::getConnection();			
			try{
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city,s.state_name, d.pincode,d.recieved_through, u.user_name
						FROM tbl_diary d JOIN tbl_states s ON d.sender_state = s.id
						join tbl_diary_category c on c.id = d.category_id
						JOIN tbl_user u ON d.mark_to = u.id  ORDER BY d.id DESC LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);				
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getAllDiaryCount()
		{
			$count = 0;
			$con = Conn\Connection::getConnection();
			$recievedDate = date('Y-m-d');
			try{				
				$query = "SELECT count(*) FROM tbl_diary";
				$stmt = $con->prepare($query);				
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
		
		
		public function getAllSearchDiary($diary_no, $limit, $start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city,s.state_name, d.pincode,d.recieved_through, u.user_name
						FROM tbl_diary d JOIN tbl_states s ON d.sender_state = s.id
						join tbl_diary_category c on c.id = d.category_id
						JOIN tbl_user u ON d.mark_to = u.id  
						WHERE d.diary_no ILIKE :diary_no OR d.applicant ILIKE :diary_no OR d.letter_no ILIKE :diary_no
						OR d.subject ILIKE :diary_no OR d.contact_number ILIKE :diary_no OR d.sender_city ILIKE :diary_no
						ORDER BY d.id DESC LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->execute(array('diary_no' => '%'.$diary_no.'%','limit'=>$limit,'offset'=>$start));
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getAllSearchDiaryCount($diary_no)
		{
			$count = 0;
			$con = Conn\Connection::getConnection();
			$recievedDate = date('Y-m-d');
			try{
				$query = "SELECT count(*) FROM tbl_diary d
						WHERE d.diary_no ILIKE :diary_no OR d.applicant ILIKE :diary_no OR d.letter_no ILIKE :diary_no
						OR d.subject ILIKE :diary_no OR d.contact_number ILIKE :diary_no OR d.sender_city ILIKE :diary_no";
						
				//$query = "SELECT count(*) FROM tbl_diary";
				$stmt = $con->prepare($query);
				//$stmt->bindValue(':diary_no', '%'.$diary_no.'%', \PDO::PARAM_STR);
			$stmt->execute(array('diary_no' => '%'.$diary_no.'%'));
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

		public function getDateSpecificDiary(
				$fromDate,
				$toDate,
				$category,
				$receivedThrough,
				$state,
				$limit,
				$start )
		{
				
			$fromDate = date("Y-m-d", strtotime($fromDate));
			$toDate = date("Y-m-d", strtotime($toDate));
			
			$count = 0;
			$diary =array();
			try{
				$con = Conn\Connection::getConnection();
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city, s.state_name, d.pincode, d.recieved_through, u.user_name 
						FROM tbl_diary d JOIN tbl_states s ON d.sender_state = s.id 
						join tbl_diary_category c on c.id = d.category_id 
						JOIN tbl_user u ON d.mark_to = u.id 
						where recieved_date between :fromDate AND :toDate AND category_id = :category 
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$stmt->bindValue(':toDate', $toDate, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
		
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$diary[$count]['recieved_date'] = $row['recieved_date'];
					$diary[$count]['letter_no'] = $row['letter_no'];
					$diary[$count]['date_of_letter'] = $row['date_of_letter'];
					$diary[$count]['applicant'] = $row['applicant'];
					$diary[$count]['subject'] = $row['subject'];
					$diary[$count]['subject_desc'] = $row['subject_desc'];
					$diary[$count]['sender_city'] = $row['sender_city'];
					$diary[$count]['sender_state'] = $row['state_name'];
					$diary[$count]['sender_address1'] = $row['sender_address1'];
					$diary[$count]['sender_address2'] = $row['sender_address2'];
					$diary[$count]['pincode'] = $row['pincode'];
					$diary[$count]['category_id'] = $row['category_name'];
					$diary[$count]['diary_no'] = $row['diary_no'];
					$diary[$count]['recieved_through'] = $row['recieved_through'];
					$diary[$count]['mark_to'] = $row['user_name'];
					$diary[$count]['id'] = $row['id'];
					$count++;
				}
				//print_r($diary);
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $diary;
		}
		public function getDateSpecificDiaryCount(
				$fromDate,
				$toDate,
				$category,
				$receivedThrough,
				$state )
		{
		
			$fromDate = date("Y-m-d", strtotime($fromDate));
			$toDate = date("Y-m-d", strtotime($toDate));
			//echo "from date = :".$fromDate." todate = :".$toDate;
		
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$query = "SELECT count(*) count FROM tbl_diary 
						where recieved_date between :fromDate AND :toDate AND category_id = :category ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':fromDate', $fromDate, \PDO::PARAM_STR);
				$stmt->bindValue(':toDate', $toDate, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
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
		public function getSpecificDiary($dailyDate,$category,$limit,$start)
		{
		
			$fromDate = date("Y-m-d", strtotime($dailyDate));
				
			$con = Conn\Connection::getConnection();
			$count = 0;
			$diary =array();
			try{
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city, s.state_name, d.pincode, d.recieved_through, u.user_name 
						FROM tbl_diary d 
						JOIN tbl_states s ON d.sender_state = s.id 
						join tbl_diary_category c on c.id = d.category_id 
						JOIN tbl_user u ON d.mark_to = u.id 
						where recieved_date = :dailyDate AND category_id = :category LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':dailyDate', $dailyDate, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
		
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$diary[$count]['recieved_date'] = $row['recieved_date'];
					$diary[$count]['letter_no'] = $row['letter_no'];
					$diary[$count]['date_of_letter'] = $row['date_of_letter'];
					$diary[$count]['applicant'] = $row['applicant'];
					$diary[$count]['subject'] = $row['subject'];
					$diary[$count]['subject_desc'] = $row['subject_desc'];
					$diary[$count]['sender_city'] = $row['sender_city'];
					$diary[$count]['sender_state'] = $row['state_name'];
					$diary[$count]['sender_address1'] = $row['sender_address1'];
					$diary[$count]['sender_address2'] = $row['sender_address2'];
					$diary[$count]['pincode'] = $row['pincode'];
					$diary[$count]['category_id'] = $row['category_name'];
					$diary[$count]['diary_no'] = $row['diary_no'];
					$diary[$count]['recieved_through'] = $row['recieved_through'];
					$diary[$count]['mark_to'] = $row['user_name'];
					$diary[$count]['id'] = $row['id'];
					$count++;
				}
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $diary;
		}
		public function getSpecificDiaryCount($dailyDate,$category)
		{
		
			$fromDate = date("Y-m-d", strtotime($dailyDate));
		
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$query = "SELECT count(*) count FROM tbl_diary 
						where recieved_date = :dailyDate AND category_id = :category ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':dailyDate', $dailyDate, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
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
		public function getMonthlyDiary($month,$year,$category,$limit,$start)
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			$diary =array();
			try{
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject, d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city, s.state_name, d.pincode, d.recieved_through, u.user_name 
						FROM tbl_diary d 
						JOIN tbl_states s ON d.sender_state = s.id 
						join tbl_diary_category c on c.id = d.category_id 
						JOIN tbl_user u ON d.mark_to = u.id where EXTRACT(MONTH FROM recieved_date) = :month 
						AND EXTRACT(YEAR FROM recieved_date) = :year AND category_id = :category 
						LIMIT :limit OFFSET :offset";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':month', $month, \PDO::PARAM_STR);
				$stmt->bindValue(':year', $year, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
				$stmt->bindValue(':limit', $limit, \PDO::PARAM_STR);
				$stmt->bindValue(':offset', $start, \PDO::PARAM_STR);
		
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$diary[$count]['recieved_date'] = $row['recieved_date'];
					$diary[$count]['letter_no'] = $row['letter_no'];
					$diary[$count]['date_of_letter'] = $row['date_of_letter'];
					$diary[$count]['applicant'] = $row['applicant'];
					$diary[$count]['subject'] = $row['subject'];
					$diary[$count]['subject_desc'] = $row['subject_desc'];
					$diary[$count]['sender_city'] = $row['sender_city'];
					$diary[$count]['sender_state'] = $row['state_name'];
					$diary[$count]['sender_address1'] = $row['sender_address1'];
					$diary[$count]['sender_address2'] = $row['sender_address2'];
					$diary[$count]['pincode'] = $row['pincode'];
					$diary[$count]['category_id'] = $row['category_name'];
					$diary[$count]['diary_no'] = $row['diary_no'];
					$diary[$count]['recieved_through'] = $row['recieved_through'];
					$diary[$count]['mark_to'] = $row['user_name'];
					$diary[$count]['id'] = $row['id'];
					$count++;
				}
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $diary;
		}
		public function getMonthlyDiaryCount($month,$year,$category)
		{
		
			$fromDate = date("Y-m-d", strtotime($dailyDate));
		
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$query = "SELECT count(*) count where EXTRACT(MONTH FROM recieved_date) = :month 
						AND EXTRACT(YEAR FROM recieved_date) = :year AND category_id = :category ";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':month', $month, \PDO::PARAM_STR);
				$stmt->bindValue(':year', $year, \PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, \PDO::PARAM_INT);
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
		public function getRecentDiary($count)
		{
			$count != 0?$cond = 'LIMIT '.$count:$cond = '';
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT d.id, d.diary_no, c.category_name, d.letter_no, d.applicant, d.recieved_date,
						d.subject,d.subject_desc, d.date_of_letter, d.sender_address1, d.sender_address2,
						d.sender_city, s.state_name, d.pincode, d.recieved_through, u.user_name 
						FROM tbl_diary d JOIN tbl_states s ON d.sender_state = s.id 
						join tbl_diary_category c on c.id = d.category_id 
						JOIN tbl_user u ON d.mark_to = u.id  ORDER BY d.id DESC ".$cond;
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getNextDiaryId()
		{
			$currentYear = date('Y');
			$diary_no = '';
			$con = Conn\Connection::getConnection();
			$statement = $con->prepare("SELECT diary_no FROM tbl_diary
					 WHERE id = (SELECT MAX(id) FROM tbl_diary)");
			
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				$diary_no = $row['diary_no'];
			$diary = explode('/',$diary_no);
			if(count($diary) == 2) // if previus diary exist then it will generate next diary number
			{
				$year = $diary[0];
				$diaryLastNubmer = $diary[1];
					
				if($currentYear > $year)
				{
					$diaryLastNubmer = 1;
					$year = $currentYear;
				}
				else
					$diaryLastNubmer++;
				//$nextGeneratedDiaryNumber = $year.'/'.$diaryLastNubmer;
				$nextGeneratedDiaryNumber =$diaryLastNubmer.'/'.$year;
			}
			else if(count($diary) == 1)    // if no diary found then it will generate from currentyr/1
			{
				$year = $currentYear;
				$nextGeneratedDiaryNumber = $year.'/1';
			}
			else // if invalid previus diary number then it will show the error
			{
				echo "Error!......Invalid Format of last diary Number";
				die();
			}
			return $nextGeneratedDiaryNumber;
		}
		
		public function getAdvanceSearchResults($keyword)
		{
			$con = Conn\Connection::getConnection();
			try{
				$count = 0;
				$diary = array();
				$condition = '';
				if($keyword != '')
					$condition = "WHERE upper(diary_no) LIKE :keyword
							OR lower(diary_no) LIKE :keyword
							OR upper(subject) LIKE :keyword
							OR lower(subject) LIKE :keyword
							OR upper(applicant) LIKE :keyword
							OR lower(applicant) LIKE :keyword
							OR upper(letter_no) LIKE :keyword
							OR lower(letter_no) LIKE :keyword ";
				$query = "select * from tbl_diary  ".$condition ;
				$statement = $con->prepare($query);
				if($keyword != '')
					$statement->bindValue(':keyword', "%$keyword%", \PDO::PARAM_STR);
		
				$statement->execute();
					
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$diary[$count]['id'] = $row['id'];
					$diary[$count]['diary_no'] = $row['diary_no'];
					$diary[$count]['subject'] = $row['subject'];
					$diary[$count]['recieved_date'] = $row['recieved_date'];
					$diary[$count]['applicant'] = $row['applicant'];
					$diary[$count]['letter_no'] = $row['letter_no'];
					$count++;
				}
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $diary;
		}
		public function getApplicantId($applicationId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$id = 0;
				$diary = array();
				$query = "select id from tbl_applicants WHERE application_id = :applicationId";
				$statement = $con->prepare($query);
				
				$statement->bindValue(':applicationId',$applicationId , \PDO::PARAM_STR);
		
				$statement->execute();
					
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$id = $row['id'];
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $id;
		}
		
		public function getApplicantEligibilities($applicantId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$id = array();
				$diary = array();
				$query = "select eligibility_id from tbl_eligibility WHERE applicant_id = :applicantId";
				$statement = $con->prepare($query);
				if($keyword != '')
					$statement->bindValue(':applicantId',$applicantId , \PDO::PARAM_INT);
		
				$statement->execute();
					
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
					$id[$count++] = $row['eligibility_id'];
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $id;
		}
		public function getSearchResults($keyword,$check,$startDate,$endDate,$state)
		{
			//print_r($check);
			$con = Conn\Connection::getConnection();
			try{
				$count = 0;
				$diary = array();
				$condition = '';
				if($keyword != '')
				{
					for($i=0;$i<count($check);$i++)
					{
					switch($check[$i])
					{
					case 'diary_no' : $condition = ($condition==""?" WHERE lower(diary_no) LIKE :keyword OR upper(diary_no) LIKE :keyword":$condition." OR lower(diary_no) LIKE :keyword OR upper(diary_no) LIKE :keyword");
							break;
					case 'subject' : $condition = ($condition==""?" WHERE lower(subject) LIKE :keyword OR upper(subject) LIKE :keyword":$condition." OR lower(subject) LIKE :keyword  OR upper(subject) LIKE :keyword");
									break;
							case 'letter_no' : $condition = ($condition==""?" WHERE lower(letter_no) LIKE :keyword OR upper(letter_no) LIKE :keyword":$condition." OR lower(letter_no) LIKE :keyword OR upper(letter_no) LIKE :keyword");
									break;
									case 'applicant' : $condition = ($condition==""?" WHERE lower(applicant) LIKE :keyword OR upper(applicant) LIKE :keyword":$condition." OR lower(applicant) LIKE :keyword OR upper(applicant) LIKE :keyword");
									break;
											case 'contact_no' : $condition = ($condition==""?" WHERE contact_no LIKE :keyword":$condition." OR contact_no LIKE :keyword");
									break;
													case 'mail_id' : $condition = ($condition==""?" WHERE lower(mail_id) LIKE :keyword OR upper(mail_id) LIKE :keyword":$condition." OR lower(mail_id) LIKE :keyword OR upper(mail_id) LIKE :keyword");
									break;
													default :
													break;
					}
					}
					}
					if($startDate != '')
						$condition = ($condition==""?" WHERE recieved_date >= :start_date":$condition." AND recieved_date >= :start_date");
				if($endDate != '')
					$condition = ($condition==""?" where recieved_date <= :end_date":$condition. " AND recieved_date <= :end_date");
				if($state != '')
						$condition = ($condition==""?" where sender_state = :state":$condition. " AND sender_state = :state");
		
				$query = "select id,applicant,subject,diary_no,recieved_date,letter_no from tbl_diary  ".$condition ;
		
				$statement = $con->prepare($query);
		
						if(count($check) > 0 && $keyword != '')
							$statement->bindValue(':keyword', "%$keyword%", \PDO::PARAM_STR);
									if($startDate != '')
										$statement->bindValue(':start_date', $startDate, \PDO::PARAM_STR);
										if($endDate != '')
											$statement->bindValue(':end_date', $endDate, \PDO::PARAM_STR);
											if($state != '')
												$statement->bindValue(':state', $state, \PDO::PARAM_STR);
												$statement->execute();
													
												while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
													{
													$diary[$count]['id'] = $row['id'];
													$diary[$count]['diary_no'] = $row['diary_no'];
															$diary[$count]['subject'] = $row['subject'];
																	$diary[$count]['recieved_date'] = $row['recieved_date'];
					$diary[$count]['applicant'] = $row['applicant'];
					$diary[$count]['letter_no'] = $row['letter_no'];
							$count++;
				}
				$con =NULL;
													}catch (PDOException $e) {
													print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $diary;
				}
				public function getApplicants($applicationId)
				{				
					$con = Conn\Connection::getConnection();
					$count = 0;
					$applicant =array();
					try{
						$query = "SELECT a.id, a.applicant_name, a.applicant_contact_no,a.applicant_mobile_no,
								a.applicant_email_id, a.applicant_age, a.applicant_d_o_b, 
								a.applicant_occupation,	a.applicant_income,	a.applicant_father_name,
								b.applicant_address_line1, b.applicant_address_line2, b.applicant_city,
								b.applicant_pincode,
								c.state_name
								FROM tbl_applicants a
								FULL JOIN tbl_applicant_address b 
								ON a.id = b.applicant_id
								FULL JOIN tbl_states c ON 
								b.applicant_state = c.id
							   WHERE a.application_id = :application_id ORDER BY a.id DESC ";
						$stmt = $con->prepare($query);
						$stmt->bindValue(':application_id', $applicationId, \PDO::PARAM_STR);
						$stmt->execute();
						while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
						{
							$applicant[$count]['id']                      = $row['id'];
							$applicant[$count]['applicant_name']          = $row['applicant_name'];
							$applicant[$count]['applicant_contact_no']    = $row['applicant_contact_no'];
							$applicant[$count]['applicant_mobile_no']     = $row['applicant_mobile_no'];
							$applicant[$count]['applicant_email_id']      = $row['applicant_email_id'];
							$applicant[$count]['applicant_age']           = $row['applicant_age'];
							$applicant[$count]['applicant_dob']           = $row['applicant_d_o_b'];
							$applicant[$count]['applicant_occupation']    = $row['applicant_occupation'];
							$applicant[$count]['applicant_income']        = $row['applicant_income'];
							$applicant[$count]['applicant_address_line1'] = $row['applicant_address_line1'];
							$applicant[$count]['applicant_address_line2'] = $row['applicant_address_line2'];
							$applicant[$count]['applicant_city']          = $row['applicant_city'];
							$applicant[$count]['applicant_pincode']       = $row['applicant_pincode'];
							$applicant[$count]['applicant_state']         = $row['state_name'];
							$applicant[$count]['state_name']              = $row['state_name'];
							$count++;
						}
						$con =NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $applicant;
				}
				public function getApplicationId($applicationId)
				{
					$con = Conn\Connection::getConnection();
					$count = 0;
					
					try{
						$query = "SELECT a.id FROM tbl_application a 
								JOIN tbl_applicants b ON a.id = b.application_id WHERE application_id = :applicationId";
								
						$stmt = $con->prepare($query);
						$stmt->bindValue(':applicationId', $applicationId, \PDO::PARAM_STR);
						$stmt->execute();
						while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
						{
							$appId = $row['id'];
							
						}
						$con =NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $appId;
				}
				
				
				public function getApplicationDoc()
				{
					$con = Conn\Connection::getConnection();
					$count = 0;
						
					try{
						$query = "SELECT a.id, a.diary_no, a.received_date, a.appli_type_id, b.appli_type_name
								 FROM tbl_application a
								JOIN tbl_application_types b ON a.appli_type_id = b.id";
				
						$stmt = $con->prepare($query);
						$stmt->execute();
						$con =NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $stmt->fetchAll();
				}
				
				
				public function getSingleApplicationDoc($appId)
				{
					$con = Conn\Connection::getConnection();
					$count = 0;
				
					try{
						$query = "SELECT id, diary_no, received_date, appli_type_id
								 FROM tbl_application WHERE id = :id";
				
						$stmt = $con->prepare($query);
						$stmt->bindValue(':id', $appId, \PDO::PARAM_INT);
						$stmt->execute();
						$con =NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $stmt->fetchAll();
				}
				
			public function getApplicantDoc($applicationId, $applicantId)
				{
				//	echo $applicantId; exit;
					$con = Conn\Connection::getConnection();
					$count = 0;
				
					try{
						$is_active =TRUE;
						$query = "SELECT id, doc_type_id FROM tbl_application_doc 											
						        WHERE application_id = :application_id AND applicant_id = :applicant_id 
								AND is_active= :is_active ORDER By id ASC";
				$statement = $con->prepare($query);
				$statement->bindParam(':application_id', $applicationId, \PDO::PARAM_INT);
				$statement->bindParam(':applicant_id', $applicantId, \PDO::PARAM_INT);
				$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
				$statement->execute();
				
				while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
				{
					$docID[$count] = $row['doc_type_id'];
					$count++;
				}
				$con = NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $docID;
				}		
				
			public function getApplicantName($applicantId)
				{
					//	echo $applicantId; exit;
					$con = Conn\Connection::getConnection();
					$count = 0;
				
					try{
						$is_active =TRUE;
						$query = "SELECT applicant_name	FROM tbl_applicants WHERE id = :applicant_id";
						$statement = $con->prepare($query);
						$statement->bindParam(':applicant_id', $applicantId, \PDO::PARAM_INT);						
						$statement->execute();
						$con = NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $statement->fetchAll();
				}		
				
				
		public function applicantionDocCount($applicationId)
				{
					//	echo $applicationId; exit;
					$con = Conn\Connection::getConnection();
					$count = 0;
					$docID=0;
					try{						
						$is_active =TRUE;
						$query = "SELECT COUNT(*) AS result_count FROM tbl_application_doc
						        WHERE application_id = :application_id AND is_active= :is_active";
						$statement = $con->prepare($query);
						$statement->bindParam(':application_id', $applicationId, \PDO::PARAM_INT);						
						$statement->bindParam(':is_active', $is_active, \PDO::PARAM_BOOL);
						$statement->execute();
						
						while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
						{						
							$result_count = $row['result_count'];
						}
						
						$con = NULL;
					}catch (PDOException $e) {
						print "Error!: " . $e->getMessage() . "<br/>";
						die();
					}
					return $result_count;
				}
				
				
	}
?>