<?php
	namespace classes\Implementation\Eligibility;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Eligibility/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Eligibility as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function checkForDuplicateEligibilityCondition($condition_name)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT id FROM tbl_eligibility_conditions where eligibility_condition = :condition_name";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':condition_name', $condition_name, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$flag = 1;
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		
		public function getAllEligibilityCondition()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_eligibility_conditions ORDER BY id ";
				$stmt = $con->prepare($query);
				$stmt->execute();
		
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getAllEligibilityConditions()
		{
			$con = Conn\Connection::getConnection();
			try{
					
				$query = "SELECT * FROM tbl_eligibility_conditions WHERE is_active=TRUE ORDER BY id";
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
		
		public function getApplicationEligibilities($applicantId)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT eligibility_id FROM tbl_applicant_eligibility WHERE applicant_id=:applicant_id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':applicant_id', $applicantId, \PDO::PARAM_INT);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
	}
?>