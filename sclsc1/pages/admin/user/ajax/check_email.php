<?php
session_start();

include_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
use classes\connection as Conn;

if(isset($_POST["email_id"]))
{
	
	$con = Conn\Connection::getConnection();
	//check if its ajax request, exit script if its not
	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		die();
	}

	{
		
		$query = " ";
		$stmt = $con->prepare($query);
		$stmt->bindParam(':throughType_id', $_GET['throughTypeId'], \PDO::PARAM_INT);
		$stmt->bindParam(':state_id', $_GET['state'], \PDO::PARAM_INT);
		$stmt->bindParam(':name', $name, \PDO::PARAM_STR);
	}
	//try connect to db
	$connecDB = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('could not connect to database');

	//trim and lowercase username
	$username =  strtolower(trim($_POST["username"]));

	//sanitize username
	$username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);

	//check username in db
	$results = mysqli_query($connecDB,"SELECT id FROM username_list WHERE username='$username'");

	//return total count
	$username_exist = mysqli_num_rows($results); //total records

	//if value is more than 0, username is not available
	if($username_exist) {
		die('<img src="imgs/not-available.png" />');
	}else{
		die('<img src="imgs/available.png" />');
	}

	//close db connection
	mysqli_close($connecDB);
}


?>