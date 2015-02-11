<?php 
session_start();
    if(!isset($_SESSION['user']['user_name']) && $_SESSION['user']['role_id']!=2)
	header('location:../../index.php');

		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
		use classes\Implementation\ClosingOfFile as impCof;
		$fetchCof = new impCof\Fetch();
		$throughDetails = $fetchCof->getThroughDetails($_GET['q']);
	//print_r($diaryDetails);
	//echo "hello";
$address_line1=$address_line2=$city=$state=$pincode='';
?>
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
	
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">Legal Aid Application Through</div>
		     		
		     		<div class="left" style="border-right:1px solid #000; padding-right:10px;">
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Name : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal; width:60%;">
		     				 <?php echo $throughDetails[0]['appli_through_name']; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	Designation : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $throughDetails[0]['designation']; ?>
		     			</div>
		     			
		     			<div class="clear"></div>
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Address : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;width:60%; ">
		     				<?php 
		     				
		     				if(isset($throughDetails[0]['address_line1']) && $throughDetails[0]['address_line1']!='')
		     				{
		     					$address_line1=$throughDetails[0]['address_line1'].', ';
		     				}
		     				if(isset($throughDetails[0]['address_line2']) && $throughDetails[0]['address_line2']!='')
		     				{
		     					$address_line2=$throughDetails[0]['address_line2'].', ';
		     				}
		     				if(isset($throughDetails[0]['city']) && $throughDetails[0]['city']!='')
		     				{
		     					$city=$throughDetails[0]['city'].', ';
		     				}
		     					if(isset($throughDetails[0]['state']) && $throughDetails[0]['state']!='')
		     				 {
		     				$state=$throughDetails[0]['state'];
		     				}
		     				if(isset($throughDetails[0]['pincode']) && $throughDetails[0]['pincode']!='')
		     				{
		     					$pincode=', '.$throughDetails[0]['pincode'];
		     				}   				
		     				
		     				 echo $address_line1.$address_line2.$city.$state.$pincode; 
		     				
		     				?>
		     			</div>
		     			
		     		</div>     		
		     	<div class="left"  style="padding-right:10px;">
		     			<div class="left" style="width:30%;text-align:left;">
		     			<b>	Email ID  : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal; width:60%;">
		     				<?php echo $throughDetails[0]['email_id']; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="left" style="text-align:left;width:30%;">
		     			<b>	Contact No. : </b>
		     			</div>
		     			<div class="right" style="text-align: left;white-space: normal;margin-top:5px;">
		     				<?php echo $throughDetails[0]['contact_no']; ?>	
		     			</div>    			
		     			
		     			
		     		</div>    
		     	

		     		
		     		
		     				