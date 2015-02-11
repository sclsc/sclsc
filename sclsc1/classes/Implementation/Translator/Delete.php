<?php
	namespace classes\Implementation\Translator;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Translator/Deleteable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Translator as IDelete;
	 
	class Delete implements IDelete\Deleteable
	{
		public function delTranslator($translatorId)
		{
			//	echo $applicationId; exit;
			$con = Conn\Connection::getConnection();
			$flag=0;
			try{
				$query = "DELETE FROM tbl_translator WHERE translator_id=:translatorId";
				$stmt = $con->prepare($query);
				$stmt->bindValue(':translatorId', $translatorId, \PDO::PARAM_INT);
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
?>