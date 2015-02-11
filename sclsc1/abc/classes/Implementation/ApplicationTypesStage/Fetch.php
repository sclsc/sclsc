<?php
	namespace classes\Implementation\ApplicationTypesStage;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/ApplicationTypesStage/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\ApplicationTypesStage as IFetch;
	
	class Fetch implements IFetch\Fetchable 
	{
		
		
		public function getApplicationStage()
		{
			$con = Conn\Connection::getConnection();
			try{
				/*$query = "SELECT a.id,a.appli_type_name, s.stage_name FROM tbl_application_type_stages  ap JOIN tbl_application_types a
						ON ap.application_type_id = a.id
						JOIN tbl_stages s
						ON s.id = ap.stage_id
						ORDER BY ap.id;";*/
				$query="SELECT a.* FROM tbl_application_type_stages  ap  join tbl_application_types a on ap.application_type_id=a.id group by a.id";
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
		
		public function checkApplicationTypestages($stage_id,$application_type_id)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT stage_id,application_type_id FROM tbl_application_type_stages WHERE stage_id = :stage_id and application_type_id = :application_type_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':stage_id', $stage_id, \PDO::PARAM_INT);
				$stmt->bindParam(':application_type_id', $application_type_id, \PDO::PARAM_INT);
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
		
		public function getApplicationStageName($application_id)
		{
			$con = Conn\Connection::getConnection();
			try{
				
				$query="SELECT c.stage_name,ap.id FROM tbl_application_type_stages  ap   join tbl_stages c on c.id=ap.stage_id where ap.application_type_id= :application_id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':application_id', $application_id, \PDO::PARAM_INT);
				$stmt->execute();
				
				$con = NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		public function getApplicationTypeStage($id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * from tbl_application_type_stages WHERE id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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