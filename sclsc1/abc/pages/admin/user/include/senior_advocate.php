<?php

	include_once '../../../classes/connection/Connection.php';
	use classes\connection as Conn;
	
	if (isset($_GET['term'])){
	$return_arr = array();

	try {
		$conn = Conn\Connection::getConnection();
		$stmt = $conn->prepare('SELECT sr_advocate_name FROM tbl_sr_advocate WHERE sr_advocate_name ILIKE :term');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  $row['sr_advocate_name'];
	    }

	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}


?>