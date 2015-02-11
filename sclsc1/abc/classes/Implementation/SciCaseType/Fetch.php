<?php
	namespace classes\Implementation\SciCaseType;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/SciCaseType/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\SciCaseType as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function checkScCaseType($case_type)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT case_type_name FROM tbl_sc_case_type WHERE case_type_name = :case_type";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':case_type', $case_type, \PDO::PARAM_INT);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$flag = 1;
				$con =NULL;
			}catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $flag;
		}
		public function getAllScCaseType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_sc_case_type ORDER BY id";
				$stmt = $con->prepare($query);
				$stmt->execute();
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
	}
?>