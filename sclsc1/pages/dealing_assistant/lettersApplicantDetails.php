<?php 
    session_start();
        require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
		
		use classes\Connection as Conn;
		use classes\Implementation\ClosingOfFile as impCof;
		
		$fetchCof = new impCof\Fetch();
		
		$applicantDetails  = $fetchCof->getLetterAddresse($_GET['q']);
//print_r($applicantDetails);
//	echo $_GET['q'];
	
	$address_line1=$address_line2=$city=$state_name=$pincode=$applicant_contact_no=$applicant_mobile_no='';
	
	$address1 = $applicantDetails[0]['address1'];	
	$address2 = $applicantDetails[0]['address2'];

?>
		
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
	
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">Applicant Details</div>
		     		
		     		<div class="left" style="border-right:1px solid #000; padding-right:10px;">
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b> Name : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicantDetails[0]['addressee_name']; ?>
		     			</div>
		     			
		     			
		     			<div class="clear"></div>
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Address : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;width:60%; ">
		     				<?php 
		     				
		     				if(isset($applicantDetails[0]['address1']) && $applicantDetails[0]['address1']!='')
		     				{
		     					$address_line1=$applicantDetails[0]['address1'].', ';
		     				}
		     				if(isset($applicantDetails[0]['address2']) && $applicantDetails[0]['address2']!='')
		     				{
		     					$address_line2=$applicantDetails[0]['address2'].', ';
		     				}
		     				if(isset($applicantDetails[0]['city']) && $applicantDetails[0]['city']!='')
		     				{
		     					$city=$applicantDetails[0]['city'].', ';
		     				}
		     					if(isset($applicantDetails[0]['state']) && $applicantDetails[0]['state']!=0)
		     				 {
		     					$state=$applicantDetails[0]['state'];
		     					
		     					$applicant_state=$state;
		     					$con = Conn\Connection::getConnection();
		     					$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		     					$stmt = $con->prepare($query);
		     					$stmt->bindParam(':state_id', $applicant_state, PDO::PARAM_INT);
		     					$stmt->execute();
		     					while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
		     						$state_name = $row['state_name'];
		     					
		     					$con =NULL;
		     					
		     				}
		     				if(isset($applicantDetails[0]['pincode']) && $applicantDetails[0]['pincode']!=0)
		     				{
		     					$pincode=', '.$applicantDetails[0]['pincode'];
		     				}   				
		     				
		     				 echo $address_line1.$address_line2.$city.$state_name.$pincode; 
		     				
		     				?>
		     			</div>
		     			
		     		</div>     		
		     	<div class="left"  style="padding-right:10px;">
		     	
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Recieved By  : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal; width:60%;">
		     				<?php 
		     				if ($applicantDetails[0]['is_to']==0)
		     				{ 
		     					echo "Copy To"; 		     					
		     				}
		     				else 
		     				{
		     					echo "To";
		     				}		     							     					
		     				?>
		     			</div>
		     			
		     			
		     			
		     		</div>    
	     			