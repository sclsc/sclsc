<?php
namespace classes\Implementation\Eligibility;

require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
require_once $_SESSION['base_url'].'/classes/Interfaces/Eligibility/Deleteable.php';

use classes\Connection as Conn;
use classes\Interfaces\Eligibility as IDelete;

class Delete implements IDelete\Deleteable
{
	public function delEleigibilityCondition($id)
	{
		$con = Conn\Connection::getConnection();
		$flag=0;
		try{
			$query = "DELETE FROM tbl_eligibility_conditions WHERE id=:id";
			$stmt = $con->prepare($query);
			$stmt->bindValue(':id', $id, \PDO::PARAM_INT);
			if($stmt->execute())
			{
				$flag = 1;
			}
				
				
		}
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $flag;
	
	}
}
