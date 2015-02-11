<?php 
	session_start();
?>
	<option value=''>Select Jail</option>
<?php 
	
	require_once '../../../classes/Connection/Connection.php';
	use classes\connection as Conn;
	
	$con = Conn\Connection::getConnection();
			
	$query = "SELECT id,appli_through_name FROM tbl_appli_through where appli_through_type_id = 38 and state = :state_id";
	$stmt = $con->prepare($query);
	$stmt->bindParam(':state_id', $_GET['q'], PDO::PARAM_INT);
	
	$stmt->execute();
	while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
	{
	?>
		<option  value="<?php echo $row['id']?>"><?php echo $row['appli_through_name']?> </option>
	<?php 
	}
		$con = NULL;
?>
		
