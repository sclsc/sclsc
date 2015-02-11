<?php
session_start();

			$dsn='localhost';
			$user='postgres';
			$pswd='ubuntu';
			$dbname='sclscdb';
			$conn_string = "host=localhost dbname=sclscdb user=postgres password=ubuntu";
			$dbconn4 = pg_connect($conn_string);

// Put data records from mysql by For loop.
header( "Content-Type: application/vnd.ms-excel" );
$filename = "Diary-Report-" . date('dmY') . ".xls"; 
header("Content-Disposition: attachment; filename=\"$filename\""); 


// print your data here. note the following:
// - cells/columns are separated by tabs ("\t")
// - rows are separated by newlines ("\n")

// for example:

function cleanData(&$str) { 
	$str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

 $flag = false;
 $query = "SELECT dairy.diary_no,dairy.subject,dairy.applicant,dairy.mark_to,state.state_name,dairy.recieved_date FROM tbl_diary dairy JOIN tbl_states state ON dairy.sender_state=state.id WHERE 1=1";
 if($_GET['user']!=0)
 {
 	$query.=" AND dairy.mark_to='".$_GET['user']."' ";
 }
 if($_GET['received_through_type']!=0){
 	$query.=" AND dairy.recieved_through ='".$_GET['received_through_type']."' ";
 }
 if($_GET['state']!=0){
 	$query.=" AND dairy.sender_state ='".$_GET['state']."' ";
 }
 $query.=" ORDER BY dairy.id, dairy.diary_no asc ";
 $result = pg_query($query);
 
 
// $result = pg_query("SELECT * FROM tbl_diary") or die('Query failed!'); 
while(false !== ($row = pg_fetch_assoc($result))) {

	if(!$flag) {
		echo implode("\t", array_keys($row)) . "\r\n";
		$flag = true;
	}
	array_walk($row, 'cleanData');
	echo implode("\t", array_values($row)) . "\r\n";
}
exit();
?>