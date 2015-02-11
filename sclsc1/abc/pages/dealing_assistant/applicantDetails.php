<?php 
    session_start();
    
        require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
		
		use classes\Connection as Conn;
		use classes\Implementation\ClosingOfFile as impCof;
		$fetchCof = new impCof\Fetch();
		
		$applicantDetails  = $fetchCof->getApplicantDetails($_GET['q']);
		$applicantJailInfo = $fetchCof->getApplicantJailInfo($_GET['q']);
		$eligibilities     = $fetchCof->getEligibilities($_GET['q']);
	
	$address_line1=$address_line2=$city=$state_name=$pincode=$applicant_contact_no=$applicant_mobile_no='';
	$applicant_name=$applicant_father_name=$applicant_age=$applicant_d_o_b=$applicant_email_id='';
	
	if(isset($applicantDetails['applicant_name']))
	{
		$applicant_name = $applicantDetails['applicant_name'];
	}
	
	if(isset($applicantDetails['applicant_father_name']) && $applicantDetails['applicant_father_name']!='')
	{
		$rel = substr($applicantDetails['applicant_father_name'], 0, 3);
		$father = substr($applicantDetails['applicant_father_name'],4);
		
		$applicant_father_name = $father != '' ? "<br />".$applicantDetails['applicant_father_name']:'';
	}
	
	if(isset($applicantDetails['applicant_email_id']) && $applicantDetails['applicant_email_id']!='')
	{
		$applicant_email_id = $applicantDetails['applicant_email_id'];
	}
	
	if(isset($applicantDetails['applicant_mobile_no']) && $applicantDetails['applicant_mobile_no']!='')
	{
		$applicant_mobile_no =	$applicantDetails['applicant_mobile_no'];
	}
	
	if(isset($applicantDetails['applicant_contact_no']) && $applicantDetails['applicant_contact_no']!=0)
	{
	$applicant_contact_no =	"/".$applicantDetails['applicant_contact_no'];	
	}
	
	
	if(isset($applicantDetails['applicant_d_o_b']) && $applicantDetails['applicant_d_o_b']!='')
	{
		$applicant_d_o_b = date("d-m-Y", strtotime($applicantDetails['applicant_d_o_b']));
	
	}
	
	if(isset($applicantDetails['applicant_age']) && $applicantDetails['applicant_age']!=0)
	{
		$applicant_age =	"/".$applicantDetails['applicant_age']. ' '.'Years';
	}
	

?>
		
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
	
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">Applicant Details</div>
		     		
		     		<div class="left" style="border-right:1px solid #000; padding-right:10px;">
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b> Name : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicant_name.' '.$applicant_father_name; ?>
		     			</div>
		     			
		     			<div class="clear"></div>
		     			<div class="left" style="text-align:left;width:30%;">		     			
		     			<b>	Mobile/Contact : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicant_mobile_no.$applicant_contact_no; ?>
		     			</div>
		     			
		     			<div class="clear"></div>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	E-Mail Id : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicant_email_id; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	DOB/Age : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicant_d_o_b.$applicant_age; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Address : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;width:60%; ">
		     				<?php 
		     				
		     				if(isset($applicantDetails['applicant_address_line1']) && $applicantDetails['applicant_address_line1']!='')
		     				{
		     					$address_line1=$applicantDetails['applicant_address_line1'].', ';
		     				}
		     				if(isset($applicantDetails['applicant_address_line2']) && $applicantDetails['applicant_address_line2']!='')
		     				{
		     					$address_line2=$applicantDetails['applicant_address_line2'].', ';
		     				}
		     				if(isset($applicantDetails['applicant_city']) && $applicantDetails['applicant_city']!='')
		     				{
		     					$city=$applicantDetails['applicant_city'].', ';
		     				}
		     					if(isset($applicantDetails['applicant_state']) && $applicantDetails['applicant_state']!=0)
		     				 {
		     					$state=$applicantDetails['applicant_state'];
		     					
		     					$applicant_state=$state;
		     					$con = Conn\Connection::getConnection();
		     					$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		     					$stmt = $con->prepare($query);
		     					$stmt->bindParam(':state_id', $applicant_state, \PDO::PARAM_INT);
		     					$stmt->execute();
		     					while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
		     						$state_name = $row['state_name'];
		     					
		     					$con =NULL;
		     					
		     				}
		     				if(isset($applicantDetails['applicant_pincode']) && $applicantDetails['applicant_pincode']!=0)
		     				{
		     					$pincode=', '.$applicantDetails['applicant_pincode'];
		     				}   				
		     				
		     				 echo $address_line1.$address_line2.$city.$state_name.$pincode; 
		     				
		     				?>
		     			</div>
		     			
		     		</div>     		
		     	<div class="left"  style="padding-right:10px;">
		     	<?php if(isset($applicantJailInfo['appli_through_name']) && $applicantJailInfo['appli_through_name']!='') { ?>
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Jail Name  : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal; width:60%;">
		     				<?php echo $applicantJailInfo['appli_through_name']; ?>
		     			</div>
		     			<?php } ?>
		     			<div class="clear"></div>
		     			<?php if(isset($applicantJailInfo['jail_convict_no']) && $applicantJailInfo['jail_convict_no']!='') { ?>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	Convict No. : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $applicantJailInfo['jail_convict_no']; ?>	
		     			</div>    
		     			<?php } ?>			
		     			<div class="clear"></div>
		     			<?php if(count($eligibilities)>0) { ?>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	Eligibility : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     			
		     				<?php 
		     				for($i=0;$i<count($eligibilities);$i++)
		     				{		     				
		     				echo  $eligibilities[$i]['eligibility_condition'].'<br/>';
		     				}
		     				?>	
		     				
		     				
		     			</div> 
		     			
		     		</div>    
	     			<?php } ?>