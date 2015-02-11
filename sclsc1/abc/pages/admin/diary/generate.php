<?php
session_start();
require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
use classes\Connection as Conn;

function xlsBOF() {
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
return;
}
function xlsEOF() {
echo pack("ss", 0x0A, 0x00);
return;
}
function xlsWriteNumber($Row, $Col, $Value) {
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
echo pack("d", $Value);
return;
}
function xlsWriteLabel($Row, $Col, $Value ) {
$L = strlen($Value);
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
echo $Value;
return;
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=downline.xls ");
header("Content-Transfer-Encoding: binary ");
xlsBOF();
/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/

xlsWriteLabel(0,0,"Diary Detail.");
// Make column labels. (at line 3)
xlsWriteLabel(2,0,"Diary No");
xlsWriteLabel(2,1,"Letter No");
xlsWriteLabel(2,2,"Category");
xlsWriteLabel(2,3,"Date of Letter");
xlsWriteLabel(2,4,"Recieved Date");
xlsWriteLabel(2,5,"Applicant");
xlsWriteLabel(2,6,"Subject");
xlsWriteLabel(2,7,"Subject Desc");
xlsWriteLabel(2,8,"Sender Address1");
xlsWriteLabel(2,9,"Sender Address2");
xlsWriteLabel(2,10,"City");
xlsWriteLabel(2,11,"State");
xlsWriteLabel(2,12,"Pin Code");

$xlsRow = 3;
// Put data records from mysql by while loop.
$con = Conn\Connection::getConnection();
$str="select * from tbl_diary";
$stmt = $con->prepare($query);
$stmt->execute();
while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
{	
	xlsWriteLabel($xlsRow,0,$row['diary_no']);
	xlsWriteLabel($xlsRow,1,$row['letter_no']);
	xlsWriteLabel($xlsRow,2,$row['category_id']);
	xlsWriteLabel($xlsRow,3,$row['date_of_letter']);
	xlsWriteLabel($xlsRow,4,$row['recieved_date']);
	xlsWriteLabel($xlsRow,5,$row['applicant']);
	xlsWriteLabel($xlsRow,6,$row['subject']);
	xlsWriteLabel($xlsRow,7,$row['subject_desc']);
	xlsWriteLabel($xlsRow,8,$row['sender_address1']);
	xlsWriteLabel($xlsRow,9,$row['sender_address2']);
	xlsWriteLabel($xlsRow,10,$row['sender_city']);
	xlsWriteLabel($xlsRow,11,$row['sender_state']);
	xlsWriteLabel($xlsRow,12,$row['pincode']);
}

xlsEOF();
exit();

?>