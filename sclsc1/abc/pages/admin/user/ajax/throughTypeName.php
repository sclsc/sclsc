<?php
session_start();

include_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
use classes\connection as Conn;

		$counter=0;
		if(isset($_GET['throughTypeId']) && isset($_GET['state'])){
			$con = Conn\Connection::getConnection();
		if(isset($_GET['name']) && $_GET['name']!='')
		{
			$name='%'.$_GET['name'].'%';
			$query = "SELECT t.id,t.designation,t.appli_through_name,t.email_id,t.contact_no,t.address_line1,t.address_line2,t.city,
								s.state_name state,t.pincode,n.appli_through_type_name through_type
								 FROM tbl_appli_through t JOIN tbl_appli_through_type n ON n.id = t.appli_through_type_id
								JOIN tbl_states s ON s.id = t.state
								where s.id= :state_id AND n.id= :throughType_id AND t.appli_through_name ILIKE  :name ";
			$stmt = $con->prepare($query);
			$stmt->bindParam(':throughType_id', $_GET['throughTypeId'], \PDO::PARAM_INT);
			$stmt->bindParam(':state_id', $_GET['state'], \PDO::PARAM_INT);
			$stmt->bindParam(':name', $name, \PDO::PARAM_STR);
		}
		if(empty( $_GET['name'])) {
			$query = "SELECT t.id,t.designation,t.appli_through_name,t.email_id,t.contact_no,t.address_line1,t.address_line2,t.city,
								s.state_name state,t.pincode,n.appli_through_type_name through_type
								 FROM tbl_appli_through t JOIN tbl_appli_through_type n ON n.id = t.appli_through_type_id
								JOIN tbl_states s ON s.id = t.state
								where s.id= :state_id AND n.id= :throughType_id ";
			$stmt = $con->prepare($query);
			$stmt->bindParam(':throughType_id', $_GET['throughTypeId'], \PDO::PARAM_INT);
			$stmt->bindParam(':state_id', $_GET['state'], \PDO::PARAM_INT);
		
			
		}
		
		
					$stmt->execute();
					?>
					<table style="border:1px solid black;width:310px;">
		  
					<tr><th style="background-color:gray;"><?php echo $_GET['throughTypeName'];?></th></tr>
		
					<?php 
					while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
						{
						?>
						<tr>
		    <td id="<?php echo $row['id']?>"><?php echo $row['appli_through_name']?></td>
		    
		  </tr>
			
					<?php 
					$counter++;
						}?>
						</table>
						<?php 
		}

		if($counter==0)
			echo '<tr><td>No Records Found</td></tr>'; 
						$con = NULL;
		
			?>
	