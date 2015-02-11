<?php
	namespace classes\Implementation\Translator;
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Interfaces/Translator/Fetchable.php';
	
	use classes\Connection as Conn;
	use classes\Interfaces\Translator as IFetch;
	
	class Fetch implements IFetch\Fetchable
	{
		
		public function getTranslatorList()
		{
			$translator = array();
			$count = 0;
			$con = Conn\Connection::getConnection();
			$query = "SELECT translator_id, translator_name, medium_code FROM tbl_translator
					  WHERE is_active IS TRUE ORDER BY last_appt";
			$statement = $con->prepare($query);			
			$statement->execute();
			while($row = $statement->fetch(\PDO::FETCH_ORI_NEXT))
			{
				$translator[$count]['translator_id']   = $row['translator_id'];
				$translator[$count]['translator_name'] = $row['translator_name'];
				$translator[$count]['medium_code']     = $row['medium_code'];
				$count++;
			}
			
			return $translator;
		}
		
		
	}
?>