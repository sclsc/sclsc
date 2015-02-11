<?php
	namespace classes\Implementation\Dispatcher;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Dispatcher/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Dispatcher as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{

		public function getOtherDispApplicationCount()
		{
			$con = Conn\Connection::getConnection();
			$count = 0;
			try{
				$currDate = date("Y-m-d");
				$appli_type_id =30;
				$query = "SELECT DISTINCT ON (b.id) b.id, b.diary_no, b.appli_type_id, b.received_date,
			            a.appli_type_name, 
						d.applicant_name,
						f.stage_name
						FROM tbl_application_types a join tbl_application b on a.id=b.appli_type_id
						FULL JOIN tbl_applicants d on b.id=d.application_id
						FULL JOIN tbl_application_status e on b.id=e.application_id
						FULL JOIN tbl_stages f on f.id=e.stage_id
						FULL JOIN tbl_backlog_entry_log g on g.application_id=b.id
						WHERE b.appli_type_id = :appli_type_id
						ORDER BY b.id, b.diary_no asc, d.id asc, e.stage_id DESC";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':appli_type_id', $appli_type_id, \PDO::PARAM_INT);
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
		
		public function getOtherDispApplication($limit,$start)
		{
			$count = 0;
			$flag=0;
			try
			{
				$application_id =0;
				$con = Conn\Connection::getConnection();
				$query = "SELECT * FROM tbl_dispatch
						WHERE application_id = :application_id  ORDER BY id DESC LIMIT :limit OFFSET :offset";
				$statement = $con->prepare($query);
				$statement->bindValue(':application_id', $application_id, \PDO::PARAM_STR);
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
		

		
		
  }
?>