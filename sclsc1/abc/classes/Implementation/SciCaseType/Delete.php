<?php
namespace classes\Implementation\SciCaseType;

require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
require_once $_SESSION['base_url'].'/classes/Interfaces/SciCaseType/Deleteable.php';

use classes\Connection as Conn;
use classes\Interfaces\SciCaseType as IDelete;

class Delete implements IDelete\Deleteable
{
	public function delScCaseType($applicationId)
	{
		//	echo $applicationId; exit;
		$con = Conn\Connection::getConnection();
		$flag=0;
		try{
			$query = "DELETE FROM tbl_sc_case_type WHERE id=:id";
			$stmt = $con->prepare($query);
			$stmt->bindValue(':id', $applicationId, \PDO::PARAM_INT);
			if($stmt->execute())
			{
				$flag = 1;
			}
			$con =NULL;
		}
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $flag;
	}
}