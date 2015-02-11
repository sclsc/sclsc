<?php
	namespace classes\connection;
	
	class Connection
	{
		public static function getConnection() 
		{
		//	$dsn='192.168.1.104';
			$dsn='localhost';
			$user='postgres';
			$pswd='ubuntu';
			$dbname='sclsc-app';
			try {
				$dbh = new \PDO('pgsql:host='.$dsn.'; dbname='.$dbname, $user, $pswd);
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return $dbh;
		}
	}
?>

