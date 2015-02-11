<?php
	namespace classes\Implementation\RecievedThrough;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/RecievedThrough/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\RecievedThrough as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		public function checkThrough($appli_through_type_name)
		{
			$con = Conn\Connection::getConnection();
			$flag = 0;
			try{
				$query = "SELECT appli_through_name FROM tbl_appli_through WHERE appli_through_name = :through_name";
				$stmt = $con->prepare($query);
				$stmt->bindParam(':through_name', $appli_through_type_name, \PDO::PARAM_INT);
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
		public function getAllReceivedThrough($limit,$start)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT t.id,t.designation,t.appli_through_name,t.email_id,t.contact_no,t.address_line1,t.address_line2,t.city,
						s.state_name state,t.pincode,n.appli_through_type_name through_type
						 FROM tbl_appli_through t JOIN tbl_appli_through_type n ON n.id = t.appli_through_type_id
						JOIN tbl_states s ON s.id = t.state  ORDER BY id DESC LIMIT :limit OFFSET :start";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':limit', $limit,\PDO:: PARAM_STR );
				$stmt->bindValue(':start', $start,\PDO:: PARAM_STR );
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		public function getAllReceivedThroughCount()
		{
			$counter=0;
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT t.id,t.designation,t.appli_through_name,t.email_id,t.contact_no,t.address_line1,t.address_line2,t.city,
						s.state_name state,t.pincode,n.appli_through_type_name through_type
						 FROM tbl_appli_through t JOIN tbl_appli_through_type n ON n.id = t.appli_through_type_id
						JOIN tbl_states s ON s.id = t.state  ORDER BY id DESC";
				$stmt = $con->prepare($query);
				$stmt->execute();
		
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			while($stmt->fetch())
				$counter++;
			return $counter;
		}
		public function getThrough($id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through where id=:id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
				$stmt->execute();
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $stmt->fetchAll();
		}
		
		
		public function getThroughTypeName($id)
		{
			$con = Conn\Connection::getConnection();
			$name = '';
			try{
				$query = "SELECT appli_through_type_name FROM tbl_appli_through_type where id = :id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
				$stmt->execute();
				while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
					$name = $row['appli_through_type_name'];
				$con =NULL;
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $name;
		}
		public function getRole()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_role";
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
		
		public function getThroughType()
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through";
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
		
		public function getReceivedThroughType()
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
		

		
		public function getReceivedThrough($id)
		{
			$con = Conn\Connection::getConnection();
			try{
				$query = "SELECT * FROM tbl_appli_through where appli_through_type_id = :id";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':id', $id, \PDO::PARAM_STR);
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